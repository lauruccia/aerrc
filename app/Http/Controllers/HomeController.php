<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TourismArticle;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::active()
            ->orderBy('price_from')
            ->take(8)
            ->get();

        $tourismArticles = TourismArticle::published()
            ->featured()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('home', compact('destinations', 'tourismArticles'));
    }
}
