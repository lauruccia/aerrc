@extends('layouts.app')

@section('title', 'Turismo Calabria — Aeroporto Reggio Calabria')
@section('description', 'Scopri la Calabria: natura, storia, mare, borghi e gastronomia. La guida turistica ufficiale del portale Aeroporto Reggio Calabria.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <svg viewBox="0 0 1200 400" class="w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="900" cy="100" rx="500" ry="280" fill="#C9A84C"/>
            <ellipse cx="150" cy="380" rx="300" ry="180" fill="#1A5276"/>
        </svg>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            🗺️ &nbsp;TURISMO CALABRIA
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-3">
            Scopri la Calabria
        </h1>
        <p class="text-white/70 text-lg max-w-2xl">
            Mare cristallino, borghi millenari, cucina autentica e paesaggi mozzafiato. La Calabria ti aspetta — e si raggiunge da Reggio Calabria.
        </p>
    </div>
</section>

{{-- CATEGORIE --}}
<section class="bg-navy pb-10 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-wrap gap-3">
            @foreach([
                ['slug' => '', 'label' => '🌐 Tutto'],
                ['slug' => 'natura', 'label' => '🌿 Natura'],
                ['slug' => 'storia', 'label' => '🏛️ Storia'],
                ['slug' => 'mare', 'label' => '🏖️ Mare'],
                ['slug' => 'gastronomia', 'label' => '🍝 Gastronomia'],
                ['slug' => 'borghi', 'label' => '🏘️ Borghi'],
                ['slug' => 'eventi', 'label' => '🎭 Eventi'],
            ] as $cat)
                <a href="{{ route('tourism') }}{{ $cat['slug'] ? '?cat=' . $cat['slug'] : '' }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold border transition-all
                          {{ (request('cat') === $cat['slug'] || (!request('cat') && $cat['slug'] === ''))
                             ? 'bg-gold text-navy border-gold'
                             : 'border-white/30 text-white/70 hover:border-gold hover:text-gold' }}">
                    {{ $cat['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ARTICOLI --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">

        @if($articles->isEmpty())
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🌅</div>
                <h3 class="text-2xl font-bold text-navy mb-2">Contenuti in arrivo</h3>
                <p class="text-gray-500">Stiamo preparando le guide turistiche sulla Calabria. Torna presto!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $index => $article)
                    <a href="{{ route('tourism.show', $article->slug) }}"
                       class="bg-white rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.08)] card-hover block group
                              {{ $index === 0 ? 'md:col-span-2' : '' }}">
                        <div class="relative flex items-end p-6 {{ $index === 0 ? 'h-72' : 'h-56' }}"
                             style="background: linear-gradient(135deg, {{ $article->color_from ?? '#0D2B4B' }}, {{ $article->color_to ?? '#1A5276' }})">
                            <span class="absolute top-4 left-4 bg-gold text-navy text-xs font-bold px-3 py-1 rounded-full z-10">
                                {{ $article->category_label }}
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/85 to-transparent"></div>
                            <div class="relative z-10">
                                <h3 class="text-white font-bold text-xl leading-tight">{{ $article->title }}</h3>
                                <p class="text-white/60 text-xs mt-1">{{ $article->published_at?->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-500 text-sm leading-relaxed mb-3 line-clamp-2">{{ $article->excerpt }}</p>
                            <span class="text-sky text-sm font-semibold group-hover:translate-x-1 transition-transform inline-block">
                                Leggi di più →
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</section>

{{-- BANNER CALABRIA --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach([
                ['emoji' => '🏖️', 'num' => '800 km', 'label' => 'di coste'],
                ['emoji' => '🏛️', 'num' => '3000+', 'label' => 'anni di storia'],
                ['emoji' => '🌊', 'num' => '2 mari', 'label' => 'Ionio e Tirreno'],
                ['emoji' => '🧀', 'num' => '100+', 'label' => 'prodotti DOP/IGP'],
            ] as $stat)
                <div class="text-center bg-offwhite rounded-2xl p-6">
                    <div class="text-4xl mb-2">{{ $stat['emoji'] }}</div>
                    <div class="text-3xl font-black text-navy">{{ $stat['num'] }}</div>
                    <div class="text-gray-500 text-sm">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
