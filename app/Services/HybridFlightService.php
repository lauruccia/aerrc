<?php

namespace App\Services;

use App\Models\FlightSchedule;
use Illuminate\Support\Collection;

/**
 * Servizio ibrido: legge gli orari programmati dal database e li arricchisce
 * con lo stato live (ritardi, cancellazioni) prelevato dall'API.
 *
 * Vantaggi rispetto alla sola API:
 *  - Gli orari sono sempre presenti anche senza connessione API
 *  - L'API viene chiamata 1 volta/ora per tipo → ~720 chiamate/mese (free tier OK)
 *  - I dati storici del DB restano anche quando l'API è down
 */
class HybridFlightService
{
    public function __construct(
        protected FlightStatusService $statusService
    ) {}

    // ─────────────────────────────────────────────────────────────
    // API pubblica
    // ─────────────────────────────────────────────────────────────

    public function getDepartures(): Collection
    {
        $schedules  = FlightSchedule::query()->forToday('departure')->get();
        $statusMap  = $this->statusService->getDepartureStatusMap();

        return $this->mergeStatusIntoSchedules($schedules, $statusMap);
    }

    public function getArrivals(): Collection
    {
        $schedules  = FlightSchedule::query()->forToday('arrival')->get();
        $statusMap  = $this->statusService->getArrivalStatusMap();

        return $this->mergeStatusIntoSchedules($schedules, $statusMap);
    }

    // ─────────────────────────────────────────────────────────────
    // Merge DB + API
    // ─────────────────────────────────────────────────────────────

    protected function mergeStatusIntoSchedules(
        \Illuminate\Database\Eloquent\Collection $schedules,
        array $statusMap
    ): Collection {

        return $schedules->map(function (FlightSchedule $flight) use ($statusMap) {

            // Normalizza il numero volo per la ricerca nella mappa API
            $key = strtoupper(str_replace(' ', '', $flight->flight_number)); // 'FR4398'

            $live = $statusMap[$key] ?? null;

            return [
                'flight_number'  => $this->formatFlightNumber($flight->flight_number),
                'airline_name'   => $flight->airline_name,
                'airline_iata'   => $flight->airline_iata,
                'airport_name'   => $flight->airport_name,
                'airport_iata'   => $flight->airport_iata,
                'scheduled_time' => \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i'),
                'terminal'       => $live['terminal'] ?? $flight->terminal,
                'gate'           => $live['gate']     ?? null,

                // Stato live (dall'API) — se non disponibile usa "Previsto"
                'status'         => $live['status']         ?? 'scheduled',
                'delay_minutes'  => $live['delay_minutes']  ?? 0,
                'actual_time'    => $live['actual_time']    ?? null,
                'estimated_time' => $live['estimated_time'] ?? null,
                'status_badge'   => $live['status_badge']   ?? $this->defaultBadge(),

                // Flag: indica se lo stato proviene da API live o è solo schedulato
                'live_status'    => $live !== null,
            ];
        });
    }

    // ─────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────

    /**
     * Formatta 'FR4398' → 'FR 4398' per leggibilità
     */
    protected function formatFlightNumber(string $raw): string
    {
        $raw = strtoupper(trim($raw));
        // Se già ha spazio, lo restituiamo così com'è
        if (str_contains($raw, ' ')) return $raw;
        // Separa prefisso lettere da numero
        preg_match('/^([A-Z]{2,3})(\d+)$/', $raw, $m);
        return isset($m[1]) ? "{$m[1]} {$m[2]}" : $raw;
    }

    protected function defaultBadge(): array
    {
        return ['class' => 'badge-on-time', 'label' => __('flights.status_scheduled')];
    }
}
