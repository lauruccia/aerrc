@extends('layouts.app')

@section('title', 'Servizi — Aeroporto Reggio Calabria')
@section('description', 'Tutti i servizi dell\'Aeroporto di Reggio Calabria Tito Minniti: parcheggi, noleggio auto, ristoranti, cambio valuta e molto altro.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            🛎️ &nbsp;SERVIZI
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-3">
            Servizi in aeroporto
        </h1>
        <p class="text-white/70 text-lg max-w-xl">
            Tutto quello che ti serve prima, durante e dopo il volo. L'aeroporto Tito Minniti di Reggio Calabria al tuo servizio.
        </p>
    </div>
</section>

{{-- SERVIZI GRIGLIA --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach([
                [
                    'icon' => '🅿️', 'bg' => 'bg-blue/10', 'color' => 'text-blue',
                    'title' => 'Parcheggi',
                    'desc' => 'Parcheggio a breve e lungo termine direttamente in aeroporto. Tariffe convenzionate per soste superiori a 24 ore. Parcheggio coperto disponibile.',
                    'info' => ['🕐 Aperto 24/7', '💶 Da €5/giorno', '📍 Fronte aeroporto'],
                ],
                [
                    'icon' => '🚗', 'bg' => 'bg-gold/10', 'color' => 'text-gold',
                    'title' => 'Noleggio Auto',
                    'desc' => 'I principali operatori di car rental sono presenti in aeroporto: Hertz, Avis, Europcar. Prenota in anticipo per le migliori tariffe.',
                    'info' => ['✅ Prenota online', '🔑 Ritiro immediato', '♾️ Chilometri illimitati'],
                ],
                [
                    'icon' => '🏨', 'bg' => 'bg-sky/10', 'color' => 'text-sky',
                    'title' => 'Hotel convenzionati',
                    'desc' => 'Hotel partner a pochi minuti dall\'aeroporto con shuttle gratuito. Soluzioni per ogni budget, da 1 a 5 stelle nel centro di Reggio Calabria.',
                    'info' => ['🚐 Shuttle gratuito', '⭐ Da 1 a 5 stelle', '📞 Prenotazione diretta'],
                ],
                [
                    'icon' => '🍽️', 'bg' => 'bg-amber/10', 'color' => 'text-amber-600',
                    'title' => 'Ristoranti & Bar',
                    'desc' => 'Bar, ristorante e punto snack all\'interno del terminal. Prodotti locali calabresi e cucina italiana. Aperto dalle 5:30 fino all\'ultimo volo.',
                    'info' => ['🕐 05:30 – ultimo volo', '🧀 Prodotti calabresi', '☕ Colazione inclusa'],
                ],
                [
                    'icon' => '💱', 'bg' => 'bg-green-100', 'color' => 'text-green-700',
                    'title' => 'Cambio Valuta',
                    'desc' => 'Sportello cambio valuta disponibile nel terminal arrivi. Cambio di tutte le principali valute internazionali con tariffe competitive.',
                    'info' => ['💵 Tutte le valute', '📋 Nessuna commissione fissa', '⚡ Servizio rapido'],
                ],
                [
                    'icon' => '♿', 'bg' => 'bg-purple-100', 'color' => 'text-purple-700',
                    'title' => 'Accessibilità',
                    'desc' => 'L\'aeroporto è completamente accessibile per persone con disabilità motoria. Assistenza dedicata PRM disponibile su prenotazione.',
                    'info' => ['🛺 Assistenza PRM', '📲 Prenota 48h prima', '♿ Accesso completo'],
                ],
                [
                    'icon' => '🛡️', 'bg' => 'bg-red-100', 'color' => 'text-red-700',
                    'title' => 'Sicurezza',
                    'desc' => 'Controlli di sicurezza efficienti con personale specializzato. Per velocizzare il passaggio: liquidi in buste trasparenti, laptop fuori dallo zaino.',
                    'info' => ['⚡ Tempi medi: 10 min', '👮 Personale qualificato', '📋 Vedi regole bagaglio'],
                ],
                [
                    'icon' => 'ℹ️', 'bg' => 'bg-navy/10', 'color' => 'text-navy',
                    'title' => 'Informazioni',
                    'desc' => 'Desk informazioni situato nell\'area arrivi. Il personale parla italiano e inglese. Disponibile anche il servizio di interpretariato su richiesta.',
                    'info' => ['📞 0965 640 517', '🕐 05:30 – 22:30', '🇬🇧 English spoken'],
                ],
                [
                    'icon' => '📶', 'bg' => 'bg-sky/10', 'color' => 'text-sky',
                    'title' => 'Wi-Fi Gratuito',
                    'desc' => 'Connessione Wi-Fi gratuita in tutto il terminal. Rete: AeroportoRC_Free. Nessuna registrazione richiesta. Velocità fino a 50 Mbps.',
                    'info' => ['📡 Tutto il terminal', '🆓 Gratuito', '⚡ Fino a 50 Mbps'],
                ],
            ] as $service)
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)] border border-black/5">
                    <div class="w-14 h-14 {{ $service['bg'] }} rounded-2xl flex items-center justify-center text-2xl mb-5">
                        {{ $service['icon'] }}
                    </div>
                    <h3 class="font-bold text-navy text-lg mb-2">{{ $service['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $service['desc'] }}</p>
                    <div class="space-y-1">
                        @foreach($service['info'] as $i)
                            <div class="text-xs {{ $service['color'] }} font-medium">{{ $i }}</div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 px-4 bg-navy text-center">
    <h2 class="text-3xl font-black text-white mb-3">Hai bisogno di assistenza?</h2>
    <p class="text-white/60 mb-6">Il nostro staff è disponibile tutti i giorni dalle 05:30 alle 22:30.</p>
    <a href="{{ route('contact') }}" class="btn-primary">Contattaci</a>
</section>

@endsection
