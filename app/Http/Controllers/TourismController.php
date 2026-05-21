<?php

namespace App\Http\Controllers;

use App\Models\TourismArticle;
use Illuminate\View\View;

class TourismController extends Controller
{
    public function index(): View
    {
        $articles = TourismArticle::published()->orderByDesc('published_at')->paginate(9);
        return view('tourism.index', compact('articles'));
    }

    public function show(string $slug): View
    {
        $article = TourismArticle::where('slug', $slug)->published()->firstOrFail();
        return view('tourism.show', compact('article'));
    }
}
