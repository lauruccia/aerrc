<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Language switching — deve stare prima del gruppo localizzato
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])
    ->name('lang.switch')
    ->where('locale', 'it|en|de|fr');

/*
|--------------------------------------------------------------------------
| Rotte principali
|--------------------------------------------------------------------------
*/
Route::group([], function () {

    // Homepage
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Voli
    Route::prefix('voli')->name('flights.')->group(function () {
        Route::get('/', [FlightController::class, 'index'])->name('index');
        Route::get('/{flight}', [FlightController::class, 'show'])->name('show');
    });

    // Destinazioni
    Route::prefix('destinazioni')->name('destinations.')->group(function () {
        Route::get('/', [DestinationController::class, 'index'])->name('index');
        Route::get('/{slug}', [DestinationController::class, 'show'])->name('show');
    });

    // Turismo
    Route::prefix('turismo')->name('tourism.')->group(function () {
        Route::get('/', [TourismController::class, 'index'])->name('index');
        Route::get('/{slug}', [TourismController::class, 'show'])->name('show');
    });
    Route::get('/turismo', [TourismController::class, 'index'])->name('tourism');

    // Partner
    Route::get('/partner', [PartnerController::class, 'index'])->name('partners');

    // Pagine statiche
    Route::get('/servizi', [StaticPageController::class, 'services'])->name('services');
    Route::get('/aeroporto', [StaticPageController::class, 'airportInfo'])->name('airport-info');
    Route::get('/contatti', [StaticPageController::class, 'contact'])->name('contact');
    Route::post('/contatti', [StaticPageController::class, 'contactSubmit'])->name('contact.submit');
    Route::get('/privacy', [StaticPageController::class, 'privacy'])->name('privacy');
    Route::get('/cookie-policy', [StaticPageController::class, 'cookies'])->name('cookies');
    Route::get('/termini-e-condizioni', [StaticPageController::class, 'terms'])->name('terms');
    Route::get('/sitemap.xml', [StaticPageController::class, 'sitemap'])->name('sitemap');

    // Newsletter
    Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
});

/*
|--------------------------------------------------------------------------
| API interna (AJAX / Livewire)
|--------------------------------------------------------------------------
*/
Route::prefix('api/v1')->name('api.')->middleware('throttle:60,1')->group(function () {
    Route::get('/flights/departures', [\App\Http\Controllers\Api\FlightApiController::class, 'departures'])->name('flights.departures');
    Route::get('/flights/arrivals',   [\App\Http\Controllers\Api\FlightApiController::class, 'arrivals'])->name('flights.arrivals');
    Route::get('/weather',            [\App\Http\Controllers\Api\WeatherApiController::class, 'current'])->name('weather');
});
