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
