@extends('layouts.app')

@section('title', $destination->city . ' — Destinazioni da Reggio Calabria')
@section('description', 'Vola da Reggio Calabria a ' . $destination->city . '. Scopri prezzi, compagnie e consigli di viaggio.')

@section('content')

{{-- HERO --}}
<section class="relative pt-28 pb-20 px-4 overflow-hidden flex items-center min-h-[40vh]"
         style="background: linear-gradient(135deg, {{ $destination->color_from ?? '#0D2B4B' }}, {{ $destination->color_to ?? '#1A5276' }})">
    <div class="relative z-10 max-w-7xl mx-auto w-full">
        <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white text-sm mb-6 transition-colors">
            ← Tutte le destinazioni
        </a>
        <div class="flex items-start gap-6">
            <span class="text-7xl">{{ $destination->flag_emoji }}</span>
            <div>
                <div class="text-white/60 text-sm font-medium mb-1">{{ $destination->iata_code }} · {{ $destination->country }}</div>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-none mb-3">{{ $destination->city }}</h1>
                <p class="text-white/70 text-lg">{{ $destination->airlines_string }}</p>
            </div>
        </div>
    </div>
</section>

{{-- DETTAGLI --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Info principale --}}
            <div class="lg:col-span-2 space-y-6">
                @if($destination->description)
                    <div class="bg-white rounded-2xl p-8 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                        <h2 class="text-2xl font-black text-navy mb-4">Su {{ $destination->city }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $destination->description }}</p>
                    </div>
                @endif

                <div class="bg-white rounded-2xl p-8 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                    <h2 class="text-2xl font-black text-navy mb-5">Consigli per il viaggio</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">⏱️</span>
                            <div>
                                <div class="font-bold text-navy text-sm">Check-in</div>
                                <div class="text-gray-500 text-sm">Almeno 2 ore prima della partenza</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🧳</span>
                            <div>
                                <div class="font-bold text-navy text-sm">Bagaglio</div>
                                <div class="text-gray-500 text-sm">Verifica i limiti con la compagnia aerea</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🛂</span>
                            <div>
                                <div class="font-bold text-navy text-sm">Documenti</div>
                                <div class="text-gray-500 text-sm">Carta d'identità o passaporto valido</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🚗</span>
                            <div>
                                <div class="font-bold text-navy text-sm">Trasporti</div>
                                <div class="text-gray-500 text-sm">Taxi e autobus disponibili all'arrivo</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar prezzo --}}
            <div class="space-y-5">
                <div class="bg-navy rounded-2xl p-6 text-white sticky top-24">
                    <div class="text-white/60 text-sm mb-1">A partire da</div>
                    <div class="text-5xl font-black text-gold mb-1">€{{ number_format($destination->price_from, 0) }}</div>
                    <div class="text-white/60 text-sm mb-6">a persona, solo andata</div>
                    <a href="https://www.google.com/flights?hl=it#flt=REG.{{ $destination->iata_code }}"
                       target="_blank" rel="noopener"
                       class="block w-full bg-gold text-navy text-center py-3.5 rounded-xl font-bold hover:bg-yellow-400 transition-colors">
                        Cerca voli →
                    </a>
                    <p class="text-white/40 text-xs text-center mt-3">I prezzi sono indicativi e possono variare</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                    <h3 class="font-bold text-navy mb-3 text-sm">Compagnie operative</h3>
                    <p class="text-gray-600 text-sm">{{ $destination->airlines_string }}</p>
                </div>

                <a href="{{ route('flights.index') }}"
                   class="flex items-center gap-3 bg-sky/10 rounded-2xl p-5 hover:bg-sky/20 transition-colors">
                    <span class="text-2xl">📋</span>
                    <div>
                        <div class="font-bold text-navy text-sm">Tabellone voli live</div>
                        <div class="text-gray-500 text-xs">Partenze e arrivi in tempo reale</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
