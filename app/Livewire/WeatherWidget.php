<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WeatherWidget extends Component
{
    public array $weather = [];

    public function mount(): void
    {
        $this->weather = Cache::remember('weather.reggiocalabria', 1800, function () {
            return $this->fetchWeather();
        });
    }

    protected function fetchWeather(): array
    {
        try {
            $lat = config('aviationstack.weather_lat', 38.0718);
            $lon = config('aviationstack.weather_lon', 15.6515);

            $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude'       => $lat,
                'longitude'      => $lon,
                'current'        => 'temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code',
                'timezone'       => 'Europe/Rome',
                'forecast_days'  => 1,
            ]);

            if ($response->ok()) {
                $current = $response->json('current', []);
                return [
                    'temp'      => round($current['temperature_2m'] ?? 22),
                    'humidity'  => $current['relative_humidity_2m'] ?? 65,
                    'wind'      => round($current['wind_speed_10m'] ?? 15),
                    'code'      => $current['weather_code'] ?? 0,
                    'icon'      => $this->weatherIcon($current['weather_code'] ?? 0),
                    'desc'      => $this->weatherDesc($current['weather_code'] ?? 0),
                ];
            }
        } catch (\Throwable) {}

        // Fallback
        return [
            'temp' => 24, 'humidity' => 65, 'wind' => 18,
            'code' => 0, 'icon' => '☀️', 'desc' => 'Soleggiato',
        ];
    }

    protected function weatherIcon(int $code): string
    {
        return match(true) {
            $code === 0         => '☀️',
            $code <= 3          => '⛅',
            $code <= 48         => '🌫️',
            $code <= 67         => '🌧️',
            $code <= 77         => '❄️',
            $code <= 82         => '🌦️',
            $code <= 99         => '⛈️',
            default             => '🌤️',
        };
    }

    protected function weatherDesc(int $code): string
    {
        return match(true) {
            $code === 0  => 'Cielo sereno',
            $code <= 3   => 'Parzialmente nuvoloso',
            $code <= 48  => 'Nebbia',
            $code <= 67  => 'Pioggia',
            $code <= 77  => 'Neve',
            $code <= 82  => 'Rovesci',
            $code <= 99  => 'Temporale',
            default      => 'Variabile',
        };
    }

    public function render()
    {
        return view('livewire.weather-widget');
    }
}
