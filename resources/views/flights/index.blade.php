@extends('layouts.app')

@section('title', 'Voli — Aeroporto Reggio Calabria')
@section('description', 'Partenze e arrivi in tempo reale dall\'Aeroporto di Reggio Calabria Tito Minniti. Trova il tuo volo.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <svg viewBox="0 0 1200 400" class="w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="1000" cy="100" rx="500" ry="300" fill="#C9A84C"/>
            <ellipse cx="100" cy="350" rx="300" ry="200" fill="#1A5276"/>
        </svg>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            ✈️ &nbsp;LIVE
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-3">
            Partenze &amp; Arrivi
        </h1>
        <p class="text-white/70 text-lg max-w-xl">
            Informazioni in tempo reale su tutti i voli dell'Aeroporto Internazionale di Reggio Calabria – Tito Minniti (REG).
        </p>
    </div>
</section>

{{-- TABELLONE VOLI --}}
<section class="bg-navy pb-20 px-4">
    <div class="max-w-7xl mx-auto">
        @livewire('flight-board')
    </div>
</section>

{{-- INFO UTILI --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">INFORMAZIONI</span>
        <h2 class="text-3xl font-black text-navy mb-8">Tutto quello che devi sapere</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                <div class="w-12 h-12 bg-sky/10 rounded-xl flex items-center justify-center text-2xl mb-4">⏱️</div>
                <h3 class="font-bold text-navy mb-2">Check-in &amp; Imbarco</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Presentarsi al check-in almeno <strong>2 ore prima</strong> per i voli nazionali e <strong>3 ore prima</strong> per gli internazionali. Il gate chiude 30 minuti prima della partenza.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                <div class="w-12 h-12 bg-gold/10 rounded-xl flex items-center justify-center text-2xl mb-4">🚗</div>
                <h3 class="font-bold text-navy mb-2">Come arrivare</h3>
                <p class="text-sm text-gray-500 leading-relaxed">L'aeroporto si trova a <strong>5 km dal centro</strong> di Reggio Calabria. Collegato con autobus ATM (linea 13), taxi e parcheggi convenzionati a breve e lungo termine.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                <div class="w-12 h-12 bg-blue/10 rounded-xl flex items-center justify-center text-2xl mb-4">📞</div>
                <h3 class="font-bold text-navy mb-2">Assistenza voli</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Per informazioni sui voli chiama il <strong>+39 0965 640 517</strong> oppure contatta direttamente la tua compagnia aerea. Orari: tutti i giorni dalle 05:30 alle 22:30.</p>
            </div>
        </div>
    </div>
</section>

@endsection
