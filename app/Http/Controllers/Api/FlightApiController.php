<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HybridFlightService;
use Illuminate\Http\JsonResponse;

class FlightApiController extends Controller
{
    public function __construct(protected HybridFlightService $service) {}

    public function departures(): JsonResponse
    {
        return response()->json([
            'data'       => $this->service->getDepartures(),
            'updated_at' => now()->toISOString(),
        ]);
    }

    public function arrivals(): JsonResponse
    {
        return response()->json([
            'data'       => $this->service->getArrivals(),
            'updated_at' => now()->toISOString(),
        ]);
    }
}
