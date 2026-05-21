<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherApiController extends Controller
{
    /**
     * Restituisce le condizioni meteo attuali su Reggio Calabria.
     * Fonte: Open-Meteo (gratuito, nessuna API key richiesta).
     * Cache: 30 minuti.
     */
    public function current(): JsonResponse
    {
        $data = Cache::remember('weather.reggiocalabria', 1800, function () {
            return $this->fetchWeather();
        });

        return response()->json([
            'data'       => $data,
            'updated_at' => now()->toISOString(),
        ]);
    }

    protected function fetchWeather(): array
    {
        try {
            $lat = env('WEATHER_LAT', 38.0718);
            $lon = env('WEATHER_LON', 15.6515);

            $response = Http::timeout(6)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude'      => $lat,
                'longitude'     => $lon,
                'current'       => 'temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code',
                'timezone'      => 'Europe/Rome',
                'forecast_days' => 1,
            ]);

            if ($response->ok()) {
                $current = $response->json('current', []);

                return [
                    'temp'      => round($current['temperature_2m']        ?? 22),
                    'humidity'  => $current['relative_humidity_2m']         ?? 65,
                    'wind'      => round($current['wind_speed_10m']         ?? 15),
                    'code'      => $current['weather_code']                 ?? 0,
                    'icon'      => $this->weatherIcon($current['weather_code'] ?? 0),
                    'desc'      => $this->weatherDesc($current['weather_code'] ?? 0),
                    'source'    => 'open-meteo',
                ];
            }
        } catch (\Throwable $e) {
            Log::warning('WeatherApi: fetch fallita', ['error' => $e->getMessage()]);
        }

        // Fallback statico
        return [
            'temp' => 24, 'humidity' => 65, 'wind' => 18,
            'code' => 0, 'icon' => '☀️', 'desc' => 'Soleggiato',
            'source' => 'fallback',
        ];
    }

    protected function weatherIcon(int $code): string
    {
        return match (true) {
            $code === 0 => '☀️',
            $code <= 3  => '⛅',
            $code <= 48 => '🌫️',
            $code <= 67 => '🌧️',
            $code <= 77 => '❄️',
            $code <= 82 => '🌦️',
            $code <= 99 => '⛈️',
            default     => '🌤️',
        };
    }

    protected function weatherDesc(int $code): string
    {
        return match (true) {
            $code === 0 => 'Cielo sereno',
            $code <= 3  => 'Parzialmente nuvoloso',
            $code <= 48 => 'Nebbia',
            $code <= 67 => 'Pioggia',
            $code <= 77 => 'Neve',
            $code <= 82 => 'Rovesci',
            $code <= 99 => 'Temporale',
            default     => 'Variabile',
        ];
    }
}
