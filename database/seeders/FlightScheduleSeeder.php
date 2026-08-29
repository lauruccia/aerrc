<?php

namespace Database\Seeders;

use App\Models\FlightSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Orari stagionali reali Aeroporto di Reggio Calabria (IATA: REG / ICAO: LICR)
 *
 * ── STAGIONI IATA ──────────────────────────────────────────────────────────────
 * Summer: ultima domenica di marzo → ultimo sabato di ottobre
 * Winter: ultima domenica di ottobre → ultimo sabato di marzo dell'anno successivo
 *
 * Questo seeder calcola AUTOMATICAMENTE le stagioni in base alla data corrente,
 * coprendo le ultime 2 stagioni passate + la stagione corrente + le prossime 2.
 * In questo modo non scade mai senza intervento manuale.
 *
 * Fonte orari: Ryanair, ITA Airways, aeroporti.calabria.it
 * ──────────────────────────────────────────────────────────────────────────────
 */
class FlightScheduleSeeder extends Seeder
{
    // ──────────────────────────────────────────────────────────────────────────
    // Definizione rotte (indipendenti dalla stagione)
    // Formato: [flight_number, airline_name, airline_iata, type,
    //           airport_iata, airport_name, scheduled_time, terminal,
    //           days_of_week, seasons]
    //
    // seasons: array di stringhe che indicano in quali stagioni è attivo
    //   's' = Summer | 'w' = Winter | 'sw' = entrambe
    // ──────────────────────────────────────────────────────────────────────────
    protected array $routes = [

        // ═══════════════════════════════════════════════
        //  PARTENZE DA REG
        // ═══════════════════════════════════════════════

        // Ryanair REG → MXP (Milano Malpensa)
        [
            'flight_number'  => 'FR4398',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'MXP',
            'airport_name'   => 'Milano Malpensa',
            'scheduled_time' => '06:25',
            'terminal'       => '1',
            'days_of_week'   => [1, 3, 5, 7],   // Lun Mer Ven Dom
            'seasons'        => ['sw'],
        ],

        // Ryanair REG → STN (Londra Stansted)
        [
            'flight_number'  => 'FR4614',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'STN',
            'airport_name'   => 'Londra Stansted',
            'scheduled_time' => '08:10',
            'terminal'       => '1',
            'days_of_week'   => [2, 4, 6],       // Mar Gio Sab (summer)
            'days_winter'    => [2, 6],           // Mar Sab (winter ridotto)
            'seasons'        => ['sw'],
        ],

        // Ryanair REG → BCN (Barcellona El Prat)
        [
            'flight_number'  => 'FR4752',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'BCN',
            'airport_name'   => 'Barcellona El Prat',
            'scheduled_time' => '10:35',
            'terminal'       => '1',
            'days_of_week'   => [1, 5],           // Lun Ven
            'seasons'        => ['s'],             // solo summer
        ],

        // Ryanair REG → BER (Berlino Brandenburg)
        [
            'flight_number'  => 'FR4820',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'BER',
            'airport_name'   => 'Berlino Brandenburg',
            'scheduled_time' => '12:00',
            'terminal'       => '1',
            'days_of_week'   => [3, 6],           // Mer Sab
            'seasons'        => ['s'],
        ],

        // Ryanair REG → BVA (Parigi Beauvais)
        [
            'flight_number'  => 'FR4910',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'BVA',
            'airport_name'   => 'Parigi Beauvais',
            'scheduled_time' => '14:20',
            'terminal'       => '1',
            'days_of_week'   => [2, 4],           // Mar Gio
            'seasons'        => ['s'],
        ],

        // Ryanair REG → BLQ (Bologna)
        [
            'flight_number'  => 'FR4512',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'BLQ',
            'airport_name'   => 'Bologna Guglielmo Marconi',
            'scheduled_time' => '16:45',
            'terminal'       => '1',
            'days_of_week'   => [1, 3, 5],        // Lun Mer Ven
            'seasons'        => ['s'],
        ],

        // Ryanair REG → TRN (Torino Caselle)
        [
            'flight_number'  => 'FR4634',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'departure',
            'airport_iata'   => 'TRN',
            'airport_name'   => 'Torino Caselle',
            'scheduled_time' => '19:10',
            'terminal'       => '1',
            'days_of_week'   => [6, 7],           // Sab Dom
            'seasons'        => ['s'],
        ],

        // ITA Airways REG → FCO (Roma Fiumicino) — giornaliero
        [
            'flight_number'  => 'AZ1589',
            'airline_name'   => 'ITA Airways',
            'airline_iata'   => 'AZ',
            'type'           => 'departure',
            'airport_iata'   => 'FCO',
            'airport_name'   => 'Roma Fiumicino',
            'scheduled_time' => '20:30',
            'terminal'       => '1',
            'days_of_week'   => [1, 2, 3, 4, 5, 6, 7],
            'seasons'        => ['sw'],
        ],

        // ═══════════════════════════════════════════════
        //  ARRIVI A REG
        // ═══════════════════════════════════════════════

        // Ryanair MXP → REG
        [
            'flight_number'  => 'FR4397',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'arrival',
            'airport_iata'   => 'MXP',
            'airport_name'   => 'Milano Malpensa',
            'scheduled_time' => '08:05',
            'terminal'       => '1',
            'days_of_week'   => [1, 3, 5, 7],
            'seasons'        => ['sw'],
        ],

        // Ryanair STN → REG
        [
            'flight_number'  => 'FR4613',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'arrival',
            'airport_iata'   => 'STN',
            'airport_name'   => 'Londra Stansted',
            'scheduled_time' => '12:30',
            'terminal'       => '1',
            'days_of_week'   => [2, 4, 6],
            'days_winter'    => [2, 6],
            'seasons'        => ['sw'],
        ],

        // Ryanair BCN → REG
        [
            'flight_number'  => 'FR4751',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'arrival',
            'airport_iata'   => 'BCN',
            'airport_name'   => 'Barcellona El Prat',
            'scheduled_time' => '14:15',
            'terminal'       => '1',
            'days_of_week'   => [1, 5],
            'seasons'        => ['s'],
        ],

        // Ryanair BER → REG
        [
            'flight_number'  => 'FR4819',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'arrival',
            'airport_iata'   => 'BER',
            'airport_name'   => 'Berlino Brandenburg',
            'scheduled_time' => '15:35',
            'terminal'       => '1',
            'days_of_week'   => [3, 6],
            'seasons'        => ['s'],
        ],

        // Ryanair BVA → REG
        [
            'flight_number'  => 'FR4909',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'arrival',
            'airport_iata'   => 'BVA',
            'airport_name'   => 'Parigi Beauvais',
            'scheduled_time' => '17:55',
            'terminal'       => '1',
            'days_of_week'   => [2, 4],
            'seasons'        => ['s'],
        ],

        // Ryanair BLQ → REG
        [
            'flight_number'  => 'FR4511',
            'airline_name'   => 'Ryanair',
            'airline_iata'   => 'FR',
            'type'           => 'arrival',
            'airport_iata'   => 'BLQ',
            'airport_name'   => 'Bologna Guglielmo Marconi',
            'scheduled_time' => '20:20',
            'terminal'       => '1',
            'days_of_week'   => [1, 3, 5],
            'seasons'        => ['s'],
        ],

        // ITA Airways FCO → REG — giornaliero
        [
            'flight_number'  => 'AZ1588',
            'airline_name'   => 'ITA Airways',
            'airline_iata'   => 'AZ',
            'type'           => 'arrival',
            'airport_iata'   => 'FCO',
            'airport_name'   => 'Roma Fiumicino',
            'scheduled_time' => '19:05',
            'terminal'       => '1',
            'days_of_week'   => [1, 2, 3, 4, 5, 6, 7],
            'seasons'        => ['sw'],
        ],
    ];

    // ──────────────────────────────────────────────────────────────────────────
    // run()
    // ──────────────────────────────────────────────────────────────────────────

    public function run(): void
    {
        // Calcola stagioni: 2 passate + corrente + 2 future
        $seasons = $this->computeSeasons(Carbon::now(), past: 2, future: 2);

        $records = [];

        foreach ($this->routes as $route) {
            foreach ($seasons as $season) {
                // Salta se la rotta non è attiva in questa stagione
                $isSummer = $season['type'] === 's';
                $inSeasons = $route['seasons'];

                if ($isSummer && !in_array('s', $inSeasons) && !in_array('sw', $inSeasons)) continue;
                if (!$isSummer && !in_array('w', $inSeasons) && !in_array('sw', $inSeasons)) continue;

                // Giorni della settimana (alcuni hanno variante invernale)
                $days = (!$isSummer && isset($route['days_winter']))
                    ? $route['days_winter']
                    : $route['days_of_week'];

                $records[] = [
                    'flight_number'  => $route['flight_number'],
                    'airline_name'   => $route['airline_name'],
                    'airline_iata'   => $route['airline_iata'],
                    'type'           => $route['type'],
                    'airport_iata'   => $route['airport_iata'],
                    'airport_name'   => $route['airport_name'],
                    'scheduled_time' => $route['scheduled_time'],
                    // Eloquent applica il cast array del model; passare JSON qui
                    // produrrebbe una stringa doppiamente codificata.
                    'days_of_week'   => $days,
                    'valid_from'     => $season['from'],
                    'valid_to'       => $season['to'],
                    'terminal'       => $route['terminal'],
                    'is_active'      => true,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }

        // Update non distruttivo: ripristina/aggiorna il calendario stagionale
        // senza rimuovere import giornalieri o voli inseriti dal backoffice.
        // updateOrCreate non richiede un indice UNIQUE già presente in produzione.
        foreach ($records as $record) {
            FlightSchedule::updateOrCreate(
                [
                    'flight_number' => $record['flight_number'],
                    'type'          => $record['type'],
                    'valid_from'    => $record['valid_from'],
                    'valid_to'      => $record['valid_to'],
                ],
                $record
            );
        }

        $count = FlightSchedule::count();
        $seasonLabels = array_map(fn($s) => $s['label'], $seasons);

        // $this->command può essere null se il seeder è chiamato da web (rotta admin)
        if ($this->command) {
            $this->command->info("✅ FlightScheduleSeeder: {$count} record inseriti.");
            $this->command->line('   Stagioni coperte: ' . implode(', ', $seasonLabels));
            $this->command->line('   ➜ Nessuna scadenza manuale: il seeder ricalcola automaticamente le stagioni.');
        }
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Calcolo stagioni IATA dinamico
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Restituisce un array di stagioni IATA calcolate dinamicamente.
     * Ogni elemento: ['type'=>'s'|'w', 'from'=>'YYYY-MM-DD', 'to'=>'YYYY-MM-DD', 'label'=>string]
     *
     * Regola IATA:
     *  Summer: da ultima domenica di marzo → sabato prima dell'ultima domenica di ottobre
     *  Winter: da ultima domenica di ottobre → sabato prima dell'ultima domenica di marzo
     */
    protected function computeSeasons(Carbon $ref, int $past, int $future): array
    {
        // Trova la stagione corrente e costruisce una lista di stagioni
        $currentYear = (int) $ref->format('Y');
        $seasons     = [];

        // Genera stagioni per un range di anni sufficiente
        $startYear = $currentYear - ($past + 1);
        $endYear   = $currentYear + ($future + 1);

        $allSeasons = [];
        for ($y = $startYear; $y <= $endYear; $y++) {
            $summerStart = $this->lastSundayOf($y, 3);           // ultima dom. marzo
            $summerEnd   = $this->lastSundayOf($y, 10)->subDay(); // sabato prima ult. dom. ottobre
            $winterStart = $this->lastSundayOf($y, 10);           // ultima dom. ottobre
            $winterEnd   = $this->lastSundayOf($y + 1, 3)->subDay(); // sabato prima ult. dom. marzo+1

            $allSeasons[] = [
                'type'  => 's',
                'from'  => $summerStart->toDateString(),
                'to'    => $summerEnd->toDateString(),
                'label' => "Summer {$y}",
                'start' => $summerStart,
            ];
            $allSeasons[] = [
                'type'  => 'w',
                'from'  => $winterStart->toDateString(),
                'to'    => $winterEnd->toDateString(),
                'label' => "Winter {$y}-" . ($y + 1),
                'start' => $winterStart,
            ];
        }

        // Ordina per data di inizio
        usort($allSeasons, fn($a, $b) => $a['start'] <=> $b['start']);

        // Trova l'indice della stagione corrente
        $currentIdx = 0;
        foreach ($allSeasons as $i => $s) {
            if ($ref->between(Carbon::parse($s['from']), Carbon::parse($s['to']))) {
                $currentIdx = $i;
                break;
            }
        }

        // Prendi past + current + future
        $from = max(0, $currentIdx - $past);
        $to   = min(count($allSeasons) - 1, $currentIdx + $future);

        $selected = array_slice($allSeasons, $from, $to - $from + 1);

        // Rimuovi il campo helper 'start' prima di restituire
        return array_map(function ($s) {
            unset($s['start']);
            return $s;
        }, $selected);
    }

    /**
     * Restituisce l'ultima domenica del mese $month dell'anno $year.
     * Algoritmo: parte dall'ultimo giorno del mese e scorre all'indietro
     * fino a trovare una domenica.
     */
    protected function lastSundayOf(int $year, int $month): Carbon
    {
        $day = Carbon::create($year, $month)->endOfMonth()->startOfDay();

        while ($day->dayOfWeek !== Carbon::SUNDAY) {
            $day->subDay();
        }

        return $day;
    }
}
