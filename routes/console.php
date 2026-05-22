<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ── Scheduled tasks ──────────────────────────────────────
// Svuota cache voli ogni 5 minuti per refresh automatico
Schedule::call(function () {
    Cache::forget('flights.departures.REG');
    Cache::forget('flights.arrivals.REG');
})->everyFiveMinutes()->name('clear-flights-cache');

// Svuota cache meteo ogni 30 minuti
Schedule::call(function () {
    Cache::forget('weather.reggiocalabria');
})->everyThirtyMinutes()->name('clear-weather-cache');

// ── Sincronizzazione voli reali da AirLabs ────────────────────
// Ogni giorno alle 04:30 importa i voli del giorno nel DB.
// La cache dei voli viene poi svuotata ogni 5 minuti (vedi sopra),
// quindi il tabellone mostrerà i nuovi dati entro pochi minuti.
Schedule::command('flights:sync')
    ->dailyAt('04:30')
    ->name('flights-sync-airlabs')
    ->withoutOverlapping()
    ->runInBackground();
