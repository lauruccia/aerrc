@extends('layouts.app')

@section('title', 'Aeroporto Tito Minniti — Reggio Calabria')
@section('description', 'Informazioni sull\'Aeroporto Internazionale di Reggio Calabria Tito Minniti (REG/LICR): orari, mappa, come arrivare, terminal e contatti.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            🏛️ &nbsp;L'AEROPORTO
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-3">
            Aeroporto<br>
            <span class="text-gold">Tito Minniti</span>
        </h1>
        <p class="text-white/70 text-lg max-w-xl">
            L'aeroporto internazionale di Reggio Calabria. Codice IATA: <strong class="text-white">REG</strong> · Codice ICAO: <strong class="text-white">LICR</strong>
        </p>
    </div>
</section>

{{-- INFO PRINCIPALI + METEO --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Scheda aeroporto --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                <h2 class="text-2xl font-black text-navy mb-6 flex items-center gap-2">
                    📋 Informazioni generali
                </h2>
                <ul class="space-y-0 divide-y divide-offwhite text-sm">
                    @foreach([
                        ['icon' => '✈️', 'label' => 'Nome ufficiale', 'value' => 'Aeroporto dello Stretto di Reggio Calabria – Tito Minniti'],
                        ['icon' => '📍', 'label' => 'Indirizzo', 'value' => 'Via Ravagnese, 1 — 89131 Reggio Calabria (RC)'],
                        ['icon' => '🗺️', 'label' => 'Coordinate', 'value' => '38°4′12″N 15°39′6″E'],
                        ['icon' => '📞', 'label' => 'Telefono', 'value' => '+39 0965 640 517'],
                        ['icon' => '📧', 'label' => 'Email', 'value' => 'info@sacal.it'],
                        ['icon' => '🏷️', 'label' => 'Codici', 'value' => 'IATA: REG · ICAO: LICR'],
                        ['icon' => '🏢', 'label' => 'Gestore', 'value' => 'SACAL SpA (Società Aeroportuale Calabrese)'],
                        ['icon' => '🕐', 'label' => 'Orari operativi', 'value' => 'Tutti i giorni: 05:30 – 22:30'],
                        ['icon' => '🛫', 'label' => 'Piste', 'value' => '1 pista, orientamento 15/33, lunghezza 2.385 m'],
                        ['icon' => '📦', 'label' => 'Terminal', 'value' => 'Terminal unico: partenze (piano 1), arrivi (piano 0)'],
                    ] as $row)
                        <li class="flex items-start gap-3 py-3">
                            <span class="text-xl w-7 shrink-0">{{ $row['icon'] }}</span>
                            <div>
                                <div class="font-semibold text-navy">{{ $row['label'] }}</div>
                                <div class="text-gray-500">{{ $row['value'] }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Meteo --}}
            <div class="space-y-6">
                @livewire('weather-widget')

                {{-- Mappa posizione --}}
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                    <h3 class="font-bold text-navy mb-4 flex items-center gap-2">📍 Posizione</h3>
                    <div class="rounded-xl overflow-hidden">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=15.616%2C38.063%2C15.666%2C38.087&layer=mapnik&marker=38.0717%2C15.6531"
                            width="100%" height="250" frameborder="0"
                            class="w-full" style="border:0;" loading="lazy">
                        </iframe>
                    </div>
                    <a href="https://www.openstreetmap.org/?mlat=38.0717&mlon=15.6531#map=15/38.0717/15.6531"
                       target="_blank" rel="noopener"
                       class="text-sky text-sm font-semibold hover:underline mt-2 inline-block">
                        Apri su OpenStreetMap →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- COME ARRIVARE --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">TRASPORTI</span>
        <h2 class="text-4xl font-black text-navy mb-10">Come arrivare all'aeroporto</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['icon' => '🚌', 'title' => 'Autobus ATM', 'desc' => 'Linea 13 dal centro di Reggio Calabria. Fermata direttamente in aeroporto. Frequenza ogni 30 minuti.', 'detail' => '~25 min dal centro'],
                ['icon' => '🚕', 'title' => 'Taxi', 'desc' => 'Taxi autorizzati disponibili all\'uscita arrivi. Prenotazione consigliata nelle ore di punta.', 'detail' => '~10 min · tariffa fissa'],
                ['icon' => '🚗', 'title' => 'Auto privata', 'desc' => 'Autostrada A2 uscita Reggio Calabria Sud, poi SS106 verso Ravagnese. Parcheggio disponibile.', 'detail' => 'Parcheggio disponibile'],
                ['icon' => '🚆', 'title' => 'Treno + bus', 'desc' => 'Treno fino alla stazione Reggio Calabria Centrale, poi autobus ATM linea 13 per l\'aeroporto.', 'detail' => 'FS + ATM · consigliato'],
            ] as $t)
                <div class="bg-offwhite rounded-2xl p-6">
                    <div class="text-4xl mb-4">{{ $t['icon'] }}</div>
                    <h3 class="font-bold text-navy mb-2">{{ $t['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-3">{{ $t['desc'] }}</p>
                    <span class="inline-block bg-navy text-gold text-xs font-bold px-3 py-1 rounded-full">{{ $t['detail'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- STORIA --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-4xl mx-auto">
        <span class="section-tag">STORIA</span>
        <h2 class="text-4xl font-black text-navy mb-8">Tito Minniti: un eroe dello Stretto</h2>
        <div class="bg-white rounded-2xl p-8 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
            <p class="text-gray-600 leading-relaxed mb-4">
                L'aeroporto di Reggio Calabria è intitolato a <strong>Tito Minniti</strong>, aviatore reggino nato nel 1909 e caduto in battaglia nel 1935 durante la guerra d'Etiopia. Minniti è considerato un eroe dell'aviazione italiana per il suo coraggio e la sua dedizione.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Lo scalo è operativo dal <strong>1939</strong> e ha svolto nel tempo un ruolo strategico fondamentale per il collegamento della Calabria con il resto d'Italia e con l'Europa. Gestito dalla SACAL SpA insieme agli aeroporti di Lamezia Terme e Crotone, fa parte del sistema aeroportuale calabrese.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Con oltre <strong>622.000 passeggeri l'anno</strong> e un ambizioso piano di sviluppo che punta al milione entro il 2026, l'aeroporto di Reggio Calabria è in forte crescita, con nuove rotte e compagnie interessate ad operare dallo Stretto.
            </p>
        </div>
    </div>
</section>

@endsection
