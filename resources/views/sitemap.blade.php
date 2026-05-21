<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <xhtml:link rel="alternate" hreflang="it" href="{{ url('/') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en') }}"/>
        <xhtml:link rel="alternate" hreflang="de" href="{{ url('/de') }}"/>
        <xhtml:link rel="alternate" hreflang="fr" href="{{ url('/fr') }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('/') }}"/>
    </url>

    <url>
        <loc>{{ route('flights.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>hourly</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ route('destinations.index') }}</loc>
        <lastmod>{{ now()->subDays(1)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
    </url>

    @foreach($destinations ?? [] as $dest)
    <url>
        <loc>{{ route('destinations.show', $dest->slug) }}</loc>
        <lastmod>{{ ($dest->updated_at ?? now()->subDays(7))->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.75</priority>
    </url>
    @endforeach

    <url>
        <loc>{{ route('tourism') }}</loc>
        <lastmod>{{ now()->subDays(2)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
    </url>

    @foreach($tourismArticles ?? [] as $article)
    <url>
        <loc>{{ route('tourism.show', $article->slug) }}</loc>
        <lastmod>{{ ($article->updated_at ?? now()->subDays(7))->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    <url>
        <loc>{{ route('services') }}</loc>
        <lastmod>{{ now()->subDays(30)->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ route('airport-info') }}</loc>
        <lastmod>{{ now()->subDays(30)->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ route('partners') }}</loc>
        <lastmod>{{ now()->subDays(15)->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.65</priority>
    </url>

    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ now()->subDays(60)->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ route('privacy') }}</loc>
        <lastmod>{{ now()->subDays(30)->toAtomString() }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.2</priority>
    </url>

    <url>
        <loc>{{ route('cookies') }}</loc>
        <lastmod>{{ now()->subDays(30)->toAtomString() }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.2</priority>
    </url>

    <url>
        <loc>{{ route('terms') }}</loc>
        <lastmod>{{ now()->subDays(30)->toAtomString() }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.2</priority>
    </url>

</urlset>
