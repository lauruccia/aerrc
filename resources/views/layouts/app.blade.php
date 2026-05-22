<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="stickyNav()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Variabili SEO calcolate una volta sola --}}
    @php
        $locale      = app()->getLocale();
        $localeMap   = ['it' => 'it_IT', 'en' => 'en_GB', 'de' => 'de_DE', 'fr' => 'fr_FR'];
        $ogLocale    = $localeMap[$locale] ?? 'it_IT';
        $pageTitle   = $__env->yieldContent('title', __('nav.site_title'));
        $pageDesc    = $__env->yieldContent('description', __('seo.default_description'));
        $ogTitle     = $__env->yieldContent('og_title', $pageTitle);
        $ogDesc      = $__env->yieldContent('og_description', $pageDesc);
        $ogImage     = $__env->yieldContent('og_image', asset('img/og-default.jpg'));
        $currentUrl  = url()->current();
        $pathInfo    = request()->getPathInfo();
        $baseUrl     = preg_replace('#/(en|de|fr)(/|$)#', '/', $currentUrl);
    @endphp

    {{-- SEO Core --}}
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="keywords" content="@yield('keywords', 'aeroporto reggio calabria, voli calabria, turismo calabria, tito minniti, REG, voli reggio calabria')">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="aeroportoreggiocalabria.it">
    <link rel="canonical" href="{{ $currentUrl }}">

    {{-- Geo / Local SEO --}}
    <meta name="geo.region" content="IT-RC">
    <meta name="geo.placename" content="Reggio Calabria">
    <meta name="geo.position" content="38.0712;15.6516">
    <meta name="ICBM" content="38.0712, 15.6516">

    {{-- Hreflang per multilingua --}}
    <link rel="alternate" hreflang="it" href="{{ $baseUrl }}">
    <link rel="alternate" hreflang="en" href="{{ url('/en' . $pathInfo) }}">
    <link rel="alternate" hreflang="de" href="{{ url('/de' . $pathInfo) }}">
    <link rel="alternate" hreflang="fr" href="{{ url('/fr' . $pathInfo) }}">
    <link rel="alternate" hreflang="x-default" href="{{ $baseUrl }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Aeroporto Reggio Calabria">
    <meta property="og:locale" content="{{ $ogLocale }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Aeroporto Reggio Calabria Tito Minniti">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- JSON-LD Structured Data --}}
    @stack('structured_data')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Airport",
          "@id": "https://www.aeroportoreggiocalabria.it/#airport",
          "name": "Aeroporto Internazionale di Reggio Calabria Tito Minniti",
          "alternateName": ["REG", "Aeroporto Tito Minniti"],
          "iataCode": "REG",
          "icaoCode": "LICR",
          "url": "https://www.aeroportoreggiocalabria.it",
          "telephone": "+390965640517",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Via Ravagnese, 1",
            "addressLocality": "Reggio Calabria",
            "postalCode": "89131",
            "addressRegion": "Calabria",
            "addressCountry": "IT"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": 38.0712,
            "longitude": 15.6516
          },
          "openingHours": "Mo-Su 05:00-23:00",
          "hasMap": "https://maps.google.com/?q=Aeroporto+Reggio+Calabria",
          "image": "https://www.aeroportoreggiocalabria.it/img/og-default.jpg",
          "sameAs": [
            "https://it.wikipedia.org/wiki/Aeroporto_di_Reggio_Calabria",
            "https://www.sacal.it"
          ]
        },
        {
          "@type": "WebSite",
          "@id": "https://www.aeroportoreggiocalabria.it/#website",
          "url": "https://www.aeroportoreggiocalabria.it",
          "name": "Aeroporto Reggio Calabria",
          "description": "Il portale unico per viaggiatori e turisti dell'Aeroporto Tito Minniti di Reggio Calabria",
          "publisher": {
            "@type": "Organization",
            "@id": "https://www.aeroportoreggiocalabria.it/#organization",
            "name": "KNM Srl",
            "url": "https://www.aeroportoreggiocalabria.it",
            "vatID": "IT13273091002"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "https://www.aeroportoreggiocalabria.it/voli?q={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@type": "BreadcrumbList",
          "@id": "https://www.aeroportoreggiocalabria.it/#breadcrumb",
          "itemListElement": [
            {
              "@type": "ListItem",
              "position": 1,
              "name": "Home",
              "item": "https://www.aeroportoreggiocalabria.it/"
            }
          ]
        }
      ]
    }
    </script>

    {{-- Favicon & Brand Icons --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo-mark.svg') }}">
    <meta name="theme-color" content="#0D2347">
    <meta name="msapplication-TileColor" content="#0D2347">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire styles --}}
    @livewireStyles

    {{-- Page-specific head --}}
    @stack('head')

    {{-- ══════════════════════════════════════════════════════════════
         GOOGLE ANALYTICS 4 + CONSENT MODE v2  (GDPR / Garante IT)
         ══════════════════════════════════════════════════════════════
         ⚠️  ISTRUZIONI PER L'ATTIVAZIONE:
             1. Vai su https://analytics.google.com
             2. Crea una nuova Property (tipo "Web")
             3. In Admin → Data Streams → Web ottieni il Measurement ID
                nel formato  G-XXXXXXXXXX
             4. Sostituisci ENTRAMBE le occorrenze di G-XXXXXXXXXX
                qui sotto con il tuo ID reale
             5. Salva il file — GA4 inizierà a raccogliere dati
         ══════════════════════════════════════════════════════════════ --}}
    @php
        // Legge il consenso già salvato (se l'utente ha già visitato il sito)
        $arcConsent         = $_COOKIE['arc_cookie_consent'] ?? null;
        $analyticsGranted   = ($arcConsent === 'all') ? 'granted' : 'denied';
    @endphp

    {{-- Google Consent Mode v2 — DEVE stare prima del tag gtag.js --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }

        // Default: tutto negato. Viene aggiornato dal banner o se già consento.
        gtag('consent', 'default', {
            'analytics_storage':  '{{ $analyticsGranted }}',
            'ad_storage':         'denied',
            'ad_user_data':       'denied',
            'ad_personalization': 'denied',
            'wait_for_update':    500
        });
        gtag('js', new Date());
    </script>

    {{-- Tag Google Analytics — sostituire G-XXXXXXXXXX con il tuo Measurement ID --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        gtag('config', 'G-XXXXXXXXXX', {
            'anonymize_ip': true     // anonimizza IP (best practice GDPR)
        });
    </script>
    {{-- ══════════════════════════════════════════════════════════════ --}}
</head>
<body class="font-sans bg-offwhite text-navy-dark antialiased">

    {{-- ── NAVBAR ── --}}
    <nav
        class="fixed top-0 inset-x-0 z-50 transition-shadow duration-300"
        :class="scrolled ? 'bg-navy shadow-[0_2px_20px_rgba(0,0,0,0.4)]' : 'bg-navy/95 backdrop-blur-sm'"
        x-data="mobileMenu()"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <img src="{{ asset('img/logo-mark.svg') }}" alt="ARC Aeroporto Reggio Calabria" class="w-12 h-12 rounded-lg">
                <div>
                    <div class="text-white font-bold text-sm leading-tight">Aeroporto Reggio Calabria</div>
                    <div class="text-gold text-[0.68rem] font-normal tracking-wider">VOLI · TURISMO · CALABRIA</div>
                </div>
            </a>

            {{-- Desktop links --}}
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('flights.index') }}" class="nav-link">{{ __('nav.flights') }}</a>
                <a href="{{ route('destinations.index') }}" class="nav-link">{{ __('nav.destinations') }}</a>
                <a href="{{ route('tourism') }}" class="nav-link">{{ __('nav.tourism') }}</a>
                <a href="{{ route('services') }}" class="nav-link">{{ __('nav.services') }}</a>
                <a href="{{ route('airport-info') }}" class="nav-link">{{ __('nav.airport') }}</a>

                {{-- Language switcher --}}
                <div class="relative" x-data="langSwitcher()" @click.outside="close()">
                    <button @click="toggle()" class="nav-link flex items-center gap-1 text-xs uppercase tracking-wider">
                        🌐 {{ strtoupper(app()->getLocale()) }}
                        <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-32 bg-navy border border-white/20 rounded-lg shadow-xl overflow-hidden z-50">
                        @foreach(['it' => '🇮🇹 Italiano', 'en' => '🇬🇧 English', 'de' => '🇩🇪 Deutsch', 'fr' => '🇫🇷 Français'] as $locale => $label)
                            <a href="{{ route('lang.switch', $locale) }}"
                               class="block px-4 py-2.5 text-sm text-white/80 hover:bg-white/10 hover:text-gold transition-colors {{ app()->getLocale() === $locale ? 'text-gold font-semibold' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('partners') }}" class="bg-gold text-navy px-4 py-2 rounded-lg font-bold text-sm hover:bg-yellow-400 transition-colors">
                    {{ __('nav.partners') }}
                </a>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="toggle()" class="lg:hidden text-white p-2">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition class="lg:hidden bg-navy border-t border-white/10 px-4 py-4 space-y-3">
            <a href="{{ route('flights.index') }}" class="block nav-link py-2">{{ __('nav.flights') }}</a>
            <a href="{{ route('destinations.index') }}" class="block nav-link py-2">{{ __('nav.destinations') }}</a>
            <a href="{{ route('tourism') }}" class="block nav-link py-2">{{ __('nav.tourism') }}</a>
            <a href="{{ route('services') }}" class="block nav-link py-2">{{ __('nav.services') }}</a>
            <a href="{{ route('airport-info') }}" class="block nav-link py-2">{{ __('nav.airport') }}</a>
            <div class="pt-2 border-t border-white/10 flex gap-3">
                @foreach(['it' => '🇮🇹', 'en' => '🇬🇧', 'de' => '🇩🇪', 'fr' => '🇫🇷'] as $locale => $flag)
                    <a href="{{ route('lang.switch', $locale) }}"
                       class="text-lg {{ app()->getLocale() === $locale ? 'opacity-100' : 'opacity-50 hover:opacity-100' }} transition-opacity">
                        {{ $flag }}
                    </a>
                @endforeach
            </div>
            <a href="{{ route('partners') }}" class="block w-full text-center bg-gold text-navy py-2.5 rounded-lg font-bold text-sm">
                {{ __('nav.partners') }}
            </a>
        </div>
    </nav>

    {{-- ── PAGE CONTENT ── --}}
    <main>
        @yield('content')
    </main>

    {{-- ── NEWSLETTER ── --}}
    @unless(isset($hideNewsletter) && $hideNewsletter)
    <section class="bg-gradient-to-r from-gold to-amber py-16 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-black text-navy mb-2">{{ __('newsletter.title') }}</h2>
            <p class="text-navy/75 mb-8">{{ __('newsletter.subtitle') }}</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST"
                  class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                @csrf
                <input type="email" name="email" placeholder="{{ __('newsletter.placeholder') }}"
                       class="flex-1 px-5 py-3.5 rounded-lg border-0 focus:ring-2 focus:ring-navy text-dark text-base"
                       required>
                <button type="submit"
                        class="bg-navy text-white px-6 py-3.5 rounded-lg font-bold hover:bg-blue transition-colors whitespace-nowrap">
                    {{ __('newsletter.cta') }}
                </button>
            </form>
        </div>
    </section>
    @endunless

    {{-- ── FOOTER ── --}}
    <footer class="bg-navy-dark text-white/60 pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                <div class="md:col-span-2">
                    <div class="mb-5">
                        <img src="{{ asset('img/logo-full.svg') }}" alt="Aeroporto Reggio Calabria" class="h-16 w-auto">
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs">
                        {{ __('footer.description') }}
                    </p>
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-gold hover:text-navy transition-all text-sm">f</a>
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-gold hover:text-navy transition-all text-sm">in</a>
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-gold hover:text-navy transition-all text-sm">ig</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-sm font-bold mb-4">{{ __('footer.quick_links') }}</h4>
                    <nav class="space-y-2.5 text-sm">
                        <a href="{{ route('flights.index') }}" class="block hover:text-gold transition-colors">{{ __('nav.flights') }}</a>
                        <a href="{{ route('destinations.index') }}" class="block hover:text-gold transition-colors">{{ __('nav.destinations') }}</a>
                        <a href="{{ route('tourism') }}" class="block hover:text-gold transition-colors">{{ __('nav.tourism') }}</a>
                        <a href="{{ route('services') }}" class="block hover:text-gold transition-colors">{{ __('nav.services') }}</a>
                        <a href="{{ route('airport-info') }}" class="block hover:text-gold transition-colors">{{ __('nav.airport') }}</a>
                    </nav>
                </div>
                <div>
                    <h4 class="text-white text-sm font-bold mb-4">{{ __('footer.info') }}</h4>
                    <nav class="space-y-2.5 text-sm">
                        <a href="{{ route('partners') }}" class="block hover:text-gold transition-colors">{{ __('nav.partners') }}</a>
                        <a href="{{ route('become-partner') }}" class="block hover:text-gold transition-colors">Diventa Partner</a>
                        <a href="{{ route('media-kit') }}" class="block hover:text-gold transition-colors">Media Kit</a>
                        <a href="{{ route('contact') }}" class="block hover:text-gold transition-colors">{{ __('nav.contact') }}</a>
                        <a href="{{ route('privacy') }}" class="block hover:text-gold transition-colors">Privacy Policy</a>
                        <a href="{{ route('cookies') }}" class="block hover:text-gold transition-colors">Cookie Policy</a>
                        <a href="{{ route('sitemap') }}" class="block hover:text-gold transition-colors">Sitemap</a>
                    </nav>
                </div>
            </div>
            <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs">
                <span>© {{ date('Y') }} <strong class="text-white/80">KNM Srl</strong> · P.IVA 13273091002 · Tutti i diritti riservati</span>
                <span class="flex gap-4">
                    <a href="{{ route('privacy') }}" class="hover:text-gold transition-colors">Privacy Policy</a>
                    <a href="{{ route('cookies') }}" class="hover:text-gold transition-colors">Cookie Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-gold transition-colors">Termini e Condizioni</a>
                </span>
            </div>
        </div>
    </footer>

    {{-- Livewire --}}
    @livewireScripts

    @stack('scripts')

    {{-- ══════════════════════════════════════════════════════════════
         COOKIE CONSENT BANNER
         Conforme: GDPR UE 2016/679 · D.Lgs. 196/2003 · Linee guida
         Garante Privacy italiano (provvedimento 8 gen 2022)
         ══════════════════════════════════════════════════════════════ --}}

    {{-- Banner principale --}}
    <div id="cookie-banner"
         style="display:none"
         role="dialog"
         aria-modal="true"
         aria-label="Consenso cookie"
         class="fixed bottom-0 inset-x-0 z-[9999] bg-navy-dark border-t-2 border-gold/40 shadow-[0_-4px_40px_rgba(0,0,0,0.5)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">

                {{-- Testo informativo --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-white leading-relaxed">
                        <strong class="text-gold">🍪 Informativa cookie</strong> —
                        Utilizziamo <strong class="text-white/90">cookie tecnici</strong> (necessari al funzionamento del sito)
                        e, previo consenso, <strong class="text-white/90">cookie analitici</strong> per misurare le visite
                        in forma anonima (Google Analytics con IP anonimizzato).
                        Non utilizziamo cookie di profilazione o pubblicitari.
                        <a href="{{ route('cookies') }}" class="text-gold underline hover:text-yellow-300 transition-colors ml-1">Cookie Policy</a>
                        <span class="text-white/40 mx-1">·</span>
                        <a href="{{ route('privacy') }}" class="text-gold underline hover:text-yellow-300 transition-colors">Privacy Policy</a>
                    </p>
                </div>

                {{-- Bottoni azione — stessa prominenza visiva (Garante IT) --}}
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <button onclick="arcCookieConsent('necessary')"
                            class="px-4 py-2.5 text-sm font-semibold text-white/80 border border-white/25 rounded-lg hover:bg-white/10 hover:text-white transition-colors">
                        Rifiuta
                    </button>
                    <button onclick="arcCookieConsent('all')"
                            class="px-5 py-2.5 text-sm font-bold bg-gold text-navy rounded-lg hover:bg-yellow-400 transition-colors">
                        Accetta tutti
                    </button>
                </div>
            </div>

            {{-- Barra dettaglio categorie (visibile solo dopo "Gestisci") --}}
            <div id="cookie-detail" class="hidden mt-4 pt-4 border-t border-white/10">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    {{-- Tecnici --}}
                    <div class="bg-white/5 rounded-xl p-4 flex gap-3 items-start">
                        <div class="mt-0.5 w-4 h-4 rounded bg-green-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <div class="text-white text-xs font-bold mb-0.5">Cookie tecnici <span class="text-green-400 font-normal ml-1">(sempre attivi)</span></div>
                            <div class="text-white/55 text-xs leading-relaxed">Sessione, sicurezza CSRF, preferenze lingua. Non richiedono consenso.</div>
                        </div>
                    </div>
                    {{-- Analitici --}}
                    <div class="bg-white/5 rounded-xl p-4 flex gap-3 items-start">
                        <div class="mt-0.5 flex-shrink-0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="analytics-toggle" class="sr-only peer" onchange="arcToggleAnalytics(this.checked)">
                                <div class="w-9 h-5 bg-white/20 peer-checked:bg-gold rounded-full transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                            </label>
                        </div>
                        <div>
                            <div class="text-white text-xs font-bold mb-0.5">Cookie analitici <span class="text-white/50 font-normal ml-1">(Google Analytics 4)</span></div>
                            <div class="text-white/55 text-xs leading-relaxed">Conteggio visite anonime, pagine popolari. IP anonimizzato. Nessun dato personale.</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button onclick="arcSaveCustom()"
                            class="px-5 py-2 text-sm font-bold bg-gold text-navy rounded-lg hover:bg-yellow-400 transition-colors">
                        Salva preferenze
                    </button>
                </div>
            </div>

            {{-- Link "Gestisci preferenze" --}}
            <div class="mt-2">
                <button onclick="arcToggleDetail()"
                        id="cookie-manage-btn"
                        class="text-xs text-white/40 hover:text-white/70 underline transition-colors">
                    Gestisci preferenze
                </button>
            </div>
        </div>
    </div>

    {{-- Bottone per riaprire le preferenze (sempre visibile in fondo alla pagina) --}}
    <button id="cookie-reopen-btn"
            onclick="arcReopenBanner()"
            style="display:none"
            title="Gestisci preferenze cookie"
            aria-label="Gestisci preferenze cookie"
            class="fixed bottom-4 left-4 z-[9998] w-9 h-9 bg-navy-dark border border-white/20 rounded-full shadow-lg flex items-center justify-center text-base hover:border-gold transition-colors">
        🍪
    </button>

    <script>
    (function () {
        var KEY   = 'arc_cookie_consent';
        var DAYS  = 365;
        var _analyticsChoice = false; // stato toggle nel pannello detail

        /* ── Utility cookie ─────────────────────────────── */
        function setCookie(name, val, days) {
            var exp = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = name + '=' + val + ';expires=' + exp + ';path=/;SameSite=Lax';
        }
        function getCookie(name) {
            var m = document.cookie.match('(^| )' + name + '=([^;]+)');
            return m ? m[2] : null;
        }

        /* ── Attiva / disattiva Google Analytics ────────── */
        function enableAnalytics() {
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    analytics_storage: 'granted',
                    ad_storage: 'denied'
                });
            }
        }
        function disableAnalytics() {
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    analytics_storage: 'denied',
                    ad_storage: 'denied'
                });
            }
        }

        /* ── Nasconde banner + mostra pulsante riapertura ── */
        function closeBanner() {
            var b = document.getElementById('cookie-banner');
            var r = document.getElementById('cookie-reopen-btn');
            if (b) b.style.display = 'none';
            if (r) r.style.display = 'flex';
        }

        /* ── API pubblica ────────────────────────────────── */
        window.arcCookieConsent = function (type) {
            setCookie(KEY, type, DAYS);
            closeBanner();
            if (type === 'all') {
                enableAnalytics();
            } else {
                disableAnalytics();
            }
        };

        window.arcToggleDetail = function () {
            var d   = document.getElementById('cookie-detail');
            var btn = document.getElementById('cookie-manage-btn');
            var tog = document.getElementById('analytics-toggle');
            var open = d.classList.toggle('hidden');
            btn.textContent = open ? 'Gestisci preferenze' : 'Nascondi preferenze';
            // Pre-seleziona toggle in base al consenso attuale
            if (tog) tog.checked = (getCookie(KEY) === 'all');
        };

        window.arcToggleAnalytics = function (checked) {
            _analyticsChoice = checked;
        };

        window.arcSaveCustom = function () {
            var type = _analyticsChoice ? 'all' : 'necessary';
            window.arcCookieConsent(type);
        };

        window.arcReopenBanner = function () {
            var b = document.getElementById('cookie-banner');
            var r = document.getElementById('cookie-reopen-btn');
            if (b) b.style.display = 'block';
            if (r) r.style.display = 'none';
        };

        /* ── Init al caricamento pagina ─────────────────── */
        var saved = getCookie(KEY);
        if (!saved) {
            // Prima visita: mostra banner
            document.getElementById('cookie-banner').style.display = 'block';
        } else {
            // Visita successiva: mostra solo il pulsantino 🍪
            document.getElementById('cookie-reopen-btn').style.display = 'flex';
            // Se già aveva accettato tutto, aggiorna GA4 anche ora
            if (saved === 'all') {
                // Piccolo delay per attendere il caricamento del tag gtag.js
                setTimeout(enableAnalytics, 600);
            }
        }
    })();
    </script>
    {{-- ══════════════════════════════════════════════════════════════ --}}
</body>
</html>
