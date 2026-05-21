@extends('layouts.app')

@section('title', 'Partner & Opportunità Commerciali — Aeroporto Reggio Calabria')
@section('description', 'Diventa partner del portale turistico ufficiale dell\'Aeroporto di Reggio Calabria. Opportunità per Regione Calabria, Comune e aziende private.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-20 px-4 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <svg viewBox="0 0 1200 500" class="w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="950" cy="150" rx="500" ry="300" fill="#C9A84C"/>
            <ellipse cx="100" cy="450" rx="350" ry="200" fill="#1A5276"/>
        </svg>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6">
            🤝 &nbsp;PARTNERSHIP
        </span>
        <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-5">
            Investi nel futuro<br>
            <span class="text-gold">della Calabria</span>
        </h1>
        <p class="text-white/70 text-xl max-w-2xl mx-auto mb-10">
            Il primo portale turistico integrato con l'aeroporto di Reggio Calabria: oltre 600.000 passeggeri l'anno, una vetrina unica sul turismo calabrese.
        </p>

        {{-- Numeri chiave --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
            @foreach([
                ['num' => '622K+', 'label' => 'Passeggeri/anno'],
                ['num' => '1M', 'label' => 'Target 2026'],
                ['num' => '#1', 'label' => 'Portale Calabria'],
                ['num' => '4', 'label' => 'Lingue'],
            ] as $stat)
                <div class="glass-card py-4 px-3">
                    <div class="text-3xl font-black text-gold">{{ $stat['num'] }}</div>
                    <div class="text-white/60 text-xs mt-1">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PACCHETTI PARTNERSHIP --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">PACCHETTI</span>
        <h2 class="text-4xl font-black text-navy mb-3">Scegli la tua partnership</h2>
        <p class="text-gray-500 text-lg mb-12 max-w-xl">Tre livelli di collaborazione pensati per Regione, Comuni e aziende private.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Regione --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)] border-2 border-gold relative">
                <div class="absolute -top-3 left-6 bg-gold text-navy text-xs font-black px-3 py-1 rounded-full">CONSIGLIATO</div>
                <div class="text-5xl mb-5">🏛️</div>
                <h3 class="text-2xl font-black text-navy mb-2">Regione Calabria</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Partnership istituzionale completa. Co-branding sul portale, integrazione con i canali ufficiali regionali, promozione turistica congiunta su 4 lingue.
                </p>
                <ul class="space-y-2 mb-8 text-sm">
                    @foreach([
                        'Logo Regione su homepage e tutte le pagine',
                        'Sezione dedicata "Calabria Ufficiale"',
                        'Campagne promozionali co-finanziate',
                        'Report analytics mensili',
                        'Integrazione dati eventi regionali',
                        'Account manager dedicato',
                    ] as $item)
                        <li class="flex items-start gap-2 text-gray-600">
                            <span class="text-gold font-bold mt-0.5">✓</span> {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <div class="border-t pt-5">
                    <div class="text-navy/50 text-sm mb-1">A partire da</div>
                    <div class="text-4xl font-black text-navy mb-4">€15.000<span class="text-base font-normal text-gray-400">/anno</span></div>
                    <a href="{{ route('contact') }}" class="block w-full text-center bg-gold text-navy py-3 rounded-xl font-bold hover:bg-yellow-400 transition-colors">
                        Richiedi info →
                    </a>
                </div>
            </div>

            {{-- Comune --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-black/5">
                <div class="text-5xl mb-5">🏙️</div>
                <h3 class="text-2xl font-black text-navy mb-2">Comuni & Pro Loco</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Promuovi il tuo comune o borgo direttamente ai turisti in arrivo a Reggio Calabria. Scheda dedicata, eventi e attrazioni locali.
                </p>
                <ul class="space-y-2 mb-8 text-sm">
                    @foreach([
                        'Scheda comune nella sezione Turismo',
                        'Fino a 10 articoli/guide locali',
                        'Presenza nella mappa interattiva',
                        'Banner nelle pagine turismo',
                        'Report trimestrali',
                    ] as $item)
                        <li class="flex items-start gap-2 text-gray-600">
                            <span class="text-sky font-bold mt-0.5">✓</span> {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <div class="border-t pt-5">
                    <div class="text-navy/50 text-sm mb-1">A partire da</div>
                    <div class="text-4xl font-black text-navy mb-4">€3.000<span class="text-base font-normal text-gray-400">/anno</span></div>
                    <a href="{{ route('contact') }}" class="block w-full text-center bg-navy text-white py-3 rounded-xl font-bold hover:bg-blue transition-colors">
                        Richiedi info →
                    </a>
                </div>
            </div>

            {{-- Business --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-black/5">
                <div class="text-5xl mb-5">🏢</div>
                <h3 class="text-2xl font-black text-navy mb-2">Aziende &amp; Strutture</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Hotel, ristoranti, tour operator e noleggiatori: raggiunge i viaggiatori nel momento esatto in cui atterrano a Reggio Calabria.
                </p>
                <ul class="space-y-2 mb-8 text-sm">
                    @foreach([
                        'Listing nella sezione Servizi',
                        'Banner display geolocalizzati',
                        'Card sponsor nelle pagine voli',
                        'Integrazione link di prenotazione',
                        'Report mensili click & impression',
                    ] as $item)
                        <li class="flex items-start gap-2 text-gray-600">
                            <span class="text-blue font-bold mt-0.5">✓</span> {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <div class="border-t pt-5">
                    <div class="text-navy/50 text-sm mb-1">A partire da</div>
                    <div class="text-4xl font-black text-navy mb-4">€900<span class="text-base font-normal text-gray-400">/anno</span></div>
                    <a href="{{ route('contact') }}" class="block w-full text-center bg-navy text-white py-3 rounded-xl font-bold hover:bg-blue transition-colors">
                        Richiedi info →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PERCHÉ SCEGLIERCI --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">PERCHÉ NOI</span>
        <h2 class="text-4xl font-black text-navy mb-12 max-w-xl">Un'audience qualificata e motivata a viaggiare</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => '🎯', 'title' => 'Audience mirata', 'desc' => 'Ogni visitatore è un potenziale turista in arrivo o in partenza da Reggio Calabria.'],
                ['icon' => '🌍', 'title' => 'Multilingua', 'desc' => 'Il portale è disponibile in italiano, inglese, tedesco e francese per raggiungere turisti europei.'],
                ['icon' => '📊', 'title' => 'Dati trasparenti', 'desc' => 'Report mensili con metriche reali: visite, click, conversioni e ROI misurabili.'],
                ['icon' => '🚀', 'title' => 'Crescita garantita', 'desc' => 'Con il target di 1 milione di passeggeri entro il 2026, la visibilità è destinata a crescere.'],
            ] as $item)
                <div class="bg-offwhite rounded-2xl p-6">
                    <div class="text-4xl mb-4">{{ $item['icon'] }}</div>
                    <h3 class="font-bold text-navy mb-2">{{ $item['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA CONTATTO --}}
<section class="py-20 px-4 bg-navy">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-black text-white mb-4">Parliamoci</h2>
        <p class="text-white/60 text-lg mb-8">
            Contattaci per un preventivo personalizzato o per fissare una presentazione. Risposta garantita entro 24 ore.
        </p>
        <a href="{{ route('contact') }}" class="btn-primary text-base">
            📧 Contattaci ora
        </a>
        <p class="text-white/40 text-sm mt-4">oppure scrivi a <span class="text-gold">partnership@aeroportoreggiocalabria.it</span></p>
    </div>
</section>

@endsection
