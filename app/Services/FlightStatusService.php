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
        $this->cacheTtl     = max(60, (int) config('aviationstack.cache_ttl', 7200));
        $this->airportIata  = config('aviationstack.airport_iata', 'REG');

        $this->airlabsKey   = config('aviationstack.airlabs_api_key');
        $this->airlabsUrl   = 'https://airlabs.co/api/v9';

        $this->aviationKey  = config('aviationstack.api_key');
        $this->aviationUrl  = config('aviationstack.base_url', 'https://api.aviationstack.com/v1');
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

    public function getDepartureFeed(): array
    {
        return $this->getLiveFeed('departure')['flights'];
    }

    public function getArrivalFeed(): array
    {
        return $this->getLiveFeed('arrival')['flights'];
    }

    public function isFeedAvailable(string $type): bool
    {
        return $this->getLiveFeed($type)['available'];
    }

    public function getFeedUpdatedAt(string $type): string
    {
        return $this->getLiveFeed($type)['fetched_at'] ?? now()->format('H:i');
    }

    protected function getLiveFeed(string $type): array
    {
        return Cache::remember(
            "flight_feed.v2.{$type}.{$this->airportIata}",
            $this->cacheTtl,
            fn () => $this->fetchLiveFeed($type)
        );
    }

    protected function fetchLiveFeed(string $type): array
    {
        if ($this->airlabsKey) {
            $flights = $this->fetchFlightsFromAirLabs($type);
            if ($flights !== null) {
                return ['available' => true, 'fetched_at' => now()->format('H:i'), 'flights' => $flights];
            }
        }

        if ($this->aviationKey) {
            $flights = $this->fetchFlightsFromAviationStack($type);
            if ($flights !== null) {
                return ['available' => true, 'fetched_at' => now()->format('H:i'), 'flights' => $flights];
            }
        }

        Log::warning('Feed voli live non disponibile', ['type' => $type]);
        return ['available' => false, 'fetched_at' => now()->format('H:i'), 'flights' => []];
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

    protected function fetchFlightsFromAirLabs(string $type): ?array
    {
        try {
            $paramKey = $type === 'departure' ? 'dep_iata' : 'arr_iata';
            $response = Http::timeout(8)->get("{$this->airlabsUrl}/schedules", [
                'api_key' => $this->airlabsKey,
                $paramKey => $this->airportIata,
            ]);

            if ($response->failed() || ! is_array($response->json('response'))) return null;

            $result = [];
            foreach ($response->json('response') as $flight) {
                $number = strtoupper(trim($flight['flight_iata'] ?? ''));
                if ($number === '') continue;
                $result[$number] = $this->normalizeAirLabsFlight($flight, $type);
            }

            return $this->sortFlights(array_values($result));
        } catch (\Throwable $e) {
            Log::error('AirLabs feed: eccezione', ['error' => $e->getMessage()]);
            return null;
        }
    }

    protected function normalizeAirLabsFlight(array $flight, string $type): array
    {
        $status = $this->normalizeStatus($flight['status'] ?? 'scheduled');
        $delay = (int) ($flight['delayed'] ?? 0);
        $remote = $type === 'departure' ? 'arr' : 'dep';
        $scheduled = $type === 'departure' ? ($flight['dep_time'] ?? null) : ($flight['arr_time'] ?? null);
        $actual = $type === 'departure' ? ($flight['dep_actual_utc'] ?? null) : ($flight['arr_actual_utc'] ?? null);
        $estimated = $type === 'departure' ? ($flight['dep_estimated_utc'] ?? null) : ($flight['arr_estimated_utc'] ?? null);

        return [
            'flight_number' => $this->formatFlightNumber($flight['flight_iata'] ?? ''),
            'airline_name' => $flight['airline_name'] ?? $flight['airline_iata'] ?? 'Compagnia aerea',
            'airline_iata' => $flight['airline_iata'] ?? null,
            'airport_name' => $flight["{$remote}_name"] ?? $flight["{$remote}_iata"] ?? '-',
            'airport_iata' => $flight["{$remote}_iata"] ?? '-',
            'scheduled_time' => $this->parseLocalTime($scheduled) ?? '--:--',
            'terminal' => $flight['dep_terminal'] ?? $flight['arr_terminal'] ?? null,
            'gate' => $flight['dep_gate'] ?? $flight['arr_gate'] ?? null,
            'status' => $status,
            'delay_minutes' => $delay,
            'actual_time' => $this->parseUtcTime($actual),
            'estimated_time' => $this->parseUtcTime($estimated),
            'status_badge' => $this->statusBadge($status, $delay),
            'live_status' => true,
        ];
    }

    protected function fetchFlightsFromAviationStack(string $type): ?array
    {
        try {
            $paramKey = $type === 'departure' ? 'dep_iata' : 'arr_iata';
            $response = Http::timeout(8)->get("{$this->aviationUrl}/flights", [
                'access_key' => $this->aviationKey,
                $paramKey => $this->airportIata,
                'limit' => 100,
            ]);
            if ($response->failed() || ! is_array($response->json('data'))) return null;

            $result = [];
            foreach ($response->json('data') as $flight) {
                $number = strtoupper(trim($flight['flight']['iata'] ?? ''));
                if ($number === '') continue;
                $port = $type === 'departure' ? ($flight['departure'] ?? []) : ($flight['arrival'] ?? []);
                $remote = $type === 'departure' ? ($flight['arrival'] ?? []) : ($flight['departure'] ?? []);
                $status = $this->normalizeStatus($flight['flight_status'] ?? 'scheduled');
                $delay = (int) ($port['delay'] ?? 0);
                $result[$number] = [
                    'flight_number' => $this->formatFlightNumber($number),
                    'airline_name' => $flight['airline']['name'] ?? $flight['airline']['iata'] ?? 'Compagnia aerea',
                    'airline_iata' => $flight['airline']['iata'] ?? null,
                    'airport_name' => $remote['airport'] ?? $remote['iata'] ?? '-',
                    'airport_iata' => $remote['iata'] ?? '-',
                    'scheduled_time' => $this->parseLocalTime($port['scheduled'] ?? null) ?? '--:--',
                    'terminal' => $port['terminal'] ?? null,
                    'gate' => $port['gate'] ?? null,
                    'status' => $status,
                    'delay_minutes' => $delay,
                    'actual_time' => $this->parseLocalTime($port['actual'] ?? null),
                    'estimated_time' => $this->parseLocalTime($port['estimated'] ?? null),
                    'status_badge' => $this->statusBadge($status, $delay),
                    'live_status' => true,
                ];
            }
            return $this->sortFlights(array_values($result));
        } catch (\Throwable $e) {
            Log::error('AviationStack feed: eccezione', ['error' => $e->getMessage()]);
            return null;
        }
    }

    protected function sortFlights(array $flights): array
    {
        usort($flights, fn (array $a, array $b) => strcmp($a['scheduled_time'], $b['scheduled_time']));
        return $flights;
    }

    protected function normalizeStatus(string $status): string
    {
        return match (strtolower($status)) {
            'active' => 'active',
            'landed' => 'landed',
            'cancelled' => 'cancelled',
            'diverted' => 'diverted',
            default => 'scheduled',
        };
    }

    protected function parseLocalTime(?string $value): ?string
    {
        if (! $value) return null;
        try {
            return \Carbon\Carbon::parse($value, 'Europe/Rome')->setTimezone('Europe/Rome')->format('H:i');
        } catch (\Throwable) {
            return null;
        }
    }

    protected function formatFlightNumber(string $raw): string
    {
        return preg_replace('/^([A-Z]{2,3})(\d+)$/', '$1 $2', strtoupper(trim($raw))) ?: $raw;
    }

    // ─────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────

    protected function parseUtcTime(?string $utc): ?string
    {
        if (! $utc) return null;
        try {
            return \Carbon\Carbon::parse($utc, 'UTC')->setTimezone('Europe/Rome')->format('H:i');
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
