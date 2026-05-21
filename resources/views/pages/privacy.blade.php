@extends('layouts.app')

@section('title', 'Privacy Policy — aeroportoreggiocalabria.it')
@section('description', 'Informativa sul trattamento dei dati personali ai sensi del Regolamento UE 2016/679 (GDPR) per il portale aeroportoreggiocalabria.it, gestito da KNM Srl.')

@section('content')

<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag-dark">Legale</span>
        <h1 class="text-4xl md:text-5xl font-black text-white mt-2 mb-4">Privacy Policy</h1>
        <p class="text-white/70">Aggiornata al 21 maggio 2026 &middot; Regolamento (UE) 2016/679 &ndash; GDPR</p>
    </div>
</section>

<section class="py-16 px-4 bg-offwhite">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-[0_4px_20px_rgba(0,0,0,0.07)] space-y-10 text-dark leading-relaxed">

            {{-- 1 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">1. Titolare del Trattamento</h2>
                <p>Il Titolare del trattamento dei dati personali raccolti tramite il sito <strong>aeroportoreggiocalabria.it</strong> è:</p>
                <div class="bg-offwhite rounded-xl p-5 mt-4 text-sm space-y-1 border border-black/5">
                    <p><strong>KNM Srl</strong></p>
                    <p>Partita IVA: 13273091002</p>
                    <p>Sede legale: [inserire indirizzo completo]</p>
                    <p>Email: <a href="mailto:privacy@aeroportoreggiocalabria.it" class="text-sky hover:underline">privacy@aeroportoreggiocalabria.it</a></p>
                    <p>PEC: [inserire indirizzo PEC]</p>
                </div>
            </div>

            {{-- 2 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">2. Tipologie di Dati Raccolti</h2>
                <p>Il Sito raccoglie le seguenti categorie di dati personali:</p>
                <ul class="mt-3 space-y-3 list-none">
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Dati di navigazione</strong> &mdash; indirizzi IP, tipo di browser, sistema operativo, pagine visitate, orari di accesso, URL di provenienza. Trattati esclusivamente per finalità statistiche aggregate e di sicurezza informatica.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Dati forniti volontariamente</strong> &mdash; nome, indirizzo e-mail, numero di telefono, inseriti tramite il modulo di contatto o il form di iscrizione alla newsletter.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Dati tecnici di sessione</strong> &mdash; cookie tecnici strettamente necessari al funzionamento del Sito (si rimanda alla Cookie Policy per il dettaglio).</span></li>
                </ul>
            </div>

            {{-- 3 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">3. Finalità e Base Giuridica del Trattamento</h2>
                <div class="overflow-x-auto rounded-xl border border-black/5">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-navy text-white">
                                <th class="text-left p-3 font-semibold">Finalità</th>
                                <th class="text-left p-3 font-semibold">Base giuridica (art. 6 GDPR)</th>
                                <th class="text-left p-3 font-semibold">Conservazione</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-offwhite">
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3">Risposta a richieste di contatto</td>
                                <td class="p-3">Art. 6.1(b) &mdash; misure precontrattuali</td>
                                <td class="p-3">24 mesi</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3">Invio newsletter</td>
                                <td class="p-3">Art. 6.1(a) &mdash; consenso dell&rsquo;interessato</td>
                                <td class="p-3">Fino a revoca</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3">Statistiche di navigazione anonimizzate</td>
                                <td class="p-3">Art. 6.1(f) &mdash; legittimo interesse</td>
                                <td class="p-3">26 mesi</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3">Sicurezza informatica e prevenzione frodi</td>
                                <td class="p-3">Art. 6.1(f) &mdash; legittimo interesse</td>
                                <td class="p-3">12 mesi</td>
                            </tr>
                            <tr class="bg-white hover:bg-offwhite/50">
                                <td class="p-3">Adempimento obblighi di legge</td>
                                <td class="p-3">Art. 6.1(c) &mdash; obbligo legale</td>
                                <td class="p-3">Secondo normativa</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 4 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">4. Modalità del Trattamento</h2>
                <p>I dati personali sono trattati con strumenti elettronici e/o cartacei, nel rispetto dei principi di liceità, correttezza, trasparenza, minimizzazione, esattezza, limitazione della conservazione, integrità e riservatezza (art. 5 GDPR). Il Titolare adotta misure tecniche e organizzative adeguate al rischio ai sensi dell&rsquo;art. 32 GDPR.</p>
            </div>

            {{-- 5 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">5. Destinatari e Comunicazione dei Dati</h2>
                <p>I dati personali non sono venduti né ceduti a terzi per finalità commerciali proprie. Possono essere comunicati esclusivamente a:</p>
                <ul class="mt-3 space-y-2 list-none">
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Responsabili del trattamento (art. 28 GDPR)</strong> &mdash; fornitori di servizi tecnici (hosting, e-mail, analytics) vincolati da apposito accordo scritto.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Autorità pubbliche</strong> &mdash; su richiesta legittima, per adempiere a obblighi di legge o ordini dell&rsquo;Autorità giudiziaria o amministrativa.</span></li>
                </ul>
            </div>

            {{-- 6 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">6. Trasferimenti verso Paesi Terzi</h2>
                <p>Qualora i dati vengano trasferiti verso Paesi al di fuori dello Spazio Economico Europeo, il Titolare garantirà l&rsquo;adozione di adeguate garanzie ai sensi degli artt. 44&ndash;49 GDPR (Clausole Contrattuali Standard approvate dalla Commissione UE o decisioni di adeguatezza applicabili).</p>
            </div>

            {{-- 7 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">7. Diritti dell&rsquo;Interessato</h2>
                <p>Ai sensi degli artt. 15&ndash;22 GDPR, l&rsquo;interessato ha il diritto di:</p>
                <ul class="mt-3 space-y-2 list-none">
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Accesso (art. 15)</strong> &mdash; ottenere conferma del trattamento e copia dei dati.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Rettifica (art. 16)</strong> &mdash; correggere dati inesatti o integrare quelli incompleti.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Cancellazione / &ldquo;diritto all&rsquo;oblio&rdquo; (art. 17)</strong> &mdash; ottenere la cancellazione dei dati nei casi previsti dalla norma.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Limitazione del trattamento (art. 18)</strong> &mdash; bloccare temporaneamente il trattamento.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Portabilità (art. 20)</strong> &mdash; ricevere i dati in formato strutturato e leggibile da dispositivo automatico.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Opposizione (art. 21)</strong> &mdash; opporsi al trattamento fondato su legittimo interesse o per marketing diretto.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Revoca del consenso (art. 7.3)</strong> &mdash; revocare il consenso prestato in qualsiasi momento, senza pregiudicare la liceità del trattamento anteriore.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span><strong>Reclamo (art. 77)</strong> &mdash; proporre reclamo al Garante per la protezione dei dati personali (<a href="https://www.garanteprivacy.it" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">garanteprivacy.it</a>).</span></li>
                </ul>
                <p class="mt-4">Le richieste si inviano a <a href="mailto:privacy@aeroportoreggiocalabria.it" class="text-sky hover:underline font-semibold">privacy@aeroportoreggiocalabria.it</a>. Il Titolare risponde entro 30 giorni, prorogabili di ulteriori 60 giorni in caso di particolare complessità.</p>
            </div>

            {{-- 8 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">8. Cookie</h2>
                <p>Il Sito utilizza cookie e tecnologie similari. Per informazioni dettagliate sulle tipologie, le finalità e le modalità di gestione delle preferenze, si rinvia alla <a href="{{ route('cookies') }}" class="text-sky hover:underline font-semibold">Cookie Policy</a>.</p>
            </div>

            {{-- 9 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">9. Minori</h2>
                <p>Il Sito non è destinato a minori di 16 anni. Il Titolare non raccoglie consapevolmente dati personali di minori. Qualora vengano identificati trattamenti accidentali di dati riferibili a minori, si procederà alla loro immediata cancellazione.</p>
            </div>

            {{-- 10 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">10. Modifiche alla Presente Informativa</h2>
                <p>Il Titolare si riserva il diritto di modificare la presente informativa, dandone idonea pubblicità sul Sito. In caso di modifiche sostanziali, gli utenti iscritti alla newsletter saranno informati via e-mail. La data di ultima revisione è sempre indicata in cima alla pagina.</p>
                <p class="mt-3 text-sm text-gray-400">Ultima revisione: <strong class="text-gray-600">21 maggio 2026</strong> &mdash; versione 1.0</p>
            </div>

        </div>
    </div>
</section>

@endsection
