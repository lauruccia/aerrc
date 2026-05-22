@extends('layouts.app')

@section('title', 'Destinazioni — Aeroporto Reggio Calabria')
@section('description', 'Scopri tutte le destinazioni raggiungibili dall\'Aeroporto di Reggio Calabria. Voli diretti per le migliori città europee.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <svg viewBox="0 0 1200 400" class="w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="1100" cy="80" rx="450" ry="280" fill="#C9A84C"/>
            <ellipse cx="50" cy="380" rx="280" ry="180" fill="#1A5276"/>
        </svg>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            🌍 &nbsp;DESTINAZIONI
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-3">
            Dove vuoi volare?
        </h1>
        <p class="text-white/70 text-lg max-w-xl">
            Voli diretti da Reggio Calabria per le principali destinazioni italiane ed europee. Confronta prezzi e compagnie.
        </p>
    </div>
</section>

{{-- GRIGLIA DESTINAZIONI --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">

        @if($destinations->isEmpty())
            <div class="text-center py-20">
                <div class="text-6xl mb-4">✈️</div>
                <h3 class="text-2xl font-bold text-navy mb-2">Destinazioni in arrivo</h3>
                <p class="text-gray-500">Le rotte disponibili verranno pubblicate a breve. Iscriviti alla newsletter per essere aggiornato.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($destinations as $dest)
                    <a href="{{ route('destinations.show', $dest->slug) }}"
                       class="bg-white rounded-2xl overflow-hidden shadow-md card-hover block group border border-black/5">
                        <div class="h-44 relative flex items-end p-5"
                             style="background: linear-gradient(135deg, {{ $dest->color_from ?? '#1A5276' }}, {{ $dest->color_to ?? '#2E86C1' }})">
                            <span class="absolute top-3 right-3 text-3xl z-10">{{ $dest->flag_emoji }}</span>
                            <div class="relative z-10">
                                <div class="text-white/70 text-xs font-medium mb-0.5">{{ $dest->iata_code }}</div>
                                <div class="text-white font-bold text-xl">{{ $dest->city }}</div>
                                <div class="text-white/60 text-xs">{{ $dest->country }}</div>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-400 mb-2">{{ $dest->airlines_string }}</p>
                            <div class="flex items-end justify-between">
                                <span class="text-sky text-sm font-semibold group-hover:translate-x-1 transition-transform inline-block">Scopri →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
</section>

{{-- BANNER NEWSLETTER --}}
<section class="py-16 px-4 bg-navy">
    <div class="max-w-2xl mx-auto text-center">
        <div class="text-4xl mb-4">🔔</div>
        <h2 class="text-3xl font-black text-white mb-2">Nuove rotte in arrivo</h2>
        <p class="text-white/60 mb-6">Iscriviti e scopri per primo le nuove destinazioni e le offerte speciali.</p>
        <a href="{{ route('home') }}#newsletter" class="btn-primary">Iscriviti alla newsletter</a>
    </div>
</section>

@endsection
