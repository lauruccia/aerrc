@extends('layouts.app')

@section('title', 'Termini e Condizioni di Utilizzo — aeroportoreggiocalabria.it')
@section('description', 'Termini e condizioni di utilizzo del portale aeroportoreggiocalabria.it, gestito da KNM Srl P.IVA 13273091002. Informazioni su responsabilità, proprietà intellettuale e normativa applicabile.')

@section('content')

<section class="relative bg-navy pt-28 pb-16 px-4 overflow-hidden">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag-dark">Legale</span>
        <h1 class="text-4xl md:text-5xl font-black text-white mt-2 mb-4">Termini e Condizioni di Utilizzo</h1>
        <p class="text-white/70">Aggiornati al 21 maggio 2026</p>
    </div>
</section>

<section class="py-16 px-4 bg-offwhite">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-[0_4px_20px_rgba(0,0,0,0.07)] space-y-10 text-dark leading-relaxed">

            {{-- Intro --}}
            <div class="bg-gold/10 border border-gold/30 rounded-xl p-5 text-sm">
                <p>Leggere attentamente i presenti Termini e Condizioni (&ldquo;T&amp;C&rdquo;) prima di utilizzare il sito <strong>aeroportoreggiocalabria.it</strong>. L&rsquo;accesso e l&rsquo;utilizzo del Sito implicano l&rsquo;accettazione integrale dei presenti T&amp;C. Qualora non si accettino, si invita a non utilizzare il Sito.</p>
            </div>

            {{-- 1 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">1. Gestore del Portale</h2>
                <p>Il portale <strong>aeroportoreggiocalabria.it</strong> (&ldquo;Sito&rdquo; o &ldquo;Portale&rdquo;) è un servizio editoriale indipendente gestito da:</p>
                <div class="bg-offwhite rounded-xl p-5 mt-4 text-sm space-y-1 border border-black/5">
                    <p><strong>KNM Srl</strong></p>
                    <p>Partita IVA: 13273091002</p>
                    <p>Sede legale: [inserire indirizzo completo]</p>
                    <p>Email: <a href="mailto:info@aeroportoreggiocalabria.it" class="text-sky hover:underline">info@aeroportoreggiocalabria.it</a></p>
                    <p>PEC: [inserire indirizzo PEC]</p>
                </div>
                <p class="mt-4 text-sm bg-amber-50 border border-amber-200 rounded-lg p-4"><strong>Avviso importante:</strong> aeroportoreggiocalabria.it è un portale informativo e turistico indipendente. Non è il sito ufficiale della SACAL S.p.A. né dell&rsquo;Aeroporto Internazionale di Reggio Calabria Tito Minniti. Per informazioni operative ufficiali sull&rsquo;aeroporto si rimanda a <a href="https://www.sacal.it" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">sacal.it</a>.</p>
            </div>

            {{-- 2 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">2. Oggetto e Finalità del Portale</h2>
                <p>Il Portale ha lo scopo di fornire agli utenti informazioni turistiche, logistiche e di viaggio legate all&rsquo;Aeroporto di Reggio Calabria e alla Regione Calabria, incluse a titolo esemplificativo:</p>
                <ul class="mt-3 space-y-2 list-none">
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span>Informazioni sui voli (partenze, arrivi, compagnie aeree).</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span>Guide turistiche su destinazioni, attrazioni e itinerari calabresi.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span>Informazioni pratiche su servizi aeroportuali, trasporti e strutture ricettive.</span></li>
                    <li class="flex gap-3"><span class="text-gold font-bold shrink-0">&#x25B8;</span><span>Opportunità di partnership commerciali e istituzionali.</span></li>
                </ul>
                <p class="mt-3">I contenuti informativi &mdash; incluse le informazioni sui voli &mdash; hanno carattere puramente indicativo e non sostituiscono le fonti ufficiali di compagnie aeree, aeroporto o autorità competenti.</p>
            </div>

            {{-- 3 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">3. Proprietà Intellettuale</h2>
                <p>Tutti i contenuti del Sito &mdash; testi, grafica, loghi, icone, immagini, codice sorgente, struttura e layout &mdash; sono di proprietà esclusiva di <strong>KNM Srl</strong> o dei rispettivi detentori di diritti, e sono protetti dalla normativa italiana ed europea sul diritto d&rsquo;autore (L. 633/1941, Direttiva 2001/29/CE e Direttiva 2019/790/UE).</p>
                <p class="mt-3">È vietata qualsiasi riproduzione, distribuzione, comunicazione al pubblico, adattamento o utilizzo commerciale, anche parziale, dei contenuti del Sito senza preventiva autorizzazione scritta di KNM Srl. È consentita la citazione di brevi estratti a fini informativi, con obbligo di indicare la fonte.</p>
            </div>

            {{-- 4 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">4. Limitazione di Responsabilità</h2>

                <h3 class="text-lg font-bold text-navy mb-3">4.1 Accuratezza delle Informazioni</h3>
                <p>KNM Srl si impegna a mantenere i contenuti aggiornati e accurati, ma non garantisce la completezza, l&rsquo;esattezza o l&rsquo;aggiornamento in tempo reale delle informazioni pubblicate, in particolare di quelle relative a orari di volo, tariffe, disponibilità e servizi aeroportuali. <strong>L&rsquo;utente è invitato a verificare sempre le informazioni operative presso le fonti ufficiali.</strong></p>

                <h3 class="text-lg font-bold text-navy mt-6 mb-3">4.2 Interruzioni del Servizio</h3>
                <p>KNM Srl non garantisce la disponibilità continuativa del Sito e non risponde per eventuali interruzioni, ritardi o malfunzionamenti dovuti a cause tecniche, forza maggiore o interventi di manutenzione.</p>

                <h3 class="text-lg font-bold text-navy mt-6 mb-3">4.3 Link a Siti Terzi</h3>
                <p>Il Sito può contenere link a siti web di terze parti. KNM Srl non è responsabile dei contenuti, delle politiche sulla privacy né delle pratiche commerciali di tali siti. L&rsquo;inserimento di un link non implica approvazione o affiliazione.</p>

                <h3 class="text-lg font-bold text-navy mt-6 mb-3">4.4 Esclusione di Responsabilità Indiretta</h3>
                <p>Nei limiti consentiti dalla legge applicabile, KNM Srl non risponde per danni diretti, indiretti, incidentali, consequenziali o punitive derivanti dall&rsquo;utilizzo o dall&rsquo;impossibilità di utilizzo del Sito o dei suoi contenuti.</p>
            </div>

            {{-- 5 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">5. Obblighi dell&rsquo;Utente</h2>
                <p>L&rsquo;utente si impegna a utilizzare il Sito nel rispetto della legge, dei presenti T&amp;C e dei diritti di terzi. In particolare, è vietato:</p>
                <ul class="mt-3 space-y-2 list-none">
                    <li class="flex gap-3"><span class="text-red-400 font-bold shrink-0">&#x2715;</span><span>Utilizzare il Sito per scopi illegali o non autorizzati.</span></li>
                    <li class="flex gap-3"><span class="text-red-400 font-bold shrink-0">&#x2715;</span><span>Tentare di accedere a sezioni riservate o alle infrastrutture tecniche del Sito senza autorizzazione.</span></li>
                    <li class="flex gap-3"><span class="text-red-400 font-bold shrink-0">&#x2715;</span><span>Effettuare attività di scraping, crawling o data mining automatizzato senza previa autorizzazione scritta.</span></li>
                    <li class="flex gap-3"><span class="text-red-400 font-bold shrink-0">&#x2715;</span><span>Trasmettere contenuti diffamatori, osceni, fraudolenti o lesivi di diritti altrui tramite i form del Sito.</span></li>
                    <li class="flex gap-3"><span class="text-red-400 font-bold shrink-0">&#x2715;</span><span>Caricare o diffondere virus, malware o qualsiasi codice dannoso.</span></li>
                </ul>
            </div>

            {{-- 6 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">6. Newsletter e Comunicazioni Commerciali</h2>
                <p>L&rsquo;iscrizione alla newsletter è facoltativa e basata sul consenso esplicito dell&rsquo;utente. Ogni comunicazione commerciale inviata da KNM Srl conterrà un link per la disiscrizione immediata. Per il trattamento dei dati connessi alla newsletter si rinvia alla <a href="{{ route('privacy') }}" class="text-sky hover:underline font-semibold">Privacy Policy</a>.</p>
            </div>

            {{-- 7 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">7. Partnership Commerciali</h2>
                <p>Il Portale offre opportunità di partnership commerciale e istituzionale. I contenuti sponsorizzati o promozionali sono chiaramente identificati come tali. KNM Srl garantisce che la remunerazione da parte di partner commerciali non influenza l&rsquo;obiettività delle informazioni editoriali pubblicate.</p>
            </div>

            {{-- 8 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">8. Trattamento dei Dati Personali</h2>
                <p>Il trattamento dei dati personali degli utenti è disciplinato dalla <a href="{{ route('privacy') }}" class="text-sky hover:underline font-semibold">Privacy Policy</a> e dalla <a href="{{ route('cookies') }}" class="text-sky hover:underline font-semibold">Cookie Policy</a>, che costituiscono parte integrante dei presenti T&amp;C.</p>
            </div>

            {{-- 9 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">9. Modifiche ai Termini e Condizioni</h2>
                <p>KNM Srl si riserva il diritto di modificare i presenti T&amp;C in qualsiasi momento. Le modifiche saranno pubblicate su questa pagina con aggiornamento della data in calce. L&rsquo;utilizzo continuato del Sito successivamente alla pubblicazione delle modifiche costituisce accettazione delle stesse.</p>
            </div>

            {{-- 10 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">10. Legge Applicabile e Foro Competente</h2>
                <p>I presenti T&amp;C sono regolati dalla legge italiana. Per qualsiasi controversia relativa all&rsquo;interpretazione, esecuzione o risoluzione dei presenti T&amp;C, le parti concordano che la competenza esclusiva spetta al <strong>Foro di Roma</strong>, fatto salvo il caso in cui l&rsquo;utente rivesta la qualità di consumatore, nel qual caso sarà competente il foro del luogo di residenza o domicilio dello stesso ai sensi del D.Lgs. 206/2005 (Codice del Consumo).</p>
                <p class="mt-3">Per controversie di consumo, l&rsquo;utente potrà ricorrere alla piattaforma europea di risoluzione online delle controversie (ODR): <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener noreferrer" class="text-sky hover:underline">ec.europa.eu/consumers/odr</a>.</p>
            </div>

            {{-- 11 --}}
            <div>
                <h2 class="text-2xl font-black text-navy mb-4">11. Contatti</h2>
                <p>Per qualsiasi richiesta relativa ai presenti T&amp;C:</p>
                <div class="bg-offwhite rounded-xl p-5 mt-4 text-sm space-y-1 border border-black/5">
                    <p><strong>KNM Srl</strong> &mdash; P.IVA 13273091002</p>
                    <p>Email: <a href="mailto:info@aeroportoreggiocalabria.it" class="text-sky hover:underline">info@aeroportoreggiocalabria.it</a></p>
                    <p>Oppure tramite il <a href="{{ route('contact') }}" class="text-sky hover:underline">modulo di contatto</a>.</p>
                </div>
                <p class="mt-4 text-sm text-gray-400">Ultima revisione: <strong class="text-gray-600">21 maggio 2026</strong> &mdash; versione 1.0</p>
            </div>

        </div>
    </div>
</section>

@endsection
