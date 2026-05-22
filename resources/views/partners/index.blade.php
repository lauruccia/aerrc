@extends('layouts.app')

@section('title', 'Partnership — Aeroporto Reggio Calabria')
@section('description', 'Collabora con il portale turistico di riferimento per la Calabria. Partnership istituzionali e commerciali per Regione Calabria, enti locali, operatori turistici e aziende del territorio.')

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
            Costruiamo insieme<br>
            <span class="text-gold">il turismo in Calabria</span>
        </h1>
        <p class="text-white/70 text-xl max-w-2xl mx-auto mb-10">
            Il primo portale di riferimento per i viaggiatori dello scalo di Reggio Calabria.
            Una piattaforma istituzionale, multilingue, al servizio del territorio.
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
            @foreach([
                ['622K+', 'Passeggeri/anno'],
                ['1M',    'Target 2026'],
                ['4',     'Lingue'],
                ['15+',   'Rotte attive'],
            ] as [$num, $label])
                <div class="glass-card py-4 px-3">
                    <div class="text-3xl font-black text-gold">{{ $num }}</div>
                    <div class="text-white/60 text-xs mt-1">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CHI PUÒ COLLABORARE --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">CON CHI LAVORIAMO</span>
        <h2 class="text-4xl font-black text-navy mb-3">A chi è rivolto</h2>
        <p class="text-gray-500 text-lg mb-12 max-w-2xl">
            Due aree di collaborazione: istituzioni e PA da un lato, operatori privati e aziende dall'altro.
            Ogni proposta viene costruita su misura.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- ISTITUZIONALE --}}
            <div class="bg-white rounded-2xl p-8 border-2 border-gold shadow-[0_4px_20px_rgba(201,168,76,0.15)] relative">
                <div class="absolute -top-3 left-6 bg-gold text-navy text-xs font-black px-3 py-1 rounded-full tracking-widest">ISTITUZIONALE</div>
                <div class="text-5xl mb-5">🏛️</div>
                <h3 class="text-2xl font-black text-navy mb-3">Enti e Istituzioni</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Regione Calabria, Città Metropolitana di Reggio Calabria, SACAL, Comuni, Pro Loco,
                    Camere di Commercio, Parchi Nazionali e Regionali, enti di promozione turistica.
                </p>
                <ul class="space-y-2.5 mb-8 text-sm">
                    @foreach([
                        'Co-branding istituzionale su tutto il portale',
                        'Sezioni dedicate alla promozione del territorio',
                        'Integrazione con gli eventi e i calendari regionali',
                        'Visibilità multilingue su IT, EN, DE, FR',
                        'Report e dati di accesso per rendicontazione',
                        'Presenza nel Media Kit e nei comunicati stampa',
                    ] as $item)
                        <li class="flex items-start gap-2 text-gray-600">
                            <span class="text-gold font-bold mt-0.5 shrink-0">✓</span> {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('become-partner') }}"
                   class="block w-full text-center bg-gold text-navy py-3.5 rounded-xl font-bold hover:bg-yellow-400 transition-colors">
                    Proponi una collaborazione →
                </a>
            </div>

            {{-- COMMERCIALE --}}
            <div class="bg-white rounded-2xl p-8 border border-black/5 shadow-[0_4px_20px_rgba(0,0,0,0.06)]">
                <div class="text-5xl mb-5">🏢</div>
                <h3 class="text-2xl font-black text-navy mb-3">Operatori e Aziende</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Hotel, resort, strutture ricettive, agenzie di viaggio, tour operator, autonoleggi,
                    ristoranti, produttori locali, artigiani e chiunque voglia raggiungere i viaggiatori
                    che arrivano in Calabria.
                </p>
                <ul class="space-y-2.5 mb-8 text-sm">
                    @foreach([
                        'Visibilità nelle sezioni Turismo e Destinazioni',
                        'Listing nella pagina Servizi aeroportuali',
                        'Contenuti editoriali e articoli sponsorizzati',
                        'Presenza nelle pagine voli e destinazioni',
                        'Link diretto a prenotazione o sito web',
                        'Report periodici su reach e interazioni',
                    ] as $item)
                        <li class="flex items-start gap-2 text-gray-600">
                            <span class="text-sky font-bold mt-0.5 shrink-0">✓</span> {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('become-partner') }}"
                   class="block w-full text-center bg-navy text-white py-3.5 rounded-xl font-bold hover:bg-blue transition-colors">
                    Proponi una collaborazione →
                </a>
            </div>
        </div>
    </div>
</section>

{{-- PERCHÉ QUESTO PORTALE --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">PERCHÉ NOI</span>
        <h2 class="text-4xl font-black text-navy mb-12 max-w-xl">Un'audience qualificata, in un momento chiave del viaggio</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['🎯', 'Momento decisionale', 'Il viaggiatore consulta il portale mentre pianifica o subito dopo l\'atterraggio: è il momento con la più alta intenzione d\'acquisto.'],
                ['🌍', 'Multilingua nativo', 'Disponibile in italiano, inglese, tedesco e francese. Raggiungi il turista europeo nel suo contesto linguistico.'],
                ['📊', 'Dati reali', 'Ogni collaborazione include report chiari: accessi, visualizzazioni, interazioni. Nessun dato gonfiato.'],
                ['📈', 'Crescita strutturale', 'Il piano di sviluppo dello scalo REG punta a 1 milione di passeggeri entro il 2026. La visibilità cresce con noi.'],
            ] as [$icon, $title, $desc])
                <div class="bg-offwhite rounded-2xl p-6">
                    <div class="text-4xl mb-4">{{ $icon }}</div>
                    <h3 class="font-bold text-navy mb-2">{{ $title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- COME FUNZIONA --}}
<section class="py-16 px-4 bg-offwhite">
    <div class="max-w-4xl mx-auto text-center">
        <span class="section-tag">COME FUNZIONA</span>
        <h2 class="text-3xl font-black text-navy mb-10">Tre passi per iniziare</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
            @foreach([
                ['01', 'Invia la proposta', 'Compila il form con i tuoi obiettivi e il tipo di ente o azienda. Bastano 3 minuti.'],
                ['02', 'Incontro di presentazione', 'Ti ricontattiamo entro 48 ore per capire le tue esigenze e costruire una proposta su misura.'],
                ['03', 'Vai online', 'Definiamo insieme contenuti, formati e durata. La tua presenza sul portale è attiva in pochi giorni.'],
            ] as [$num, $title, $desc])
                <div class="bg-white rounded-2xl p-6 border border-black/5">
                    <div class="text-3xl font-black text-gold/30 mb-3">{{ $num }}</div>
                    <h3 class="font-bold text-navy mb-2">{{ $title }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 px-4 bg-navy">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-black text-white mb-4">Parliamoci</h2>
        <p class="text-white/60 text-lg mb-8">
            Ogni collaborazione è costruita su misura. Raccontaci il tuo progetto e troveremo insieme la formula giusta.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('become-partner') }}" class="btn-primary text-base">
                🤝 Invia una proposta
            </a>
            <a href="{{ route('media-kit') }}" class="btn-secondary text-base">
                📄 Scarica il Media Kit
            </a>
        </div>
        <p class="text-white/40 text-sm mt-5">
            oppure scrivi a <span class="text-gold">partnership@aeroportoreggiocalabria.it</span>
        </p>
    </div>
</section>

@endsection
