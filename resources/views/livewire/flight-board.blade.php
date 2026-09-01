<div wire:poll.{{ $pollInterval }}ms="poll">
    <style>
        .badge-on-time   { background: rgba(16,185,129,.22);  color: #6ee7b7; font-weight:700; }
        .badge-active    { background: rgba(59,130,246,.25);  color: #93c5fd; font-weight:700; }
        .badge-landed    { background: rgba(139,92,246,.25);  color: #c4b5fd; font-weight:700; }
        .badge-delayed   { background: rgba(250,204,21,.22);  color: #fde047; font-weight:700; }
        .badge-cancelled { background: rgba(239,68,68,.22);   color: #fca5a5; font-weight:700; }
    </style>
    {{-- Tabs + controlli --}}
    <div class="flex items-center gap-3 mb-6 flex-wrap">
        <button wire:click="switchTab('departures')"
                class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm transition-all
                       {{ $tab === 'departures' ? 'bg-gold text-navy' : 'bg-white/10 text-white/70 hover:bg-white/15' }}">
            ✈ {{ __('flights.departures') }}
        </button>
        <button wire:click="switchTab('arrivals')"
                class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm transition-all
                       {{ $tab === 'arrivals' ? 'bg-gold text-navy' : 'bg-white/10 text-white/70 hover:bg-white/15' }}">
            ↓ {{ __('flights.arrivals') }}
        </button>

        <div class="ml-auto flex items-center gap-4">
            {{-- Indicatore LIVE / PAUSED --}}
            <span class="flex items-center gap-2 text-xs {{ $liveAvailable && $autoRefresh ? 'text-green-400' : ($liveAvailable ? 'text-white/40' : 'text-red-300') }}">
                <span class="w-2 h-2 rounded-full {{ $liveAvailable && $autoRefresh ? 'bg-green-400 animate-pulse' : ($liveAvailable ? 'bg-white/30' : 'bg-red-400') }}"></span>
                @if(!$liveAvailable)
                    DATI LIVE NON DISPONIBILI
                @elseif($autoRefresh)
                    LIVE · {{ __('flights.last_update', ['time' => $lastUpdate]) }}
                @else
                    PAUSA · {{ __('flights.last_update', ['time' => $lastUpdate]) }}
                @endif
            </span>

            {{-- Toggle auto-refresh --}}
            <button wire:click="toggleAutoRefresh"
                    title="{{ $autoRefresh ? 'Metti in pausa l\'aggiornamento automatico' : 'Riprendi aggiornamento automatico' }}"
                    class="text-white/50 hover:text-gold transition-colors text-xs flex items-center gap-1">
                @if($autoRefresh)
                    {{-- Icona pausa --}}
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                    </svg>
                @else
                    {{-- Icona play --}}
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                @endif
            </button>

            {{-- Refresh manuale --}}
            <button wire:click="refresh"
                    wire:loading.attr="disabled"
                    title="Ricarica il tabellone"
                    class="text-white/60 hover:text-gold transition-colors text-xs flex items-center gap-1">
                <svg wire:loading.class="animate-spin" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                {{ __('flights.refresh') }}
            </button>
        </div>
    </div>

    {{-- Tabella voli --}}
    <div class="bg-white/[0.06] rounded-2xl overflow-hidden border border-white/10">

        {{-- Header --}}
        <div class="flight-table-header">
            <span>{{ __('flights.time') }}</span>
            <span>{{ $tab === 'departures' ? __('flights.destination') : __('flights.origin') }}</span>
            <span>{{ __('flights.airline') }}</span>
            <span>{{ __('flights.flight') }}</span>
            <span>{{ __('flights.status') }}</span>
        </div>

        {{-- Righe voli --}}
        <div wire:loading.class="opacity-50 pointer-events-none">
            @forelse($flights as $flight)
                <div class="flight-table-row animate-fade-in">

                    {{-- Orario --}}
                    <div>
                        <div class="text-xl font-bold text-white font-mono">{{ $flight['scheduled_time'] }}</div>
                        @if($flight['estimated_time'] && $flight['estimated_time'] !== $flight['scheduled_time'])
                            <div class="text-xs text-yellow-400 mt-0.5">→ {{ $flight['estimated_time'] }}</div>
                        @endif
                    </div>

                    {{-- Aeroporto --}}
                    <div>
                        <div class="font-semibold text-white text-sm">{{ $flight['airport_name'] }}</div>
                        <div class="text-xs text-white/50 mt-0.5">
                            {{ $flight['airport_iata'] }}
                            @if($flight['terminal'])
                                · T{{ $flight['terminal'] }}
                            @endif
                            @if($flight['gate'])
                                · Gate {{ $flight['gate'] }}
                            @endif
                        </div>
                    </div>

                    {{-- Compagnia --}}
                    <div class="text-white/70 text-sm">{{ $flight['airline_name'] }}</div>

                    {{-- Numero volo --}}
                    <div class="text-white/60 text-sm font-mono tracking-wider">{{ $flight['flight_number'] }}</div>

                    {{-- Badge stato --}}
                    <div>
                        <span class="{{ $flight['status_badge']['class'] }}">
                            {{ $flight['status_badge']['label'] }}
                        </span>
                        @if($flight['actual_time'] && $flight['actual_time'] !== $flight['scheduled_time'])
                            <div class="text-xs text-white/65 mt-1">Atterrato/Partito: {{ $flight['actual_time'] }}</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-white/50">
                    <div class="text-4xl mb-3">✈️</div>
                    <p>{{ __('flights.no_flights') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Loading overlay --}}
        <div wire:loading class="py-8 text-center text-white/60 text-sm">
            <div class="inline-flex items-center gap-2">
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                {{ __('flights.loading') }}
            </div>
        </div>
    </div>
</div>
