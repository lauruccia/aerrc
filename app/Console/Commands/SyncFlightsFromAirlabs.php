<?php

namespace App\Console\Commands;

use App\Models\FlightSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Sincronizza i voli di oggi dall'API AirLabs nel database locale.
 *
 * Utilizzo:
 *   php artisan flights:sync            → sincronizza il giorno corrente
 *   php artisan flights:sync --dry-run  → mostra cosa importerebbe senza scrivere
 *
 * Schedulazione consigliata (routes/console.php):
 *   Schedule::command('flights:sync')->dailyAt('04:30');
 *
 * Logica:
 *   1. Chiama AirLabs /schedules per arrivi e partenze di REG
 *   2. Filtra i duplicati (AirLabs restituisce ogni volo con e senza IATA)
 *   3. Cancella i record "daily-sync" del giorno (valid_from = valid_to = oggi)
 *   4. Inserisce i nuovi record — gli orari programmati stagionali manuali
 *      (valid_to > oggi) restano intatti nel DB come fallback
 */
class SyncFlightsFromAirlabs extends Command
{
    protected $signature = 'flights:sync {--dry-run : Mostra i voli senza scrivere nel DB}';
    protected $description = 'Sincronizza i voli del giorno da AirLabs nel database';

    // ── Lookup nomi compagnie ──────────────────────────────────────
    private const AIRLINES = [
        'FR' => 'Ryanair',
        'AZ' => 'ITA Airways',
        'KL' => 'KLM',
        'W6' => 'Wizz Air',
        'U2' => 'easyJet',
        'VY' => 'Vueling',
        'IB' => 'Iberia',
        'LH' => 'Lufthansa',
        'BA' => 'British Airways',
        'TP' => 'TAP Air Portugal',
        'EI' => 'Aer Lingus',
        'BT' => 'airBaltic',
        'LO' => 'LOT Polish Airlines',
        'OS' => 'Austrian Airlines',
        'SK' => 'SAS',
        'DY' => 'Norwegian',
    ];

    // ── Lookup nomi aeroporti ──────────────────────────────────────
    private const AIRPORTS = [
        'MXP' => 'Milano Malpensa',
        'LIN' => 'Milano Linate',
        'FCO' => 'Roma Fiumicino',
        'CIA' => 'Roma Ciampino',
        'BGY' => 'Milano Bergamo',
        'TRN' => 'Torino Caselle',
        'BLQ' => 'Bologna Guglielmo Marconi',
        'PSA' => 'Pisa Galileo Galilei',
        'VCE' => 'Venezia Marco Polo',
        'TSF' => 'Venezia Treviso',
        'BVA' => 'Parigi Beauvais',
        'CDG' => 'Parigi Charles de Gaulle',
        'ORY' => 'Parigi Orly',
        'BCN' => 'Barcellona El Prat',
        'STN' => 'Londra Stansted',
        'LGW' => 'Londra Gatwick',
        'LHR' => 'Londra Heathrow',
        'LTN' => 'Londra Luton',
        'BER' => 'Berlino Brandenburg',
        'FRA' => 'Francoforte',
        'AMS' => 'Amsterdam Schiphol',
        'BRU' => 'Bruxelles',
        'ZRH' => 'Zurigo',
        'GVA' => 'Ginevra',
        'MAD' => 'Madrid Barajas',
        'PMO' => 'Palermo',
        'CTA' => 'Catania',
        'BRI' => 'Bari',
        'NAP' => 'Napoli',
        'ATH' => 'Atene',
        'OTP' => 'Bucarest',
        'WAW' => 'Varsavia',
        'VIE' => 'Vienna',
        'DUB' => 'Dublino',
        'CPH' => 'Copenaghen',
        'ARN' => 'Stoccolma',
        'HEL' => 'Helsinki',
        'LIS' => 'Lisbona',
        'OPO' => 'Porto',
    ];

    public function handle(): int
    {
        $apiKey    = env('AIRLABS_API_KEY');
        $iata      = env('AIRPORT_IATA', 'REG');
        $isDryRun  = $this->option('dry-run');
        $today     = Carbon::today();
        $isoDay    = (int) $today->isoFormat('E');

        if (! $apiKey) {
            $this->error('AIRLABS_API_KEY non configurata nel .env');
            return Command::FAILURE;
        }

        $this->info("✈  flights:sync — {$today->format('d/m/Y')} (giorno ISO: {$isoDay})");
        if ($isDryRun) {
            $this->warn('   [DRY RUN — nessuna scrittura nel DB]');
        }

        // ── 1. Fetch arrivi e partenze in parallelo ────────────────
        [$arrivals, $departures] = $this->fetchFlights($apiKey, $iata);

        if ($arrivals === null || $departures === null) {
            $this->error('Impossibile recuperare i dati da AirLabs. Controlla la chiave API e la connessione.');
            return Command::FAILURE;
        }

        // ── 2. Normalizza ─────────────────────────────────────────
        $toInsert = array_merge(
            $this->normalizeFlights($arrivals,   'arrival',   $iata, $today, $isoDay),
            $this->normalizeFlights($departures, 'departure', $iata, $today, $isoDay),
        );

        $this->info("   Voli da importare: " . count($toInsert));

        // Una risposta HTTP valida ma vuota non deve mai cancellare il
        // calendario locale. Può capitare per limiti/quota del provider o
        // durante il cambio data nel suo fuso orario.
        if (empty($toInsert)) {
            $this->error('AirLabs non ha restituito voli: calendario esistente mantenuto.');
            Log::warning('flights:sync — risposta vuota, database non modificato', [
                'date' => $today->toDateString(),
            ]);
            return Command::FAILURE;
        }

        if ($isDryRun) {
            $this->table(
                ['Num.', 'Tipo', 'Aeroporto', 'Orario', 'Airline', 'Stato'],
                array_map(fn($f) => [
                    $f['flight_number'],
                    $f['type'],
                    $f['airport_iata'],
                    $f['scheduled_time'],
                    $f['airline_iata'],
                    '(non scritto)',
                ], $toInsert)
            );
            return Command::SUCCESS;
        }

        // ── 3. Sostituisce soltanto l'import giornaliero ──────────
        // Il calendario stagionale resta sempre disponibile come fallback,
        // anche dopo mezzanotte o quando il provider non è raggiungibile.
        DB::transaction(function () use ($today, $toInsert) {
            FlightSchedule::query()
                ->whereDate('valid_from', $today->toDateString())
                ->whereDate('valid_to', $today->toDateString())
                ->delete();

            $now = now();
            $rows = array_map(fn($f) => array_merge($f, [
                'created_at' => $now,
                'updated_at' => $now,
            ]), $toInsert);

            FlightSchedule::insert($rows);
        });

        $this->info("   ✅ Sincronizzazione completata: " . count($toInsert) . " voli inseriti.");
        Log::info('flights:sync completato', ['date' => $today->toDateString(), 'count' => count($toInsert)]);

        return Command::SUCCESS;
    }

    // ─────────────────────────────────────────────────────────────
    // Fetch da AirLabs
    // ─────────────────────────────────────────────────────────────

    private function fetchFlights(string $apiKey, string $iata): array
    {
        try {
            $arrResponse = Http::timeout(12)->get('https://airlabs.co/api/v9/schedules', [
                'api_key'  => $apiKey,
                'arr_iata' => $iata,
            ]);

            $depResponse = Http::timeout(12)->get('https://airlabs.co/api/v9/schedules', [
                'api_key'  => $apiKey,
                'dep_iata' => $iata,
            ]);

            if ($arrResponse->failed() || $depResponse->failed()) {
                Log::error('flights:sync — risposta AirLabs non OK', [
                    'arr_status' => $arrResponse->status(),
                    'dep_status' => $depResponse->status(),
                ]);
                return [null, null];
            }

            // Controlla errori API-level (es. chiave non valida)
            $arrBody = $arrResponse->json();
            $depBody = $depResponse->json();

            if (isset($arrBody['error'])) {
                $this->error('AirLabs errore: ' . ($arrBody['error']['message'] ?? json_encode($arrBody['error'])));
                return [null, null];
            }

            return [
                $arrBody['response'] ?? [],
                $depBody['response'] ?? [],
            ];

        } catch (\Throwable $e) {
            Log::error('flights:sync — eccezione HTTP', ['error' => $e->getMessage()]);
            return [null, null];
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Normalizza un array di voli AirLabs → righe DB
    // ─────────────────────────────────────────────────────────────

    private function normalizeFlights(
        array  $flights,
        string $type,
        string $airportIata,
        Carbon $today,
        int    $isoDay
    ): array {
        // Priorità compagnie: FR e AZ vengono prima degli sconosciuti
        // così nella dedup per rotta+orario teniamo sempre il volo operativo
        usort($flights, function ($a, $b) {
            $knownA = isset(self::AIRLINES[$a['airline_iata'] ?? '']) ? 0 : 1;
            $knownB = isset(self::AIRLINES[$b['airline_iata'] ?? '']) ? 0 : 1;
            return $knownA - $knownB;
        });

        $seenByNum   = [];  // dedup per numero volo
        $seenByRoute = [];  // dedup per rotta+orario (elimina codeshare)
        $result      = [];

        foreach ($flights as $f) {
            // Salta se manca il codice IATA del volo (AirLabs restituisce ogni
            // volo due volte: una con IATA e una con solo ICAO)
            $flightIata = strtoupper(trim($f['flight_iata'] ?? ''));
            if (! $flightIata) {
                continue;
            }

            // Deduplica per numero volo
            $dedupKey = "{$type}_{$flightIata}";
            if (isset($seenByNum[$dedupKey])) {
                continue;
            }
            $seenByNum[$dedupKey] = true;

            // Aeroporto remoto (destinazione o provenienza)
            $remoteIata = $type === 'arrival'
                ? strtoupper($f['dep_iata'] ?? '')
                : strtoupper($f['arr_iata'] ?? '');

            if (! $remoteIata || $remoteIata === $airportIata) {
                continue; // skip se manca o uguale all'aeroporto locale
            }

            // Orario schedulato nel fuso di Roma
            $timeField  = $type === 'arrival' ? 'arr_time' : 'dep_time';
            $rawTime    = $f[$timeField] ?? null;
            $scheduledTime = $rawTime
                ? Carbon::parse($rawTime)->format('H:i:s')
                : '00:00:00';

            // Deduplica codeshare: stesso aeroporto + stesso orario → tieni solo il primo
            $routeKey = "{$type}_{$remoteIata}_{$scheduledTime}";
            if (isset($seenByRoute[$routeKey])) {
                continue;
            }
            $seenByRoute[$routeKey] = true;

            // Airline
            $airlineIata = strtoupper($f['airline_iata'] ?? '');
            $airlineName = self::AIRLINES[$airlineIata] ?? $airlineIata;

            // Nome aeroporto remoto
            $airportName = self::AIRPORTS[$remoteIata] ?? $remoteIata;

            $result[] = [
                'flight_number'  => $flightIata,
                'airline_name'   => $airlineName,
                'airline_iata'   => $airlineIata,
                'type'           => $type,
                'airport_iata'   => $remoteIata,
                'airport_name'   => $airportName,
                'scheduled_time' => $scheduledTime,
                'days_of_week'   => json_encode([1,2,3,4,5,6,7]), // tutti i giorni: la data valid_from=valid_to=oggi fa da filtro
                'valid_from'     => $today->toDateString(),
                'valid_to'       => $today->toDateString(),
                'terminal'       => $f['dep_terminal'] ?? $f['arr_terminal'] ?? '1',
                'is_active'      => true,
            ];
        }

        // Ordina per orario
        usort($result, fn($a, $b) => strcmp($a['scheduled_time'], $b['scheduled_time']));

        return $result;
    }
}
