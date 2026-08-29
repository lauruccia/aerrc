<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ── Scheduled tasks ──────────────────────────────────────
// Svuota cache stato live voli ogni 60 minuti.
// Le chiavi DEVONO corrispondere a quelle usate in FlightStatusService:
//   "flight_status.departure.{iata}" e "flight_status.arrival.{iata}"
$iata = env('AIRPORT_IATA', 'REG');
Schedule::call(function () use ($iata) {
    Cache::forget("flight_status.departure.{$iata}");
    Cache::forget("flight_status.arrival.{$iata}");
})->hourly()->name('clear-flights-status-cache');

// Svuota cache meteo ogni 30 minuti
Schedule::call(function () {
    Cache::forget('weather.reggiocalabria');
})->everyThirtyMinutes()->name('clear-weather-cache');

// ── Sincronizzazione voli reali da AirLabs ────────────────────
// Subito dopo mezzanotte importa i voli del giorno nel DB. Il calendario
// stagionale rimane comunque disponibile durante errori o ritardi del provider.
// Lo stato live (ritardi, gate, ecc.) viene aggiornato dalla cache
// di FlightStatusService che si rinnova ogni ora (vedi sopra).
Schedule::command('flights:sync')
    ->dailyAt('00:10')
    ->name('flights-sync-airlabs')
    ->withoutOverlapping()
    ->runInBackground();
