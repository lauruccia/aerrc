{{--
    Componente immagine responsive con fallback WebP/JPEG.

    Uso:
        <x-responsive-photo :url="$article->image_url" :alt="$article->title" class="absolute inset-0 w-full h-full object-cover" loading="lazy" />

    - Se $url punta a /img/calabria/... (foto locali ottimizzate), genera un <picture>
      con sorgente WebP e fallback JPEG originale.
    - Se $url è un URL esterno (es. Unsplash), renderizza un semplice <img> senza <picture>.
    - loading="eager" per le immagini hero above-the-fold (LCP), "lazy" per il resto (default).
--}}
@props(['url', 'alt' => '', 'loading' => 'lazy'])

@php
    $isLocal = $url && str_starts_with($url, '/img/');
    $webpUrl = $isLocal ? preg_replace('/\.(jpe?g)$/i', '.webp', $url) : null;
@endphp

@if($isLocal)
    <picture>
        <source srcset="{{ $webpUrl }}" type="image/webp">
        <img src="{{ $url }}" alt="{{ $alt }}" loading="{{ $loading }}" {{ $attributes }}>
    </picture>
@else
    <img src="{{ $url }}" alt="{{ $alt }}" loading="{{ $loading }}" {{ $attributes }}>
@endif
