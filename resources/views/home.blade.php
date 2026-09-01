@extends('layouts.app')

@section('title', __('home.meta_title'))
@section('description', __('home.meta_description'))

@section('content')

{{-- ════════════════════════════════════════════════════════
     HERO
     ════════════════════════════════════════════════════════ --}}
<section class="relative min-h-screen overflow-hidden flex flex-col justify-center px-4 pt-24 pb-16" style="background:#060f1e;">

    {{-- Illustrazione nuovo terminal 2026 come sfondo --}}
    <div class="absolute inset-0 pointer-events-none">
        <img
            src="/img/hero-nuovo-terminal.svg"
            alt="Nuovo Terminal Aeroporto Tito Minniti di Reggio Calabria inaugurato maggio 2026"
            class="absolute inset-0 w-full h-full object-cover"
            style="opacity:0.92;"
            loading="eager"
        >
        {{-- Overlay gradient per leggibilità testo --}}
        <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(6,15,30,0.08) 0%, rgba(6,15,30,0.18) 40%, rgba(6,15,30,0.70) 78%, rgba(6,15,30,0.90) 100%);"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto w-full">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-gold/15 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6">
            ✈️ &nbsp;{{ __('home.hero_badge') }}
        </div>

        {{-- Title --}}
        <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-4 drop-shadow-[0_2px_20px_rgba(0,0,0,0.3)]">
            {!! __('home.hero_title') !!}
        </h1>

        <p class="text-lg md:text-xl text-white/80 max-w-2xl leading-relaxed mb-10">
            {{ __('home.hero_subtitle') }}
        </p>

        {{-- CTA buttons --}}
        <div class="flex flex-wrap gap-4 mb-14">
            <a href="{{ route('flights.index') }}" class="btn-primary text-base">
                ✈️ {{ __('home.cta_flights') }}
            </a>
            <a href="{{ route('tourism') }}" class="btn-secondary text-base">
                🗺️ {{ __('home.cta_tourism') }}
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-xl">
            <div class="stat-card">
                <div class="text-2xl font-black text-gold">622K+</div>
                <div class="text-[0.7rem] text-white/70 mt-1">{{ __('home.stat_passengers') }}</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl font-black text-gold">15</div>
                <div class="text-[0.7rem] text-white/70 mt-1">{{ __('home.stat_routes') }}</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl font-black text-gold">1M</div>
                <div class="text-[0.7rem] text-white/70 mt-1">{{ __('home.stat_target') }}</div>
            </div>
            <div class="stat-card">
                <div class="text-2xl font-black text-gold">+50%</div>
                <div class="text-[0.7rem] text-white/70 mt-1">{{ __('home.stat_tourists') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     VOLI LIVE (Livewire component)
     ════════════════════════════════════════════════════════ --}}
<section id="voli" class="bg-navy py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag-dark">DATI DA PROVIDER AERONAUTICO</span>
        <h2 class="text-4xl font-black text-white mb-2">{{ __('flights.section_title') }}</h2>
        <p class="text-white/70 text-lg mb-8 max-w-xl">{{ __('flights.section_subtitle') }}</p>

        @livewire('flight-board')
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     DESTINAZIONI
     ════════════════════════════════════════════════════════ --}}
<section id="destinazioni" class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">{{ __('destinations.label') }}</span>
        <h2 class="text-4xl font-black text-navy mb-2">{{ __('destinations.section_title') }}</h2>
        <p class="text-gray-500 text-lg mb-10 max-w-xl">{{ __('destinations.section_subtitle') }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($destinations as $dest)
                <a href="{{ route('destinations.show', $dest->slug) }}"
                   class="bg-white rounded-2xl overflow-hidden shadow-md card-hover block group border border-black/5">
                    <div class="h-40 relative dest-img-gradient flex items-end p-4"
                         style="background: linear-gradient(135deg, {{ $dest->color_from ?? '#1A5276' }}, {{ $dest->color_to ?? '#2E86C1' }})">
                        <span class="absolute top-3 right-3 text-2xl z-10">{{ $dest->flag_emoji }}</span>
                        <span class="relative z-10 text-white font-bold">{{ $dest->city }}</span>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-400 mb-1">{{ $dest->airlines_string }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('destinations.index') }}" class="btn-outline">
                {{ __('destinations.see_all') }} →
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     TURISMO CALABRIA
     ════════════════════════════════════════════════════════ --}}
<section id="turismo" class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">{{ __('tourism.label') }}</span>
        <h2 class="text-4xl font-black text-navy mb-2">{{ __('tourism.section_title') }}</h2>
        <p class="text-gray-500 text-lg mb-10 max-w-xl">{{ __('tourism.section_subtitle') }}</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($tourismArticles->take(4) as $index => $article)
                <a href="{{ route('tourism.show', $article->slug) }}"
                   class="bg-white rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.08)] card-hover block
                          {{ $index === 0 ? 'md:col-span-2' : '' }}">
                    <div class="relative flex items-end p-6 {{ $index === 0 ? 'h-64' : 'h-56' }}"
                         style="background: linear-gradient(135deg, {{ $article->color_from ?? '#0D2B4B' }}, {{ $article->color_to ?? '#1A5276' }})">
                        <span class="absolute top-4 left-4 bg-gold text-navy text-xs font-bold px-2.5 py-1 rounded-full">
                            {{ $article->category_label }}
                        </span>
                        <div class="relative z-10">
                            <h3 class="text-white font-bold text-lg leading-tight">{{ $article->title }}</h3>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/85 to-transparent"></div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-500 text-sm leading-relaxed mb-3 line-clamp-2">{{ $article->excerpt }}</p>
                        <span class="text-sky text-sm font-semibold">{{ __('tourism.read_more') }} →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     SERVIZI AEROPORTO
     ════════════════════════════════════════════════════════ --}}
<section id="servizi" class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">{{ __('services.label') }}</span>
        <h2 class="text-4xl font-black text-navy mb-2">{{ __('services.section_title') }}</h2>
        <p class="text-gray-500 text-lg mb-10 max-w-xl">{{ __('services.section_subtitle') }}</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach([
                ['icon' => '🅿️', 'bg' => 'bg-blue/10',  'title' => __('services.parking'),     'desc' => __('services.parking_desc')],
                ['icon' => '🚗', 'bg' => 'bg-gold/10',   'title' => __('services.car_rental'),   'desc' => __('services.car_rental_desc')],
                ['icon' => '🏨', 'bg' => 'bg-sky/10',    'title' => __('services.hotels'),       'desc' => __('services.hotels_desc')],
                ['icon' => '🍽️', 'bg' => 'bg-amber/10',  'title' => __('services.restaurants'),  'desc' => __('services.restaurants_desc')],
                ['icon' => '💱', 'bg' => 'bg-green-100', 'title' => __('services.exchange'),     'desc' => __('services.exchange_desc')],
                ['icon' => '♿', 'bg' => 'bg-purple-100', 'title' => __('services.accessibility'),'desc' => __('services.accessibility_desc')],
                ['icon' => '🛡️', 'bg' => 'bg-red-100',   'title' => __('services.security'),    'desc' => __('services.security_desc')],
                ['icon' => 'ℹ️', 'bg' => 'bg-navy/10',   'title' => __('services.info'),         'desc' => __('services.info_desc')],
            ] as $service)
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)]
                            border-2 border-transparent hover:border-sky card-hover text-center cursor-pointer">
                    <div class="w-14 h-14 {{ $service['bg'] }} rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        {{ $service['icon'] }}
                    </div>
                    <h3 class="font-bold text-navy mb-1.5 text-sm">{{ $service['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $service['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     PARTNER / OPPORTUNITÀ COMMERCIALI
     ════════════════════════════════════════════════════════ --}}
<section id="partner" class="py-20 px-4 bg-navy">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag-dark">{{ __('partners.label') }}</span>
        <h2 class="text-4xl font-black text-white mb-2">{{ __('partners.section_title') }}</h2>
        <p class="text-white/70 text-lg mb-10 max-w-xl">{{ __('partners.section_subtitle') }}</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach([
                ['icon' => '🏛️', 'name' => __('partners.region_name'),    'desc' => __('partners.region_desc'),    'price' => __('partners.region_price')],
                ['icon' => '🏙️', 'name' => __('partners.municipality_name'), 'desc' => __('partners.municipality_desc'), 'price' => __('partners.municipality_price')],
                ['icon' => '🏢', 'name' => __('partners.business_name'),   'desc' => __('partners.business_desc'),  'price' => __('partners.business_price')],
            ] as $partner)
                <div class="glass-card p-6 text-center hover:border-gold/40 transition-all cursor-pointer">
                    <div class="text-5xl mb-4">{{ $partner['icon'] }}</div>
                    <h3 class="text-white font-bold mb-2">{{ $partner['name'] }}</h3>
                    <p class="text-white/60 text-sm leading-relaxed mb-4">{{ $partner['desc'] }}</p>
                    <a href="{{ route('partners') }}" class="block bg-gold text-navy py-2 px-5 rounded-lg font-bold text-sm hover:bg-yellow-400 transition-colors">
                        {{ __('partners.discover') }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     INFO AEROPORTO + METEO
     ════════════════════════════════════════════════════════ --}}
<section id="info" class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">{{ __('airport.label') }}</span>
        <h2 class="text-4xl font-black text-navy mb-8">{{ __('airport.section_title') }}</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Info card --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                <h3 class="text-navy font-bold text-lg mb-5 flex items-center gap-2">
                    🏛️ {{ __('airport.info_title') }}
                </h3>
                <ul class="space-y-3 text-sm text-dark">
                    <li class="flex items-center gap-3 py-2.5 border-b border-offwhite"><span>📍</span><span><strong>{{ __('airport.address_label') }}:</strong> Via Ravagnese, 1 — 89131 Reggio Calabria</span></li>
                    <li class="flex items-center gap-3 py-2.5 border-b border-offwhite"><span>📞</span><span><strong>{{ __('airport.phone_label') }}:</strong> +39 0965 640 517</span></li>
                    <li class="flex items-center gap-3 py-2.5 border-b border-offwhite"><span>✈️</span><span><strong>{{ __('airport.iata_label') }}:</strong> REG — IATA / LICR — ICAO</span></li>
                    <li class="flex items-center gap-3 py-2.5 border-b border-offwhite"><span>🕐</span><span><strong>{{ __('airport.hours_label') }}:</strong> {{ __('airport.hours_value') }}</span></li>
                    <li class="flex items-center gap-3 py-2.5"><span>🚌</span><span><strong>{{ __('airport.transport_label') }}:</strong> {{ __('airport.transport_value') }}</span></li>
                </ul>
            </div>

            {{-- Meteo widget (Livewire) --}}
            @livewire('weather-widget')
        </div>
    </div>
</section>

@endsection
