@extends('layouts.app')

@section('title', 'Cookie Policy — aeroportoreggiocalabria.it')
@section('description', 'Informativa sull\'uso dei cookie del portale aeroportoreggiocalabria.it ai sensi del GDPR, del D.Lgs. 196/2003 e delle Linee Guida del Garante del 10 giugno 2021.')

@section('content')

<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag-dark">Legale</span>
        <h1 class="text-4xl md:text-5xl font-black text-white mt-2 mb-4">Cookie Policy</h1>
        <p class="text-white/70">Aggiornata al 21 maggio 2026 &middot; D.Lgs. 196/2003 &mdash; Linee Guida Garante 10 giugno 2021</p>
    </div>
</section>

<section class="py-16 px-4 bg-offwhite">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-[0_4px_20px_rgba(0,0,0,0.07)] space-y-10 text-dark leading-relaxed">

            {{-- 1 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">1. Cosa Sono i Cookie</h2>
                <p>I cookie sono piccoli file di testo che i siti web visitati dall&rsquo;utente inviano al suo dispositivo (computer, tablet, smartphone), dove vengono memorizzati per essere poi ritrasmessi al medesimo sito alla visita successiva. Tecnologie assimilabili ai cookie (pixel, web beacon, local storage) sono soggette alla medesima disciplina.</p>
                <p class="mt-3">Il presente documento descrive le tipologie di cookie utilizzate dal sito <strong>aeroportoreggiocalabria.it</strong> (&ldquo;Sito&rdquo;), gestito da <strong>KNM Srl</strong> &mdash; P.IVA 13273091002, ed è redatto in conformità alle Linee Guida del Garante per la protezione dei dati personali del 10 giugno 2021 (delibera n. 231) e al Regolamento UE 2016/679 (GDPR).</p>
            </div>

            {{-- 2 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">2. Tipologie di Cookie Utilizzati</h2>

                <h3 class="text-lg font-bold text-navy mt-6 mb-3">2.1 Cookie Tecnici Strettamente Necessari</h3>
                <p>Questi cookie sono essenziali per il corretto funzionamento del Sito e non richiedono il consenso dell&rsquo;utente (art. 122, co. 1, D.Lgs. 196/2003). La loro disabilitazione renderebbe il Sito non fruibile o significativamente degradato.</p>
                <div class="overflow-x-auto rounded-xl border border-black/5 mt-4">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-navy/90 text-white">
                                <th class="text-left p-3 font-semibold">Nome</th>
                                <th class="text-left p-3 font-semibold">Fornitore</th>
                                <th class="text-left p-3 font-semibold">Finalità</th>
                                <th class="text-left p-3 font-semibold">Durata</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-offwhite">
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3 font-mono text-xs">XSRF-TOKEN</td>
                                <td class="p-3">aeroportoreggiocalabria.it</td>
                                <td class="p-3">Protezione CSRF (Cross-Site Request Forgery)</td>
                                <td class="p-3">Sessione</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3 font-mono text-xs">aeroportorc_session</td>
                                <td class="p-3">aeroportoreggiocalabria.it</td>
                                <td class="p-3">Gestione sessione utente e preferenze</td>
                                <td class="p-3">2 ore</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3 font-mono text-xs">locale</td>
                                <td class="p-3">aeroportoreggiocalabria.it</td>
                                <td class="p-3">Memorizzazione lingua selezionata dall&rsquo;utente</td>
                                <td class="p-3">1 anno</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3 font-mono text-xs">cookie_consent</td>
                                <td class="p-3">aeroportoreggiocalabria.it</td>
                                <td class="p-3">Memorizzazione delle preferenze cookie espresse</td>
                                <td class="p-3">12 mesi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="text-lg font-bold text-navy mt-8 mb-3">2.2 Cookie Analitici (con consenso)</h3>
                <p>Questi cookie raccolgono informazioni anonimizzate sull&rsquo;utilizzo del Sito (pagine visitate, tempo di permanenza, provenienza del traffico) al fine di migliorarne le prestazioni. Sono attivati solo previo consenso esplicito dell&rsquo;utente.</p>
                <div class="overflow-x-auto rounded-xl border border-black/5 mt-4">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-navy/90 text-white">
                                <th class="text-left p-3 font-semibold">Nome</th>
                                <th class="text-left p-3 font-semibold">Fornitore</th>
                                <th class="text-left p-3 font-semibold">Finalità</th>
                                <th class="text-left p-3 font-semibold">Durata</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-offwhite">
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3 font-mono text-xs">_pk_id.*</td>
                                <td class="p-3">Matomo (self-hosted)</td>
                                <td class="p-3">Identificazione sessioni anonime per statistiche</td>
                                <td class="p-3">13 mesi</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3 font-mono text-xs">_pk_ses.*</td>
                                <td class="p-3">Matomo (self-hosted)</td>
                                <td class="p-3">Sessione corrente di navigazione anonimizzata</td>
                                <td class="p-3">30 minuti</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="mt-3 text-sm text-gray-500">Utilizziamo Matomo in modalità self-hosted: i dati non lasciano i nostri server e gli indirizzi IP sono anonimizzati prima della memorizzazione.</p>

                <h3 class="text-lg font-bold text-navy mt-8 mb-3">2.3 Cookie di Profilazione e Marketing (con consenso)</h3>
                <p>Al momento il Sito <strong>non utilizza</strong> cookie di profilazione propri né cookie di terze parti per finalità di marketing comportamentale. Qualora in futuro venissero introdotti, la presente Cookie Policy sarà aggiornata e sarà richiesto un nuovo consenso.</p>
            </div>

            {{-- 3 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">3. Come Gestire i Cookie</h2>

                <h3 class="text-lg font-bold text-navy mb-3">3.1 Banner di Consenso</h3>
                <p>Al primo accesso al Sito, viene visualizzato un banner che consente di accettare, rifiutare o personalizzare le preferenze relative ai cookie non tecnici. Il consenso prestato può essere revocato in qualsiasi momento attraverso il link &ldquo;<strong>Gestisci preferenze cookie</strong>&rdquo; presente nel footer.</p>

                <h3 class="text-lg font-bold text-navy mt-6 mb-3">3.2 Impostazioni del Browser</h3>
                <p>In alternativa, l&rsquo;utente può gestire, bloccare o eliminare i cookie direttamente dalle impostazioni del proprio browser. Si avverte che la disabilitazione dei cookie tecnici potrebbe compromettere il corretto funzionamento del Sito.</p>
                <ul class="mt-3 space-y-1.5 text-sm list-none">
                    <li>&rarr; <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">Google Chrome</a></li>
                    <li>&rarr; <a href="https://support.mozilla.org/it/kb/Gestione%20dei%20cookie" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">Mozilla Firefox</a></li>
                    <li>&rarr; <a href="https://support.apple.com/it-it/guide/safari/sfri11471/mac" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">Apple Safari</a></li>
                    <li>&rarr; <a href="https://support.microsoft.com/it-it/microsoft-edge/eliminare-i-cookie-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">Microsoft Edge</a></li>
                </ul>
            </div>

            {{-- 4 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">4. Titolare del Trattamento</h2>
                <p>Per le attività di trattamento connesse ai cookie, il Titolare del trattamento è <strong>KNM Srl</strong> &mdash; P.IVA 13273091002. Per esercitare i diritti previsti dagli artt. 15&ndash;22 GDPR, si rinvia all&rsquo;apposita sezione della <a href="{{ route('privacy') }}" class="text-sky hover:underline font-semibold">Privacy Policy</a>.</p>
            </div>

            {{-- 5 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">5. Aggiornamenti</h2>
                <p>La presente Cookie Policy può essere aggiornata in qualsiasi momento in seguito a modifiche normative, tecniche o editoriali. La data di ultima revisione è sempre indicata in cima alla pagina. La continuazione della navigazione dopo la pubblicazione di eventuali modifiche costituisce accettazione delle stesse per i soli cookie tecnici; per quelli facoltativi sarà richiesto un nuovo consenso.</p>
                <p class="mt-3 text-sm text-gray-400">Ultima revisione: <strong class="text-gray-600">21 maggio 2026</strong> &mdash; versione 1.0</p>
            </div>

        </div>
    </div>
</section>

@endsection
