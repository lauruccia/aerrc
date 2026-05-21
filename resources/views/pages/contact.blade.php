@extends('layouts.app')

@section('title', 'Contatti — Aeroporto Reggio Calabria')
@section('description', 'Contatta il portale Aeroporto Reggio Calabria per informazioni, partnership commerciali e collaborazioni istituzionali.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            📬 &nbsp;CONTATTI
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-3">
            Parliamo insieme
        </h1>
        <p class="text-white/70 text-lg max-w-xl">
            Per informazioni, partnership, segnalazioni o collaborazioni istituzionali. Risposta garantita entro 24 ore.
        </p>
    </div>
</section>

{{-- FORM + CONTATTI --}}
<section class="py-20 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                    <h2 class="text-2xl font-black text-navy mb-6">Invia un messaggio</h2>

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">Nome *</label>
                                <input type="text" name="name" required
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm transition-all"
                                       placeholder="Il tuo nome">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-navy mb-2">Email *</label>
                                <input type="email" name="email" required
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm transition-all"
                                       placeholder="tua@email.it">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-navy mb-2">Oggetto *</label>
                            <select name="subject" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm transition-all">
                                <option value="">Seleziona un oggetto</option>
                                <option value="partnership_regione">Partnership — Regione Calabria</option>
                                <option value="partnership_comune">Partnership — Comune / Pro Loco</option>
                                <option value="partnership_business">Partnership — Azienda privata</option>
                                <option value="info_voli">Informazioni sui voli</option>
                                <option value="info_turismo">Informazioni turistiche</option>
                                <option value="segnalazione">Segnalazione / Feedback</option>
                                <option value="altro">Altro</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-navy mb-2">Messaggio *</label>
                            <textarea name="message" required rows="6"
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm transition-all resize-none"
                                      placeholder="Descrivi la tua richiesta...">{{ old('message') }}</textarea>
                        </div>

                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="privacy" id="privacy" required class="mt-1">
                            <label for="privacy" class="text-sm text-gray-500">
                                Ho letto e accetto la <a href="{{ route('privacy') }}" class="text-sky hover:underline">Privacy Policy</a>. *
                            </label>
                        </div>

                        <button type="submit"
                                class="w-full bg-gold text-navy py-4 rounded-xl font-bold text-base hover:bg-yellow-400 transition-colors">
                            Invia messaggio →
                        </button>
                    </form>
                </div>
            </div>

            {{-- Contatti diretti --}}
            <div class="space-y-5">
                <div class="bg-navy rounded-2xl p-6 text-white">
                    <h3 class="font-bold mb-5">Contatti diretti</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start gap-3">
                            <span class="text-gold text-xl">📧</span>
                            <div>
                                <div class="text-white/60 text-xs mb-0.5">Email generale</div>
                                <a href="mailto:info@aeroportoreggiocalabria.it" class="hover:text-gold transition-colors">
                                    info@aeroportoreggiocalabria.it
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-gold text-xl">🤝</span>
                            <div>
                                <div class="text-white/60 text-xs mb-0.5">Partnership commerciali</div>
                                <a href="mailto:partnership@aeroportoreggiocalabria.it" class="hover:text-gold transition-colors">
                                    partnership@aeroportoreggiocalabria.it
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-gold text-xl">📞</span>
                            <div>
                                <div class="text-white/60 text-xs mb-0.5">Aeroporto (SACAL)</div>
                                <a href="tel:+390965640517" class="hover:text-gold transition-colors">
                                    +39 0965 640 517
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-gold text-xl">🕐</span>
                            <div>
                                <div class="text-white/60 text-xs mb-0.5">Orari risposta</div>
                                <span>Lun–Ven 09:00–18:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
                    <h3 class="font-bold text-navy mb-3">Sei un partner istituzionale?</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Per Regione Calabria e Comuni: consulta le nostre opportunità di partnership dedicate.
                    </p>
                    <a href="{{ route('partners') }}" class="block text-center bg-navy text-white py-3 rounded-xl font-bold text-sm hover:bg-blue transition-colors">
                        Scopri i pacchetti →
                    </a>
                </div>

                <div class="bg-gold/10 rounded-2xl p-6 border border-gold/30">
                    <div class="text-3xl mb-2">⚡</div>
                    <h3 class="font-bold text-navy mb-1">Risposta rapida</h3>
                    <p class="text-gray-600 text-sm">Ci impegniamo a rispondere entro <strong>24 ore lavorative</strong> a ogni richiesta.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
