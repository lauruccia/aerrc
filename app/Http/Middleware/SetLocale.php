<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supported = ['it', 'en', 'de', 'fr'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale')
            ?? $this->detectFromBrowser($request)
            ?? config('app.locale', 'it');

        if (in_array($locale, $this->supported)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    protected function detectFromBrowser(Request $request): ?string
    {
        $acceptLang = $request->header('Accept-Language', '');
        // Prende il primo tag lingua (es. "de-DE,de;q=0.9" → "de")
        preg_match('/^([a-z]{2})/i', $acceptLang, $m);
        $lang = strtolower($m[1] ?? '');
        return in_array($lang, $this->supported) ? $lang : null;
    }
}
