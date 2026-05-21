<?php

namespace App\Http\Controllers;

use App\Services\AviationStackService;
use Illuminate\View\View;

class FlightController extends Controller
{
    public function __construct(protected AviationStackService $aviationStack) {}

    public function index(): View
    {
        return view('flights.index');
    }
}
