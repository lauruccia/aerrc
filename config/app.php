<?php

use Illuminate\Support\Facades\Facade;

return [

    'name' => env('APP_NAME', 'Aeroporto Reggio Calabria'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'https://aeroportoreggiocalabria.it'),

    'timezone' => env('APP_TIMEZONE', 'Europe/Rome'),

    'locale' => env('APP_LOCALE', 'it'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'it_IT'),

    // Token segreto per la rotta /admin/reseed-flights (senza terminale)
    // Impostare ADMIN_RESEED_TOKEN nel .env del server di produzione.
    'admin_reseed_token' => env('ADMIN_RESEED_TOKEN', ''),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => 'file',
    ],

];
