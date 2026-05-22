<?php

namespace App\Http\Controllers;

use App\Models\TourismArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourismController extends Controller
{
    public function index(Request $request): View
    {
        $validCategories = ['natura', 'storia', 'mare', 'gastronomia', 'borghi', 'eventi', 'cultura', 'citta'];
        $cat = $request->query('cat');

        $query = TourismArticle::published()->orderByDesc('published_at');

        if ($cat && in_array($cat, $validCategories)) {
            $query->where('category', $cat);
        }

        $articles = $query->paginate(9)->appends(['cat' => $cat]);

        return view('tourism.index', compact('articles', 'cat'));
    }

    public function show(string $slug): View
    {
        $article = TourismArticle::where('slug', $slug)->published()->firstOrFail();
        return view('tourism.show', compact('article'));
    }
}
