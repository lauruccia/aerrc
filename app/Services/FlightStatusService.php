<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Recupera lo stato live dei voli (ritardi, cancellazioni, orario effettivo)
 * usando AirLabs come provider principale e AviationStack come fallback.
 *
 * Viene chiamato UNA SOLA VOLTA all'ora per tipo (partenze / arrivi),
 * il risultato è cachato 60 minuti → ~720 chiamate/mese, ben dentro
 * il free tier di AirLabs (1.000/mese).
 */
class FlightStatusService
{
    // Cache TTL: 60 minuti (modifica in .env con FLIGHT_STATUS_CACHE_TTL)
    protected int    $cacheTtl;
    protected string $airportIata;

    // AirLabs
    protected string|null $airlabsKey;
    protected string $airlabsUrl;

    // AviationStack (fallback)
    protected string|null $aviationKey;
    protected string $aviationUrl;

    public function __construct()
    {
        $this->cacheTtl     = (int) env('FLIGHT_STATUS_CACHE_TTL', 3600);
        $this->airportIata  = env('AIRPORT_IATA', 'REG');

        $this->airlabsKey   = env('AIRLABS_API_KEY');
        $this->airlabsUrl   = 'https://airlabs.co/api/v9';

        $this->aviationKey  = env('AVIATIONSTACK_API_KEY');
        $this->aviationUrl  = env('AVIATIONSTACK_BASE_URL', 'https://api.aviationstack.com/v1');
    }

    // ─────────────────────────────────────────────────────────────
    // API pubblica
    // ─────────────────────────────────────────────────────────────

    /**
     * Mappa stato partenze: ['FR4398' => [...status...], ...]
     */
    public function getDepartureStatusMap(): array
    {
        return Cache::remember(
            "flight_status.departure.{$this->airportIata}",
            $this->cacheTtl,
            fn() => $this->fetchStatusMap('departure')
        );
    }

    /**
     * Mappa stato arrivi: ['FR4397' => [...status...], ...]
     */
    public function getArrivalStatusMap(): array
    {
        return Cache::remember(
            "flight_status.arrival.{$this->airportIata}",
            $this->cacheTtl,
            fn() => $this->fetchStatusMap('arrival')
        );
    }

    // ─────────────────────────────────────────────────────────────
    // Fetch con fallback chain
    // ─────────────────────────────────────────────────────────────

    protected function fetchStatusMap(string $type): array
    {
        // 1. Prova AirLabs
        if ($this->airlabsKey) {
            $map = $this->fetchFromAirLabs($type);
            if (! empty($map)) {
                Log::info("FlightStatus: AirLabs OK ({$type}, " . count($map) . " voli)");
                return $map;
            }
        }

        // 2. Fallback AviationStack
        if ($this->aviationKey) {
            $map = $this->fetchFromAviationStack($type);
            if (! empty($map)) {
                Log::info("FlightStatus: AviationStack fallback OK ({$type})");
                return $map;
            }
        }

        // 3. Nessuna API disponibile → mappa vuota (HybridFlightService userà "Previsto")
        Log::info("FlightStatus: nessuna API configurata — stato predefinito");
        return [];
    }

    // ─────────────────────────────────────────────────────────────
    // AirLabs
    // ─────────────────────────────────────────────────────────────

    protected function fetchFromAirLabs(string $type): array
    {
        try {
            $paramKey = $type === 'departure' ? 'dep_iata' : 'arr_iata';

            $response = Http::timeout(8)->get("{$this->airlabsUrl}/schedules", [
                'api_key'  => $this->airlabsKey,
                $paramKey  => $this->airportIata,
            ]);

            if ($response->failed()) {
                Log::warning('AirLabs: risposta non OK', ['status' => $response->status()]);
                return [];
            }

            $flights = $response->json('response', []);
            if (empty($flights)) return [];

            $map = [];
            foreach ($flights as $f) {
                $flightNum = strtoupper(trim($f['flight_iata'] ?? ''));
                if (! $flightNum) continue;

                $map[$flightNum] = $this->normalizeAirLabsStatus($f, $type);
            }

            return $map;

        } catch (\Throwable $e) {
            Log::error('AirLabs: eccezione', ['error' => $e->getMessage()]);
            return [];
        }
    }

    protected function normalizeAirLabsStatus(array $f, string $type): array
    {
        $delayed   = (int) ($f['delayed']   ?? 0);
        $status    = strtolower($f['status'] ?? 'scheduled');

        // AirLabs restituisce: scheduled, active, landed, cancelled, diverted
        $mappedStatus = match ($status) {
            'active'    => 'active',
            'landed'    => 'landed',
            'cancelled' => 'cancelled',
            'diverted'  => 'diverted',
            default     => 'scheduled',
        };

        $timeKey   = $type === 'departure' ? 'dep_time_utc' : 'arr_time_utc';
        $actualKey = $type === 'departure' ? 'dep_actual_utc' : 'arr_actual_utc';
        $estKey    = $type === 'departure' ? 'dep_estimated_utc' : 'arr_estimated_utc';

        return [
            'status'         => $mappedStatus,
            'delay_minutes'  => $delayed,
            'actual_time'    => $this->parseUtcTime($f[$actualKey] ?? null),
            'estimated_time' => $this->parseUtcTime($f[$estKey]    ?? null),
            'gate'           => $f['dep_gate'] ?? $f['arr_gate'] ?? null,
            'terminal'       => $f['dep_terminal'] ?? $f['arr_terminal'] ?? null,
            'status_badge'   => $this->statusBadge($mappedStatus, $delayed),
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // AviationStack (fallback)
    // ─────────────────────────────────────────────────────────────

    protected function fetchFromAviationStack(string $type): array
    {
        try {
            $paramKey = $type === 'departure' ? 'dep_iata' : 'arr_iata';

            $response = Http::timeout(8)->get("{$this->aviationUrl}/flights", [
                'access_key'    => $this->aviationKey,
                $paramKey       => $this->airportIata,
                'limit'         => 50,
                'flight_status' => 'active,scheduled',
            ]);

            if ($response->failed()) return [];

            $flights = $response->json('data', []);
            $map = [];

            foreach ($flights as $f) {
                $flightNum = strtoupper(trim($f['flight']['iata'] ?? ''));
                if (! $flightNum) continue;

                $port    = $type === 'departure' ? ($f['departure'] ?? []) : ($f['arrival'] ?? []);
                $delay   = (int) ($port['delay'] ?? 0);
                $status  = $f['flight_status'] ?? 'scheduled';

                $map[$flightNum] = [
                    'status'         => $status,
                    'delay_minutes'  => $delay,
                    'actual_time'    => isset($port['actual'])    ? \Carbon\Carbon::parse($port['actual'])->format('H:i')    : null,
                    'estimated_time' => isset($port['estimated']) ? \Carbon\Carbon::parse($port['estimated'])->format('H:i') : null,
                    'gate'           => $port['gate']     ?? null,
                    'terminal'       => $port['terminal'] ?? null,
                    'status_badge'   => $this->statusBadge($status, $delay),
                ];
            }

            return $map;

        } catch (\Throwable $e) {
            Log::error('AviationStack fallback: eccezione', ['error' => $e->getMessage()]);
            return [];
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────

    protected function parseUtcTime(?string $utc): ?string
    {
        if (! $utc) return null;
        try {
            return \Carbon\Carbon::parse($utc)->setTimezone('Europe/Rome')->format('H:i');
        } catch (\Throwable) {
            return null;
        }
    }

    public function statusBadge(string $status, int $delay): array
    {
        if ($status === 'cancelled' || $status === 'diverted') {
            return ['class' => 'badge-cancelled', 'label' => __('flights.status_cancelled')];
        }
        if ($status === 'landed') {
            return ['class' => 'badge-landed', 'label' => __('flights.status_landed')];
        }
        if ($status === 'active') {
            return ['class' => 'badge-active', 'label' => __('flights.status_active')];
        }
        if ($delay > 0) {
            return ['class' => 'badge-delayed', 'label' => __('flights.status_delayed', ['min' => $delay])];
        }
        return ['class' => 'badge-on-time', 'label' => __('flights.status_on_time')];
    }
}
