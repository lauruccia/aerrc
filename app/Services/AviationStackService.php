<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AviationStackService
{
    protected string $baseUrl;
    protected string|null $apiKey;
    protected string $airportIata;

    public function __construct()
    {
        $this->baseUrl   = config('aviationstack.base_url', 'http://api.aviationstack.com/v1');
        $this->apiKey    = config('aviationstack.api_key');
        $this->airportIata = config('aviationstack.airport_iata', 'REG');
    }

    /*
    |--------------------------------------------------------------------------
    | Partenze
    |--------------------------------------------------------------------------
    */
    public function getDepartures(int $limit = 20): Collection
    {
        return Cache::remember("flights.departures.{$this->airportIata}", 300, function () use ($limit) {
            return $this->fetchFlights('departures', $limit);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Arrivi
    |--------------------------------------------------------------------------
    */
    public function getArrivals(int $limit = 20): Collection
    {
        return Cache::remember("flights.arrivals.{$this->airportIata}", 300, function () use ($limit) {
            return $this->fetchFlights('arrivals', $limit);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Core fetch — con fallback a mock data se API key assente
    |--------------------------------------------------------------------------
    */
    protected function fetchFlights(string $type, int $limit): Collection
    {
        if (! $this->apiKey) {
            Log::info('AviationStack: API key non configurata — uso mock data');
            return $this->getMockFlights($type);
        }

        try {
            $paramKey = $type === 'departures' ? 'dep_iata' : 'arr_iata';

            $response = Http::timeout(8)->get("{$this->baseUrl}/flights", [
                'access_key' => $this->apiKey,
                $paramKey    => $this->airportIata,
                'limit'      => $limit,
                'flight_status' => 'active,scheduled',
            ]);

            if ($response->failed()) {
                Log::warning('AviationStack: risposta non OK', ['status' => $response->status()]);
                return $this->getMockFlights($type);
            }

            $data = $response->json('data', []);

            return collect($data)->map(fn($f) => $this->normalizeFlightData($f, $type));

        } catch (\Throwable $e) {
            Log::error('AviationStack: errore fetch', ['error' => $e->getMessage()]);
            return $this->getMockFlights($type);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Normalizzazione dati API → formato interno uniforme
    |--------------------------------------------------------------------------
    */
    protected function normalizeFlightData(array $f, string $type): array
    {
        $isDep = $type === 'departures';

        $airport  = $isDep ? ($f['arrival']   ?? []) : ($f['departure'] ?? []);
        $thisPort = $isDep ? ($f['departure']  ?? []) : ($f['arrival']   ?? []);

        $scheduled = $thisPort['scheduled'] ?? null;
        $actual    = $thisPort['actual']    ?? null;
        $estimated = $thisPort['estimated'] ?? null;
        $delay     = $thisPort['delay']     ?? 0;

        return [
            'flight_number'  => ($f['flight']['iata'] ?? '') ?: ($f['flight']['icao'] ?? '---'),
            'airline_name'   => $f['airline']['name']   ?? 'N/D',
            'airline_iata'   => $f['airline']['iata']   ?? '',
            'airport_name'   => $airport['airport'] ?? 'N/D',
            'airport_iata'   => $airport['iata']    ?? '',
            'airport_city'   => $airport['timezone'] ? explode('/', $airport['timezone'])[1] ?? '' : '',
            'terminal'       => $thisPort['terminal'] ?? null,
            'gate'           => $thisPort['gate']     ?? null,
            'scheduled_time' => $scheduled ? \Carbon\Carbon::parse($scheduled)->format('H:i') : '--:--',
            'actual_time'    => $actual    ? \Carbon\Carbon::parse($actual)->format('H:i')    : null,
            'estimated_time' => $estimated ? \Carbon\Carbon::parse($estimated)->format('H:i') : null,
            'delay_minutes'  => (int) $delay,
            'status'         => $f['flight_status'] ?? 'scheduled',
            'status_badge'   => $this->statusBadge($f['flight_status'] ?? '', (int) $delay),
        ];
    }

    protected function statusBadge(string $status, int $delay): array
    {
        if ($status === 'cancelled') {
            return ['class' => 'badge-cancelled', 'label' => __('flights.status_cancelled')];
        }
        if ($delay > 0) {
            return ['class' => 'badge-delayed', 'label' => __('flights.status_delayed', ['min' => $delay])];
        }
        return ['class' => 'badge-on-time', 'label' => __('flights.status_on_time')];
    }

    /*
    |--------------------------------------------------------------------------
    | Mock data — usato quando non c'è API key
    |--------------------------------------------------------------------------
    */
    public function getMockFlights(string $type = 'departures'): Collection
    {
        $isDep   = $type === 'departures';
        $flights = [
            ['time' => '06:30', 'dest' => 'Milano Malpensa',    'iata' => 'MXP', 'airline' => 'Ryanair',  'num' => 'FR 1234', 'delay' => 0,   'status' => 'active'],
            ['time' => '08:45', 'dest' => 'Londra Stansted',    'iata' => 'STN', 'airline' => 'Ryanair',  'num' => 'FR 4567', 'delay' => 0,   'status' => 'active'],
            ['time' => '10:15', 'dest' => 'Barcellona El Prat', 'iata' => 'BCN', 'airline' => 'Ryanair',  'num' => 'FR 7890', 'delay' => 20,  'status' => 'active'],
            ['time' => '12:00', 'dest' => 'Berlino Brandenburg','iata' => 'BER', 'airline' => 'Ryanair',  'num' => 'FR 2345', 'delay' => 0,   'status' => 'active'],
            ['time' => '14:30', 'dest' => 'Parigi Beauvais',    'iata' => 'BVA', 'airline' => 'Ryanair',  'num' => 'FR 3456', 'delay' => 0,   'status' => 'active'],
            ['time' => '16:45', 'dest' => 'Bologna',            'iata' => 'BLQ', 'airline' => 'Ryanair',  'num' => 'FR 5678', 'delay' => 0,   'status' => 'active'],
            ['time' => '19:00', 'dest' => 'Roma Fiumicino',     'iata' => 'FCO', 'airline' => 'ITA Airways','num' => 'AZ 1589','delay' => 0,  'status' => 'active'],
            ['time' => '21:15', 'dest' => 'Torino',             'iata' => 'TRN', 'airline' => 'Ryanair',  'num' => 'FR 6789', 'delay' => 0,   'status' => 'active'],
        ];

        return collect($flights)->map(fn($f) => [
            'flight_number'  => $f['num'],
            'airline_name'   => $f['airline'],
            'airline_iata'   => '',
            'airport_name'   => $f['dest'],
            'airport_iata'   => $f['iata'],
            'airport_city'   => $f['dest'],
            'terminal'       => '1',
            'gate'           => null,
            'scheduled_time' => $f['time'],
            'actual_time'    => null,
            'estimated_time' => null,
            'delay_minutes'  => $f['delay'],
            'status'         => $f['status'],
            'status_badge'   => $this->statusBadge($f['status'], $f['delay']),
        ]);
    }
}
