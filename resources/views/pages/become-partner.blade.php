@extends('layouts.app')

@section('title', 'Diventa Partner — Aeroporto Reggio Calabria')
@section('description', 'Proponi una partnership commerciale o istituzionale con il portale Aeroporto Reggio Calabria. Collaboriamo con Regione Calabria, Comuni, operatori turistici e imprese del territorio.')

@section('content')

{{-- HERO --}}
<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full" viewBox="0 0 1200 400" preserveAspectRatio="xMidYMid slice">
            <ellipse cx="950" cy="100" rx="400" ry="250" fill="#1A5276" opacity="0.3"/>
        </svg>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-2 bg-gold/20 border border-gold text-gold px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
            🤝 &nbsp;PARTNERSHIP
        </span>
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-4">
            Diventa Partner
        </h1>
        <p class="text-white/70 text-lg max-w-2xl leading-relaxed">
            Collaboriamo con istituzioni, enti pubblici, operatori turistici e imprese per promuovere la Calabria come destinazione.
            Il portale raggiunge migliaia di viaggiatori ogni mese.
        </p>
    </div>
</section>

{{-- PERCHÉ DIVENTARE PARTNER --}}
<section class="py-16 px-4 bg-offwhite">
    <div class="max-w-7xl mx-auto">
        <span class="section-tag">PERCHÉ SCEGLIERCI</span>
        <h2 class="text-3xl font-black text-navy mb-10">Visibilità istituzionale sul territorio</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <div class="text-3xl font-black text-gold mb-1">622K+</div>
                <div class="text-sm text-gray-500 font-medium mb-3">passeggeri/anno allo scalo REG</div>
                <p class="text-sm text-gray-600 leading-relaxed">Ogni viaggiatore che transita da Reggio Calabria è un potenziale utente del portale.</p>
            </div>
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <div class="text-3xl font-black text-gold mb-1">4 lingue</div>
                <div class="text-sm text-gray-500 font-medium mb-3">IT · EN · DE · FR</div>
                <p class="text-sm text-gray-600 leading-relaxed">Raggiungi turisti internazionali che pianificano il viaggio in Calabria già dall'estero.</p>
            </div>
            <div class="bg-white rounded-2xl p-7 border border-black/5 shadow-sm">
                <div class="text-3xl font-black text-gold mb-1">SEO</div>
                <div class="text-sm text-gray-500 font-medium mb-3">Posizionamento organico</div>
                <p class="text-sm text-gray-600 leading-relaxed">Portale ottimizzato per le ricerche turistiche sulla Calabria e sullo scalo di Reggio.</p>
            </div>
        </div>

        {{-- TIPOLOGIE DI PARTNER --}}
        <h3 class="text-2xl font-black text-navy mb-6">Tipologie di partnership</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-16">
            @foreach([
                ['🏛️', 'Istituzionale', 'Regione Calabria, Comuni, Città Metropolitana, SACAL, Camera di Commercio, enti di promozione turistica.'],
                ['🏨', 'Turismo & Ospitalità', 'Hotel, B&B, resort, strutture ricettive, agenzie di viaggio, tour operator locali.'],
                ['🚗', 'Mobilità & Servizi', 'Autonoleggi, taxi, transfer, parcheggi, compagnie di autobus e treni regionali.'],
                ['🍋', 'Prodotti & Cultura', 'Produttori DOP/IGP calabresi, artigianato, musei, parchi naturali, eventi culturali.'],
            ] as [$icon, $title, $desc])
            <div class="flex gap-4 bg-white rounded-2xl p-6 border border-black/5 shadow-sm">
                <span class="text-3xl shrink-0">{{ $icon }}</span>
                <div>
                    <div class="font-bold text-navy text-base mb-1">{{ $title }}</div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FORM RICHIESTA PARTNERSHIP --}}
<section class="py-16 px-4 bg-white">
    <div class="max-w-3xl mx-auto">
        <span class="section-tag">MODULO DI CONTATTO</span>
        <h2 class="text-3xl font-black text-navy mb-2">Invia la tua proposta</h2>
        <p class="text-gray-500 mb-8">Compila il form e ti contatteremo entro 48 ore lavorative per discutere i dettagli della collaborazione.</p>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-5 mb-8 flex items-start gap-3">
                <span class="text-xl">✅</span>
                <div>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('become-partner.submit') }}" method="POST"
              class="bg-offwhite rounded-2xl p-8 space-y-6 border border-black/5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Nome organizzazione / ente *</label>
                    <input type="text" name="org_name" required value="{{ old('org_name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm"
                           placeholder="Es. Comune di Reggio Calabria">
                    @error('org_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Referente *</label>
                    <input type="text" name="contact_name" required value="{{ old('contact_name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm"
                           placeholder="Nome e cognome">
                    @error('contact_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Email *</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm"
                           placeholder="tua@email.it">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Telefono</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm"
                           placeholder="+39 ...">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Tipo di ente *</label>
                    <select name="org_type" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm bg-white">
                        <option value="">Seleziona...</option>
                        <option value="Ente pubblico / PA" {{ old('org_type') === 'Ente pubblico / PA' ? 'selected' : '' }}>Ente pubblico / PA</option>
                        <option value="Struttura turistica" {{ old('org_type') === 'Struttura turistica' ? 'selected' : '' }}>Struttura turistica</option>
                        <option value="Agenzia viaggio / Tour operator" {{ old('org_type') === 'Agenzia viaggio / Tour operator' ? 'selected' : '' }}>Agenzia viaggio / Tour operator</option>
                        <option value="Mobilità e trasporti" {{ old('org_type') === 'Mobilità e trasporti' ? 'selected' : '' }}>Mobilità e trasporti</option>
                        <option value="Prodotti e cultura locale" {{ old('org_type') === 'Prodotti e cultura locale' ? 'selected' : '' }}>Prodotti e cultura locale</option>
                        <option value="Media / Editoria" {{ old('org_type') === 'Media / Editoria' ? 'selected' : '' }}>Media / Editoria</option>
                        <option value="Altro" {{ old('org_type') === 'Altro' ? 'selected' : '' }}>Altro</option>
                    </select>
                    @error('org_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Tipo di interesse *</label>
                    <select name="interest" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm bg-white">
                        <option value="">Seleziona...</option>
                        <option value="Visibilità / Banner" {{ old('interest') === 'Visibilità / Banner' ? 'selected' : '' }}>Visibilità / Banner pubblicitario</option>
                        <option value="Articolo sponsorizzato" {{ old('interest') === 'Articolo sponsorizzato' ? 'selected' : '' }}>Articolo sponsorizzato</option>
                        <option value="Partnership istituzionale" {{ old('interest') === 'Partnership istituzionale' ? 'selected' : '' }}>Partnership istituzionale</option>
                        <option value="Co-marketing" {{ old('interest') === 'Co-marketing' ? 'selected' : '' }}>Co-marketing / Collaborazione editoriale</option>
                        <option value="Sponsorizzazione sezione" {{ old('interest') === 'Sponsorizzazione sezione' ? 'selected' : '' }}>Sponsorizzazione sezione (es. Turismo, Voli)</option>
                        <option value="Altro" {{ old('interest') === 'Altro' ? 'selected' : '' }}>Altro / Da definire</option>
                    </select>
                    @error('interest')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-navy mb-2">Descrivi la tua proposta</label>
                <textarea name="message" rows="5"
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-sky focus:border-transparent text-sm resize-none"
                          placeholder="Descrivi brevemente l'ente, gli obiettivi della partnership e come vorresti collaborare...">{{ old('message') }}</textarea>
            </div>

            <div class="flex items-start gap-3">
                <input type="checkbox" name="privacy" id="privacy_partner" required
                       class="mt-1 w-4 h-4 accent-sky">
                <label for="privacy_partner" class="text-sm text-gray-600 leading-relaxed">
                    Ho letto e accetto la <a href="{{ route('privacy') }}" class="text-sky underline hover:text-navy">Privacy Policy</a>
                    e il <a href="{{ route('cookies') }}" class="text-sky underline hover:text-navy">trattamento dei dati</a>
                    ai sensi del GDPR (UE) 2016/679. *
                </label>
            </div>
            @error('privacy')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror

            <button type="submit"
                    class="w-full bg-navy text-white py-4 rounded-xl font-bold text-base hover:bg-blue transition-colors">
                🤝 Invia proposta di partnership
            </button>
        </form>
    </div>
</section>

@endsection
