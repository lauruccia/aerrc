@extends('layouts.app')

@section('title', $article->title . ' — Turismo Calabria')
@section('description', $article->excerpt ?? 'Scopri la Calabria: guida turistica dal portale Aeroporto Reggio Calabria.')

@section('content')

{{-- HERO --}}
<section class="relative pt-28 pb-20 px-4 overflow-hidden flex items-end min-h-[50vh]"
         style="background: linear-gradient(135deg, {{ $article->color_from ?? '#0D2B4B' }}, {{ $article->color_to ?? '#1A5276' }})">
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
    <div class="relative z-10 max-w-4xl mx-auto w-full">
        <a href="{{ route('tourism') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white text-sm mb-6 transition-colors">
            ← Tutti gli articoli
        </a>
        <span class="inline-block bg-gold text-navy text-xs font-bold px-3 py-1 rounded-full mb-4">
            {{ $article->category_label }}
        </span>
        <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-3">
            {{ $article->title }}
        </h1>
        @if($article->excerpt)
            <p class="text-white/75 text-lg max-w-2xl">{{ $article->excerpt }}</p>
        @endif
        <p class="text-white/40 text-sm mt-4">
            Pubblicato il {{ $article->published_at?->format('d M Y') }}
        </p>
    </div>
</section>

{{-- CONTENUTO --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-[0_4px_20px_rgba(0,0,0,0.08)] prose prose-lg max-w-none">
            @if($article->body)
                {!! nl2br(e($article->body)) !!}
            @else
                <p class="text-gray-500">Contenuto in fase di redazione. Torna presto per leggere l'articolo completo.</p>
            @endif
        </div>

        {{-- CTA --}}
        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <a href="{{ route('flights.index') }}"
               class="flex items-center gap-4 bg-navy rounded-2xl p-5 text-white hover:bg-blue transition-colors">
                <span class="text-3xl">✈️</span>
                <div>
                    <div class="font-bold">Prenota il tuo volo</div>
                    <div class="text-white/60 text-sm">Partenze da Reggio Calabria</div>
                </div>
            </a>
            <a href="{{ route('tourism') }}"
               class="flex items-center gap-4 bg-white rounded-2xl p-5 text-navy hover:shadow-md transition-shadow border border-black/5">
                <span class="text-3xl">🗺️</span>
                <div>
                    <div class="font-bold text-navy">Altre guide</div>
                    <div class="text-gray-500 text-sm">Scopri tutta la Calabria</div>
                </div>
            </a>
        </div>
    </div>
</section>

@endsection
