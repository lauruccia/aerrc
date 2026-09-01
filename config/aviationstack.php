<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AviationStack API
    |--------------------------------------------------------------------------
    | Registrati su https://aviationstack.com — piano free: 100 req/mese
    | Piano basic: 10.000 req/mese a $9.99/mese
    */
    'api_key'      => env('AVIATIONSTACK_API_KEY', ''),
    'base_url'     => env('AVIATIONSTACK_BASE_URL', 'http://api.aviationstack.com/v1'),
    'airport_iata' => env('AIRPORT_IATA', 'REG'),
    'airlabs_api_key' => env('AIRLABS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL (secondi)
    | I voli vengono cachati 5 minuti per non esaurire le chiamate API
    |--------------------------------------------------------------------------
    */
    'cache_ttl' => env('FLIGHT_STATUS_CACHE_TTL', 7200),
];
