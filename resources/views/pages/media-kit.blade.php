@extends('layouts.app')

@section('title', 'Media Kit — Aeroporto Reggio Calabria')
@section('description', 'Scarica il media kit ufficiale del portale Aeroporto Reggio Calabria. Dati di audience, statistiche, opportunità di partnership e posizionamento editoriale.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto flex flex-col lg:flex-row items-start lg:items-center gap-10">
        <div class="flex-1">
            <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
                📄 &nbsp;MEDIA KIT {{ date('Y') }}
            </span>
            <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-4">
                Press &amp; Media Kit
            </h1>
            <p class="text-white/70 text-lg max-w-xl leading-relaxed mb-8">
                Tutto ciò che serve per una proposta di partnership istituzionale o commerciale. Dati aggiornati, posizionamento editoriale e opportunità di collaborazione.
            </p>
            <a href="{{ asset('media/ARC_MediaKit_2026.pdf') }}"
               class="btn-primary inline-flex items-center gap-2"
               download>
                ⬇️ Scarica Media Kit PDF
            </a>
        </div>
        <div class="w-48 h-48 shrink-0 hidden lg:block">
            <img src="{{ asset('img/logo-full.svg') }}" alt="ARC Logo" class="w-full h-full object-contain">
        </div>
    </div>
</section>

{{-- NUMERI CHIAVE --}}
<section class="py-16 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">IL PORTALE IN NUMERI</span>
        <h2 class="text-3xl font-black text-navy mb-10">Dati e audience</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-14">
            @foreach([
                ['622K+',  'Passeggeri/anno scalo REG', 'Bacino di utenza potenziale diretto'],
                ['4',      'Lingue',                    'IT · EN · DE · FR per utenti internazionali'],
                ['15+',    'Rotte attive',               'Destinazioni servite dallo scalo di Reggio Calabria'],
                ['1M',     'Target viaggiatori/anno',   'Obiettivo di traffico del portale'],
            ] as [$num, $label, $sub])
            <div class="bg-white rounded-2xl p-6 border border-black/5 shadow-sm text-center">
                <div class="text-4xl font-black text-gold mb-1">{{ $num }}</div>
                <div class="text-sm font-semibold text-navy mb-1">{{ $label }}</div>
                <div class="text-xs text-gray-400 leading-tight">{{ $sub }}</div>
            </div>
            @endforeach
        </div>

        {{-- POSIZIONAMENTO --}}
        <h3 class="text-2xl font-black text-navy mb-6">Posizionamento editoriale</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-14">
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <h4 class="font-bold text-navy mb-3 flex items-center gap-2">✈️ Informazione sui voli</h4>
                <p class="text-sm text-gray-600 leading-relaxed">Tabellone voli live con partenze e arrivi aggiornati in tempo reale. Prima fonte di riferimento per i passeggeri dello scalo REG.</p>
            </div>
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <h4 class="font-bold text-navy mb-3 flex items-center gap-2">🗺️ Portale turistico regionale</h4>
                <p class="text-sm text-gray-600 leading-relaxed">Guide alle destinazioni calabresi, itinerari, cultura, enogastronomia. Punto di accesso privilegiato per il turista che atterra in Calabria.</p>
            </div>
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <h4 class="font-bold text-navy mb-3 flex items-center gap-2">🌍 Audience internazionale</h4>
                <p class="text-sm text-gray-600 leading-relaxed">Disponibile in italiano, inglese, tedesco e francese. Raggiunge i mercati turistici europei ad alto potenziale per la Calabria.</p>
            </div>
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <h4 class="font-bold text-navy mb-3 flex items-center gap-2">🔍 SEO locale avanzato</h4>
                <p class="text-sm text-gray-600 leading-relaxed">Ottimizzato per le ricerche legate al turismo calabrese con Schema.org, hreflang e geo-meta. Alta visibilità su Google per query chiave.</p>
            </div>
        </div>

        {{-- OPPORTUNITÀ --}}
        <h3 class="text-2xl font-black text-navy mb-6">Opportunità di collaborazione</h3>
        <div class="overflow-hidden rounded-2xl border border-black/5 shadow-sm">
            <table class="w-full text-sm">
                <thead class="bg-navy text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Formato</th>
                        <th class="px-6 py-4 text-left font-semibold">Posizione</th>
                        <th class="px-6 py-4 text-left font-semibold">Dettagli</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach([
                        ['Logo partner', 'Homepage + footer', 'Brand awareness su tutte le pagine del portale'],
                        ['Articolo sponsorizzato', 'Sezione Turismo', 'Contenuto editoriale dedicato all\'ente/prodotto'],
                        ['Banner display', 'Voli / Destinazioni', 'Formati standard (728×90, 300×250)'],
                        ['Sezione dedicata', 'Destinazioni', 'Pagina destinazione con contenuti personalizzati'],
                        ['Partnership istituzionale', 'Tutto il sito', 'Co-branding, loghi, menzione in comunicati stampa'],
                    ] as [$format, $pos, $detail])
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-navy">{{ $format }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $pos }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $detail }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-navy py-16 px-4 text-center">
    <div class="max-w-xl mx-auto">
        <h2 class="text-3xl font-black text-white mb-3">Interessato a collaborare?</h2>
        <p class="text-white/70 mb-8">Compila il form di partnership o scarica il media kit completo per approfondire.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('become-partner') }}" class="btn-primary">🤝 Proponi una partnership</a>
            <a href="{{ asset('media/ARC_MediaKit_2026.pdf') }}"
               class="btn-secondary" download>⬇️ Scarica Media Kit</a>
        </div>
    </div>
</section>

@endsection
