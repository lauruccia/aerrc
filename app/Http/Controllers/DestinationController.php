<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::active()->orderBy('city')->paginate(12);
        return view('destinations.index', compact('destinations'));
    }

    public function show(string $slug): View
    {
        $destination = Destination::where('slug', $slug)->active()->firstOrFail();
        return view('destinations.show', compact('destination'));
    }
}
