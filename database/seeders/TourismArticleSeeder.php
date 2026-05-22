<?php

namespace Database\Seeders;

use App\Models\TourismArticle;
use Illuminate\Database\Seeder;

class TourismArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = $this->getArticles();
        $count = 0;
        foreach ($articles as $article) {
            TourismArticle::updateOrCreate(
                ['title_it' => $article['title_it']],
                $article
            );
            $count++;
        }
        $this->command->info("✅ Articoli turismo inseriti/aggiornati: {$count}");
    }

    private function getArticles(): array
    {
        return [
            // 1. REGGIO CALABRIA CITTÀ
            [
                'post_type' => 'guide', 'category' => 'storia',
                'color_from' => '#0D2B4B', 'color_to' => '#1A5276',
                'image_url' => '/img/calabria/IMG_20250222_104907.jpg',
                'og_image' => '/img/calabria/IMG_20250222_104907.jpg',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now(), 'author' => 'Redazione CalabriaGate', 'reading_time' => 7,
                'title_it' => 'Reggio Calabria: guida completa alla città dei Bronzi',
                'title_en' => 'Reggio Calabria: Complete Guide to the City of the Bronzes',
                'excerpt_it' => "Il lungomare più bello d'Italia, i Bronzi di Riace, la granita con brioche e il Castello Aragonese 2027: tutto quello che devi sapere su Reggio Calabria, a 10 minuti dall'aeroporto.",
                'excerpt_en' => "The most beautiful seafront in Italy, the Riace Bronzes, granita with brioche: everything about Reggio Calabria.",
                'seo_title_it' => 'Reggio Calabria cosa vedere — Guida turistica completa 2025',
                'seo_description_it' => "Scopri Reggio Calabria: lungomare Falcomatà, Bronzi di Riace, Castello Aragonese, granita con brioche. A 10 minuti dall'aeroporto REG.",
                'focus_keyword' => 'Reggio Calabria cosa vedere',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20250222_104907.jpg" alt="Lungomare Falcomatà di Reggio Calabria" style="width:100%;height:420px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il lungomare Falcomatà — definito da D\'Annunzio «il chilometro più bello d\'Italia»</figcaption></figure><h2>La città affacciata sulla Sicilia</h2><p>Reggio Calabria è l\'ultima città dell\'Italia continentale prima del mare. Affacciata sullo Stretto di Messina con la costa siciliana a soli 3 chilometri, è una città che vive all\'aperto, tra il lungomare e le piazze animate fino a tarda notte. Capoluogo della Calabria e designata <strong>Capitale Italiana della Cultura 2027</strong>.</p><h2>Il Lungomare Falcomatà</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20250222_105650.jpg" alt="Spiaggia di ghiaia nera di Reggio Calabria con lo Stretto" style="width:100%;height:340px;object-fit:cover;"></figure><p>Quattro chilometri di passeggiata sul mare, con palme tropicali e lampioni liberty. La sera il lungomare si anima di famiglie e innamorati. Al tramonto è forse il posto più bello della Calabria.</p><h2>Il Castello Aragonese e Reggio 2027</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20250216_201948.jpg" alt="Castello Aragonese di Reggio Calabria illuminato" style="width:100%;height:380px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il Castello Aragonese con la proiezione Capitale della Cultura 2027</figcaption></figure><p>Costruito dai Normanni e ampliato dagli Aragonesi, domina il centro storico. La designazione di Reggio a Capitale Italiana della Cultura 2027 porterà investimenti e eventi internazionali.</p><h2>Il Duomo e Corso Garibaldi</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20241124_154301.jpg" alt="Cattedrale di Reggio Calabria" style="width:100%;height:360px;object-fit:cover;"></figure><p>Il <strong>Corso Garibaldi</strong> è il cuore della città: rettilineo pedonale con palazzi Liberty. Di sera si trasforma in una passeggiata animata.</p><h2>La granita con brioche</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20240804_201225.jpg" alt="Granita con brioche tipica di Reggio Calabria" style="width:100%;height:300px;object-fit:cover;"></figure><p>La colazione calabrese per eccellenza: granita artigianale in bicchiere — mandorla, pistacchio o bergamotto — con brioche morbida. Un rito irrinunciabile nelle pasticcerie storiche del Corso.</p><h2>Il tramonto sull\'Etna</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/PB190058.JPG" alt="Tramonto con l\'Etna visto da Reggio Calabria" style="width:100%;height:400px;object-fit:cover;"></figure><p>Nelle serate limpide l\'Etna appare all\'orizzonte mentre il sole tramonta sui Peloritani siciliani. Lo Stretto si tinge di arancio e viola: lo spettacolo più emozionante di Reggio Calabria.</p>',
            ],

            // 2. BRONZI DI RIACE
            [
                'post_type' => 'guide', 'category' => 'storia',
                'color_from' => '#3B2100', 'color_to' => '#7B4A00',
                'image_url' => '/img/calabria/IMG_20241006_191916.jpg',
                'og_image' => '/img/calabria/IMG_20241006_191916.jpg',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(1), 'author' => 'Redazione CalabriaGate', 'reading_time' => 6,
                'title_it' => 'I Bronzi di Riace: i guerrieri greci di Reggio Calabria',
                'title_en' => 'The Riace Bronzes: the Greek Warriors of Reggio Calabria',
                'excerpt_it' => 'Due guerrieri greci del V secolo a.C., trovati nel 1972 sul fondale di Riace. Al Museo Nazionale di Reggio Calabria custodiscono i capolavori assoluti della scultura greca antica.',
                'excerpt_en' => 'Two 5th-century BC Greek warriors found in 1972 off Riace — absolute masterpieces of ancient Greek sculpture.',
                'seo_title_it' => 'Bronzi di Riace Reggio Calabria — Museo Nazionale MArRC',
                'seo_description_it' => "I Bronzi di Riace al Museo Nazionale di Reggio Calabria: storia, orari e cosa vedere. A 10 minuti dall'aeroporto REG.",
                'focus_keyword' => 'Bronzi di Riace Reggio Calabria',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20241006_191916.jpg" alt="Bronzo A di Riace al Museo Nazionale di Reggio Calabria" style="width:100%;height:480px;object-fit:cover;object-position:center top;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il Bronzo A — 198 cm di perfezione greca del 460 a.C.</figcaption></figure><h2>Una scoperta straordinaria</h2><p>Era il 16 agosto 1972 quando Stefano Mariottini, durante un\'immersione a Riace Marina, notò un braccio emergere dalla sabbia del fondale. Era uno dei <strong>Bronzi di Riace</strong> — due statue greche del V secolo a.C. che giacevano in fondo al Mar Ionio da duemila anni.</p><h2>Chi sono i Bronzi?</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20241006_191919.jpg" alt="Bronzo B di Riace al Museo Nazionale" style="width:100%;height:400px;object-fit:cover;object-position:center top;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il Bronzo B — il guerriero più anziano con barba e capelli ricciuti</figcaption></figure><p>Il <strong>Bronzo A</strong> è il giovane: imberbe, capelli mossi, occhi in avorio e calcite che sembrano vivi. Il <strong>Bronzo B</strong> è l\'anziano: barba folta, rughe, espressione di saggezza. Entrambi risalgono al 460-450 a.C. e sono di origine ateniese.</p><h2>Il Museo Nazionale (MArRC)</h2><p>Il Museo Archeologico Nazionale di Reggio Calabria è il più importante museo della Magna Grecia. Oltre ai Bronzi conserva reperti da Locri, Crotone, Sibari e Metaponto.</p><ul><li><strong>Indirizzo:</strong> Piazza De Nava 26, Reggio Calabria</li><li><strong>Orari:</strong> Mart–Dom 9:00–20:00 (chiuso lunedì)</li><li><strong>Come arrivare:</strong> 15 minuti in taxi dall\'aeroporto REG</li></ul>',
            ],

            // 3. ASPROMONTE
            [
                'post_type' => 'guide', 'category' => 'natura',
                'color_from' => '#1A3520', 'color_to' => '#2D6A4F',
                'image_url' => '/img/calabria/IMG_20250421_113415.jpg',
                'og_image' => '/img/calabria/IMG_20250421_113415.jpg',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(3), 'author' => 'Redazione CalabriaGate', 'reading_time' => 6,
                'title_it' => "Aspromonte: trekking, torrenti e natura selvaggia in Calabria",
                'title_en' => 'Aspromonte: Hiking, Streams and Wild Nature in Calabria',
                'excerpt_it' => "Il Parco Nazionale dell'Aspromonte è la montagna più meridionale d'Italia: boschi di pino laricio, torrenti cristallini e panorami sull'Etna. A 30 minuti dall'aeroporto di Reggio Calabria.",
                'excerpt_en' => "Aspromonte National Park: Italy's southernmost mountain with pine forests, streams and views of Etna.",
                'seo_title_it' => "Aspromonte trekking e natura — Parco Nazionale Calabria",
                'seo_description_it' => "Guida al Parco Nazionale dell'Aspromonte: trekking, torrenti, borghi e sapori. A 30 minuti dall'aeroporto di Reggio Calabria.",
                'focus_keyword' => 'Aspromonte trekking Calabria',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20250421_113415.jpg" alt="Prati fioriti di giallo in Aspromonte" style="width:100%;height:420px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Primavera in Aspromonte — le praterie fiorite tra aprile e giugno</figcaption></figure><h2>La montagna che scende al mare</h2><p>L\'Aspromonte sale dall\'aeroporto di Reggio Calabria fino ai 1.956 metri del Montalto. Dalle vette si vedono contemporaneamente Mar Ionio, Tirreno, Sicilia ed Etna. Il <strong>Parco Nazionale</strong>, istituito nel 1994 su 64.000 ettari, è uno degli ecosistemi più intatti d\'Italia meridionale.</p><h2>Uliveti, limoni e campagna aspromontana</h2><figure style="margin:1.5rem 0;display:grid;grid-template-columns:1fr 1fr;gap:1rem;"><img src="/img/calabria/IMG_20250421_113014.jpg" alt="Albero di limone in Aspromonte" style="width:100%;height:260px;object-fit:cover;border-radius:10px;"><img src="/img/calabria/IMG_20250421_113338.jpg" alt="Campagna aspromontana con ulivi" style="width:100%;height:260px;object-fit:cover;border-radius:10px;"></figure><p>Alle quote basse, uliveti millenari e agrumeti producono olio extravergine di qualità eccezionale. In primavera i profumi dei limoni si mischiano ai fiori selvatici: camminare tra i campi è una delle esperienze più piacevoli della regione.</p><h2>I torrenti: il tesoro dell\'estate</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P7281492.JPG" alt="Torrente nel bosco dell\'Aspromonte" style="width:100%;height:360px;object-fit:cover;"></figure><p>I torrenti Amendolea, Buonamico e Tuccio formano piscine naturali di acqua glaciale. In estate sono la meta preferita delle famiglie. Le <strong>vasche naturali</strong> nella roccia sono tra le esperienze più uniche della Calabria.</p><h2>Il bosco e i prodotti locali</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20240728_104751.jpg" alt="Banchetto di prodotti locali nel bosco di pini" style="width:100%;height:300px;object-fit:cover;"></figure><p>Nei boschi di pino laricio, piccoli produttori vendono funghi porcini, castagne, miele e capocollo di suino nero calabrese. Il <strong>panino col capocollo nel bosco</strong> è una delle esperienze gastronomiche più autentiche della Calabria.</p><p><strong>Come arrivare:</strong> Auto dall\'aeroporto REG → SS183 verso Gambarie. Gambarie: 30 km / 40 minuti.</p>',
            ],

            // 4. PENTEDATTILO
            [
                'post_type' => 'guide', 'category' => 'borghi',
                'color_from' => '#2C1654', 'color_to' => '#4B2E8A',
                'image_url' => '/img/calabria/P4072071.JPG',
                'og_image' => '/img/calabria/P4072071.JPG',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(4), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => 'Pentedattilo: il borgo fantasma delle cinque dita di roccia',
                'title_en' => 'Pentedattilo: the Ghost Village of the Five Rock Fingers',
                'excerpt_it' => 'Aggrappato a cinque pinnacoli di roccia che sembrano una mano gigante, Pentedattilo è uno dei borghi abbandonati più suggestivi d\'Italia. A 30 minuti dall\'aeroporto di Reggio Calabria.',
                'excerpt_en' => 'Clinging to five rock pinnacles resembling a giant hand, Pentedattilo is one of Italy\'s most evocative abandoned villages.',
                'seo_title_it' => 'Pentedattilo borgo fantasma Calabria — come arrivare e cosa vedere',
                'seo_description_it' => "Guida a Pentedattilo: il borgo fantasma calabrese aggrappato alle rocce. A 30 minuti dall'aeroporto di Reggio Calabria.",
                'focus_keyword' => 'Pentedattilo borgo fantasma',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4072071.JPG" alt="Pentedattilo borgo fantasma aggrappato alle rocce" style="width:100%;height:460px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Pentedattilo — le cinque dita di roccia che danno il nome al borgo</figcaption></figure><h2>Un nome che racconta tutto</h2><p><em>Pentedattilo</em>: cinque dita in greco. Le cinque guglie di roccia che si ergono dal monte Calvario con le rovine del borgo medievale incastonato tra esse formano uno dei paesaggi più iconici della Calabria. A 20 km da Reggio Calabria, accesso libero e gratuito.</p><h2>Storia e abbandono</h2><p>Fondato in epoca greco-romana, Pentedattilo fu gradualmente abbandonato nel XX secolo dopo frane e il terremoto del 1908. Oggi è un suggestivo borgo fantasma parzialmente restaurato. Il <strong>Festival di Pentedattilo</strong> in estate lo riporta in vita con eventi culturali internazionali.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4072075.JPG" alt="Fiori gialli selvatici con le rocce di Pentedattilo" style="width:100%;height:360px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">In primavera i fiori selvatici colorano i pendii attorno alle rocce</figcaption></figure><h2>Come visitare</h2><p>Fermati alla piazzola panoramica sulla strada statale per la foto più iconica. Nel borgo: vicoli di pietra, la chiesa restaurata, i resti del castello e terrazze panoramiche verso la Sicilia. <strong>Consiglio fotografico:</strong> visita nel primo pomeriggio (14-17) con la luce sulle rocce.</p>',
            ],

            // 5. GALLICIANÒ
            [
                'post_type' => 'guide', 'category' => 'storia',
                'color_from' => '#1A3A1A', 'color_to' => '#2E6B3E',
                'image_url' => '/img/calabria/P4192806.JPG',
                'og_image' => '/img/calabria/P4192806.JPG',
                'is_published' => true, 'is_featured' => false,
                'published_at' => now()->subDays(5), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => "Gallicianò: il borgo dove si parla ancora il greco antico",
                'title_en' => 'Gallicianò: the Village Where Ancient Greek is Still Spoken',
                'excerpt_it' => "A Gallicianò, nell'Aspromonte, una comunità custodisce la lingua grecanica — discendente diretta del greco parlato nella Magna Grecia. Un'esperienza unica in Europa.",
                'excerpt_en' => 'In Gallicianò, Aspromonte, a community preserves the Greko language — a direct descendant of ancient Greek.',
                'seo_title_it' => 'Gallicianò borgo Calabria — lingua grecanica e Magna Grecia',
                'seo_description_it' => "Scopri Gallicianò: il borgo dove si parla il grecanico, discendente del greco antico della Magna Grecia. Come arrivare dall'aeroporto di Reggio Calabria.",
                'focus_keyword' => 'Gallicianò borgo grecanico',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4192806.JPG" alt="Gallicianò borgo grecanico nell\'Aspromonte" style="width:100%;height:420px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Gallicianò — il cuore della Magna Grecia tra i boschi dell\'Aspromonte</figcaption></figure><h2>Il cuore della Magna Grecia</h2><p>Duemila e settecento anni fa, i coloni greci fondarono città sulla costa calabrese. A Gallicianò, borgo nel comune di Condofuri, questa storia non è finita: la <strong>lingua grecanica</strong> è ancora parlata e tramandata.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4192809.JPG" alt="Targa trilingue di Gallicianò in grecanico, italiano e greco moderno" style="width:100%;height:320px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">La targa trilingue all\'ingresso del borgo: grecanico, italiano e greco moderno</figcaption></figure><h2>La lingua grecanica</h2><p>Il grecanico (greko) è una varietà linguistica discendente dal greco antico, tutelata dalla legge 482/1999. La targa di Gallicianò riporta il nome in tre lingue: <em>Gaddhicianò</em> (grecanico), <em>Gallicianò</em> (italiano) e <em>Γκαλλιτσιανό</em> (greco moderno).</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4192807.JPG" alt="Pietra con incisa la scritta Gaddhicianò" style="width:100%;height:280px;object-fit:cover;"></figure><p><strong>Come arrivare:</strong> 60 km da Reggio Calabria (1 ora). Visita preferibilmente nei fine settimana estivi con eventi culturali grecanici.</p>',
            ],

            // 6. BADOLATO
            [
                'post_type' => 'guide', 'category' => 'borghi',
                'color_from' => '#5C2E00', 'color_to' => '#9A5B00',
                'image_url' => '/img/calabria/P4263022.JPG',
                'og_image' => '/img/calabria/P4263022.JPG',
                'is_published' => true, 'is_featured' => false,
                'published_at' => now()->subDays(6), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => "Badolato: il borgo dell'accoglienza sul Mar Ionio",
                'title_en' => 'Badolato: the Village of Welcome on the Ionian Sea',
                'excerpt_it' => "Fondato nel 1080, Badolato è il borgo che nel 1997 accolse 213 rifugiati curdi diventando simbolo di integrazione. Vicoli di pietra, castello normanno e bougainvillea rosa sul Mar Ionio.",
                'excerpt_en' => 'Founded in 1080, Badolato became a symbol of welcome when it hosted 213 Kurdish refugees in 1997.',
                'seo_title_it' => 'Badolato borgo medievale Calabria — cosa vedere e storia',
                'seo_description_it' => "Guida a Badolato: borgo medievale sul Mar Ionio, castello normanno, bougainvillea. La storia dei rifugiati curdi 1997. Come arrivare dall'aeroporto REG.",
                'focus_keyword' => 'Badolato borgo Calabria',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4263022.JPG" alt="Castello normanno di Badolato sul Mar Ionio" style="width:100%;height:420px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il castello normanno di Badolato domina la vallata verso il Mar Ionio</figcaption></figure><h2>Il borgo dell\'accoglienza</h2><p>Nel 1997 una nave con 213 rifugiati curdi si arenò sulla spiaggia di Badolato. Il sindaco propose di portarli nel borgo antico semivuoto. La proposta fece il giro del mondo: Badolato diventò il simbolo dell\'accoglienza italiana.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P4263155.JPG" alt="Castello di Badolato tra gli ulivi" style="width:100%;height:360px;object-fit:cover;"></figure><h2>Il castello e i vicoli</h2><p>Fondato nel 1080 dai Normanni, Badolato si arrampica su una collina a 300 metri sul Mar Ionio. Vicoli di pietra calcarea, scalinate, archi e piazzette creano il classico impianto medievale calabrese.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P5040076.JPG" alt="Bougainvillea rosa fiorita a Badolato con il Mar Ionio" style="width:100%;height:340px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">La bougainvillea in fioritura con il Mar Ionio cristallino sullo sfondo</figcaption></figure><p>Dalla terrazza panoramica si vede il Mar Ionio splendente. La bougainvillea rosa sui muri di pietra crea contrasti cromatici meravigliosi in primavera — una delle location fotografiche più belle della Calabria.</p><p><strong>Come arrivare:</strong> 80 km da Reggio Calabria (1h20) lungo la SS106 jonica.</p>',
            ],

            // 7. MUSABA
            [
                'post_type' => 'guide', 'category' => 'storia',
                'color_from' => '#1A0A2E', 'color_to' => '#6B2D8B',
                'image_url' => '/img/calabria/P1071652.JPG',
                'og_image' => '/img/calabria/P1071652.JPG',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(7), 'author' => 'Redazione CalabriaGate', 'reading_time' => 6,
                'title_it' => "MUSABA — Nik Spatari: il museo a cielo aperto più sorprendente del Sud",
                'title_en' => 'MUSABA — Nik Spatari: the Most Surprising Open-Air Museum in Southern Italy',
                'excerpt_it' => "Il MUSABA di Nik Spatari a Santa Caterina dello Ionio: mosaici giganti, la piramide colorata, l'Ultima Cena lunga 40 metri e un giardino di sculture nell'entroterra calabrese.",
                'excerpt_en' => "Nik Spatari's MUSABA: giant mosaics, a coloured pyramid, a 40-metre Last Supper and a sculpture garden.",
                'seo_title_it' => "MUSABA Nik Spatari Calabria — museo d'arte Santa Barbara",
                'seo_description_it' => "Scopri il MUSABA di Nik Spatari: piramide colorata, mosaici, Ultima Cena, giardino sculture. Il museo d'arte più originale della Calabria.",
                'focus_keyword' => 'MUSABA Nik Spatari Calabria',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P1071652.JPG" alt="L\'Ultima Cena di Nik Spatari al MUSABA" style="width:100%;height:440px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">L\'Ultima Cena di Nik Spatari — 40 metri di mosaico policromo</figcaption></figure><h2>Un\'opera d\'arte totale</h2><p>A Santa Caterina dello Ionio, a 90 km da Reggio Calabria, si nasconde uno dei luoghi d\'arte più straordinari d\'Italia. Il <strong>MUSABA</strong> è un intero paesaggio trasformato in opera d\'arte da Nik Spatari (1936-2021) nel corso di cinquant\'anni di lavoro ininterrotto.</p><figure style="margin:1.5rem 0;display:grid;grid-template-columns:1fr 1fr;gap:1rem;"><img src="/img/calabria/P1071576.JPG" alt="La piramide colorata del MUSABA" style="width:100%;height:280px;object-fit:cover;border-radius:10px;"><img src="/img/calabria/P1071556.JPG" alt="Le sfere di mosaico al MUSABA" style="width:100%;height:280px;object-fit:cover;border-radius:10px;"></figure><p>La <strong>piramide colorata</strong> e l\'<strong>Ultima Cena</strong> (ispirata a Leonardo, reinventata in chiave cubista) sono le opere più iconiche. Nel giardino: sfere di mosaico, installazioni scultoree e architetture naturali.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/P1071657.JPG" alt="Nik Spatari al lavoro su un mosaico" style="width:100%;height:340px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Nik Spatari al lavoro — 50 anni dedicati alla creazione del MUSABA</figcaption></figure><p>Nato a Mammola nel 1936, Spatari studiò a Parigi stringendo amicizia con Cocteau e Picasso. Tornato in Calabria, creò questo gioiello con la compagna Hiske Maas. Ideale da combinare con Badolato (15 km).</p>',
            ],

            // 8. BORGO CROCE
            [
                'post_type' => 'guide', 'category' => 'borghi',
                'color_from' => '#2D1B69', 'color_to' => '#11998E',
                'image_url' => '/img/calabria/PB190018.JPG',
                'og_image' => '/img/calabria/PB190018.JPG',
                'is_published' => true, 'is_featured' => false,
                'published_at' => now()->subDays(9), 'author' => 'Redazione CalabriaGate', 'reading_time' => 4,
                'title_it' => 'Borgo Croce: quando un borgo diventa una galleria d\'arte',
                'title_en' => 'Borgo Croce: When a Village Becomes an Art Gallery',
                'excerpt_it' => 'I vicoli di Borgo Croce sono diventati una galleria d\'arte a cielo aperto: murales coloratissimi e installazioni trasformano questo piccolo borgo calabrese in una destinazione artistica sorprendente.',
                'excerpt_en' => 'The alleys of Borgo Croce have become an open-air art gallery: colourful murals transform this Calabrian village into a surprising artistic destination.',
                'seo_title_it' => 'Borgo Croce street art murales Calabria',
                'seo_description_it' => "Borgo Croce e la sua street art: vicoli dipinti, murales colorati e installazioni. Una delle destinazioni artistiche più originali della Calabria meridionale.",
                'focus_keyword' => 'Borgo Croce street art Calabria',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/PB190018.JPG" alt="Grande murales colorato a Borgo Croce con case dipinte in stile naif" style="width:100%;height:420px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il grande murales della città immaginaria — l\'opera più iconica di Borgo Croce</figcaption></figure><h2>Un borgo che racconta storie sui muri</h2><p>Arrivato da una strada stretta, ti ritrovi in un labirinto di vicoli dove ogni muro è una tela: case dipinte con colori accesi, grandi murales narrativi, lettere giganti in metallo colorato. Il progetto artistico ha trasformato questo piccolo borgo in una delle destinazioni culturali più originali della Calabria.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/PB190001.JPG" alt="Installazione di lettere colorate BORGO a Borgo Croce" style="width:100%;height:340px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">L\'installazione delle lettere colorate — la location fotografica più condivisa</figcaption></figure><h2>L\'arte che salva un borgo</h2><p>Come molti borghi dell\'entroterra calabrese, Borgo Croce ha vissuto decenni di spopolamento. L\'arte di strada ha cambiato la prospettiva: ogni anno nuovi artisti dipingono i muri, portando visitatori e restituendo identità alla comunità. Il borough è ancora abitato — gli anziani sui gradini convivono con le opere d\'arte contemporanea.</p><p><strong>Come visitare:</strong> ingresso libero, tutto il giorno. Auto necessaria, circa 40-60 min da Reggio Calabria. Ideale da combinare con Pentedattilo.</p>',
            ],

            // 9. COSTA VIOLA
            [
                'post_type' => 'guide', 'category' => 'mare',
                'color_from' => '#0D6EFD', 'color_to' => '#0DCAF0',
                'image_url' => '/img/calabria/IMG_20250222_105556.jpg',
                'og_image' => '/img/calabria/IMG_20250222_105556.jpg',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(11), 'author' => 'Redazione CalabriaGate', 'reading_time' => 4,
                'title_it' => 'Le spiagge più belle della Costa Viola',
                'title_en' => 'The Most Beautiful Beaches of the Costa Viola',
                'excerpt_it' => "Acque cristalline e tramonti mozzafiato: la Costa Viola è uno dei tesori nascosti del Mediterraneo. Da Scilla a Palmi, un litorale tirrenico di rara bellezza a 30 km da Reggio Calabria.",
                'excerpt_en' => "Crystal-clear waters and breathtaking sunsets: the Costa Viola is one of the Mediterranean's hidden treasures.",
                'seo_title_it' => 'Costa Viola Calabria — spiagge, Scilla e cosa vedere',
                'seo_description_it' => "La Costa Viola: da Scilla a Palmi le spiagge più belle della Calabria tirrenica. Come arrivare dall'aeroporto di Reggio Calabria.",
                'focus_keyword' => 'Costa Viola Calabria spiagge',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20250222_105556.jpg" alt="Mar Ionio da Reggio Calabria con la Sicilia sullo sfondo" style="width:100%;height:400px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Le acque dello Stretto di Messina — tra le più limpide del Mediterraneo</figcaption></figure><h2>Il litorale dei colori violetti</h2><p>La <strong>Costa Viola</strong> prende il nome dal colore particolare delle sue acque al tramonto: una sfumatura viola-indaco causata dalla rifrazione della luce sulle rocce basaltiche. Si estende per 30 km tra Villa San Giovanni e Palmi, raggiungibile in 30-45 minuti dall\'aeroporto REG.</p><h2>Scilla: il borgo più fotografato</h2><p><strong>Scilla</strong> è il gioiello della Costa Viola: il borgo di pescatori su uno scoglio a picco, il castello Ruffo illuminato la sera, la frazione di Chianalea dove le case si affacciano direttamente sul mare. La spiaggia di Marina Grande è sabbiosa e limpidissima. I ristoranti di Chianalea servono il pesce spada dello Stretto pescato con le lance tradizionali.</p><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20250222_105650.jpg" alt="Spiaggia di ciottoli con lo Stretto di Messina" style="width:100%;height:320px;object-fit:cover;"></figure><p><strong>Distanze da Reggio Calabria REG:</strong> Scilla 25 km (30 min) · Bagnara 30 km · Palmi 50 km · Tropea 90 km (1h30).</p>',
            ],

            // 10. GASTRONOMIA
            [
                'post_type' => 'guide', 'category' => 'gastronomia',
                'color_from' => '#7E1D00', 'color_to' => '#C0392B',
                'image_url' => '/img/calabria/IMG_20240804_201225.jpg',
                'og_image' => '/img/calabria/IMG_20240804_201225.jpg',
                'is_published' => true, 'is_featured' => false,
                'published_at' => now()->subDays(13), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => 'Gastronomia calabrese: nduja, bergamotto e granita con brioche',
                'title_en' => 'Calabrian Gastronomy: Nduja, Bergamot and Granita with Brioche',
                'excerpt_it' => "Nduja piccante, capocollo di suino nero, bergamotto e la granita con brioche: la cucina calabrese è un viaggio tra sapori intensi e prodotti DOP di eccellenza.",
                'excerpt_en' => 'Spicy nduja, black pork capocollo, bergamot and granita with brioche: Calabrian cuisine is a sensory journey.',
                'seo_title_it' => 'Cucina calabrese tipica — prodotti DOP e sapori del Sud',
                'seo_description_it' => "Scopri la gastronomia calabrese: nduja, peperoncino, bergamotto, granita con brioche, capocollo. I sapori della Calabria da assaggiare almeno una volta.",
                'focus_keyword' => 'gastronomia calabrese tipica',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20240804_201225.jpg" alt="Granita con brioche tipica di Reggio Calabria" style="width:100%;height:380px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">La granita con brioche — il rito mattutino di Reggio Calabria</figcaption></figure><h2>La granita con brioche: la colazione calabrese</h2><p>A Reggio Calabria la colazione è <strong>granita e brioche</strong>: un gelato semifreddo — mandorla, pistacchio, caffè o bergamotto — con brioche appena tiepida. Un rito identitario che va vissuto almeno una volta. Le pasticcerie del Corso Garibaldi aprono dalle 6:30.</p><h2>Il bergamotto: l\'oro di Reggio</h2><p>Il bergamotto cresce solo in una fascia di 100 km nell\'area reggina. Il suo olio è nel Chanel N°5 e nel tè Earl Grey. Come prodotto gastronomico si trova in marmellate, liquori, cioccolatini e granite.</p><h2>La nduja e il capocollo</h2><figure style="margin:1.5rem 0;border-radius:12px;overflow:hidden;"><img src="/img/calabria/IMG_20240728_124508.jpg" alt="Panino con capocollo calabrese nel bosco" style="width:100%;height:300px;object-fit:cover;"></figure><p>La <strong>nduja di Spilinga</strong> è la salsiccia spalmabile piccantissima famosa nel mondo. Il <strong>capocollo di suino nero calabrese</strong> è un salume aromatico di qualità eccezionale, prodotto da maiali allevati allo stato semibrado nei boschi.</p><p>Il peperoncino calabrese e il sugo al pomodoro con nduja completano il quadro di una cucina intensa, autentica e impossibile da dimenticare.</p>',
            ],

            // 11. TROPEA
            [
                'post_type' => 'guide', 'category' => 'mare',
                'color_from' => '#0A3D62', 'color_to' => '#1E90FF',
                'image_url' => 'https://images.unsplash.com/photo-1596436889106-be35e843f974?w=1200&q=80',
                'og_image' => 'https://images.unsplash.com/photo-1596436889106-be35e843f974?w=1200&q=80',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(15), 'author' => 'Redazione CalabriaGate', 'reading_time' => 6,
                'title_it' => 'Tropea: la perla del Tirreno calabrese',
                'title_en' => 'Tropea: the Pearl of the Calabrian Tyrrhenian Coast',
                'excerpt_it' => "Aggrappata a una falesia di tufo sul Mar Tirreno, Tropea è il borgo marino più famoso della Calabria. Acque turchesi, la Cipolla Rossa DOP, il Santa Maria dell'Isola: ecco perché è irresistibile.",
                'excerpt_en' => 'Perched on a tuff cliff above the Tyrrhenian Sea, Tropea is Calabria\'s most famous coastal village: turquoise water, red onions DOP and the island church.',
                'seo_title_it' => 'Tropea Calabria cosa vedere — spiagge, borgo e cipolla rossa',
                'seo_description_it' => "Guida completa a Tropea: spiagge di sabbia bianca, acqua turchese, la chiesa sull'isola e la cipolla rossa DOP. A 90 minuti dall'aeroporto di Reggio Calabria.",
                'focus_keyword' => 'Tropea Calabria cosa vedere',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="https://images.unsplash.com/photo-1596436889106-be35e843f974?w=1200&q=80" alt="Tropea borgo su falesia con mare turchese" style="width:100%;height:460px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Tropea — aggrappata alla falesia di tufo sul Mar Tirreno</figcaption></figure><h2>Il borgo sulla roccia</h2><p>Tropea è costruita su un promontorio di tufo che cade verticalmente nel mare. Il panorama dalla terrazza del Corso Vittorio Emanuele è tra i più fotografati d\'Italia: la spiaggia bianca, l\'acqua in mille sfumature di azzurro, e in lontananza lo Stromboli che fuma.</p><h2>Santa Maria dell\'Isola</h2><p>Il simbolo di Tropea è il santuario di Santa Maria dell\'Isola, costruito su uno scoglio isolato raggiungibile a piedi con la bassa marea. La chiesa medievale è visibile da chilometri di costa e rappresenta uno dei paesaggi più iconici del Mediterraneo. Al tramonto diventa pura magia.</p><h2>Le spiagge di Tropea</h2><p>La <strong>Spiaggia della Rotonda</strong> è la spiaggia urbana principale: sabbia chiara finissima e acque cristalline classificate Bandiera Blu. A nord, la <strong>Spiaggia di Riaci</strong> offre paesaggi di archi naturali di tufo che emergono dal mare — scenario da cartolina e ottimo snorkeling.</p><h2>La Cipolla Rossa di Tropea DOP</h2><p>La <strong>Cipolla Rossa di Tropea IGP</strong> è dolce, succosa e delicatissima — così diversa dalle cipolle comuni da essere mangiata cruda come frutto. Si trova in tutto il centro storico: in marmellata, in crema, sotto aceto o fresca. Da portare a casa come souvenir gastronomico d\'eccellenza.</p><p><strong>Come arrivare:</strong> 90 km da Reggio Calabria (1h30) via A2/E45. In estate si consiglia il treno Reggio–Tropea (linea tirrenica).</p>',
            ],

            // 12. LOCRI E MAGNA GRECIA
            [
                'post_type' => 'guide', 'category' => 'storia',
                'color_from' => '#2C3E50', 'color_to' => '#8E7B4A',
                'image_url' => 'https://images.unsplash.com/photo-1525874684015-58379d421a52?w=1200&q=80',
                'og_image' => 'https://images.unsplash.com/photo-1525874684015-58379d421a52?w=1200&q=80',
                'is_published' => true, 'is_featured' => false,
                'published_at' => now()->subDays(18), 'author' => 'Redazione CalabriaGate', 'reading_time' => 6,
                'title_it' => 'Locri Epizefiri: la colonia greca che inventò le leggi scritte',
                'title_en' => 'Locri Epizefiri: the Greek Colony that Invented Written Laws',
                'excerpt_it' => "Locri Epizefiri fondò nel VII sec. a.C. il primo codice di leggi scritte della storia. L'area archeologica e il Museo Nazionale raccontano 2.700 anni di storia della Magna Grecia sul Mar Ionio.",
                'excerpt_en' => 'Founded in the 7th century BC, Locri Epizefiri gave the world its first written code of laws. The archaeological site tells 2,700 years of Magna Graecia history.',
                'seo_title_it' => 'Locri Epizefiri area archeologica — Magna Grecia in Calabria',
                'seo_description_it' => "Scopri Locri Epizefiri: le prime leggi scritte della storia, l'area archeologica e il Museo Nazionale. A 40 km dall'aeroporto di Reggio Calabria.",
                'focus_keyword' => 'Locri Epizefiri area archeologica Magna Grecia',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="https://images.unsplash.com/photo-1525874684015-58379d421a52?w=1200&q=80" alt="Rovine di templi greci con cielo azzurro" style="width:100%;height:440px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Rovine della Magna Grecia — 2.700 anni di storia sul Mar Ionio</figcaption></figure><h2>La città delle prime leggi</h2><p>Nel VII secolo a.C., quando Roma era ancora un villaggio di capanne, <strong>Locri Epizefiri</strong> era una delle città più prospere del Mediterraneo. Qui Zaleuco redasse il primo codice di leggi scritte della storia umana — una rivoluzione che influenzò tutta la civiltà occidentale.</p><h2>L\'area archeologica</h2><p>L\'<strong>area archeologica di Locri</strong> (ingresso libero) si estende su 1.500 ettari tra ulivi e mare. I principali monumenti visibili sono: il <strong>Tempio di Marasà</strong> (Afrodite, VI sec. a.C.), il <strong>Teatro greco-romano</strong>, le mura di cinta e le necropoli. La passeggiata tra le rovine al tramonto, con il Mar Ionio sullo sfondo, è un\'esperienza indimenticabile.</p><h2>Il Museo Nazionale di Locri</h2><p>Il museo conserva i <strong>pinakes</strong> — tavolette votive in terracotta dipinta offerte a Persefone, patrona di Locri. Sono tra i documenti iconografici più importanti della Magna Grecia. La collezione include anche monete, ceramiche e reperti scultorei di straordinaria qualità.</p><p><strong>Come arrivare:</strong> 40 km da Reggio Calabria (45 min) lungo la SS106 jonica. Museo: martedì–domenica 9:00–19:00.</p>',
            ],

            // 13. BERGAMOTTO DOP
            [
                'post_type' => 'guide', 'category' => 'gastronomia',
                'color_from' => '#1A4A1A', 'color_to' => '#4CAF50',
                'image_url' => 'https://images.unsplash.com/photo-1592421901588-7b5c3c76c2af?w=1200&q=80',
                'og_image' => 'https://images.unsplash.com/photo-1592421901588-7b5c3c76c2af?w=1200&q=80',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(20), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => 'Bergamotto di Reggio Calabria: l\'oro verde che profuma il mondo',
                'title_en' => 'Bergamot of Reggio Calabria: the Green Gold that Perfumes the World',
                'excerpt_it' => "Il bergamotto cresce solo in una fascia di 100 km nel reggino. È nell'Earl Grey, nel Chanel N°5 e nelle migliori profumerie del mondo. Come riconoscerlo, dove acquistarlo e come si usa in cucina.",
                'excerpt_en' => 'Bergamot grows only in a 100 km strip near Reggio Calabria. It\'s in Earl Grey tea, Chanel N°5 and the world\'s finest perfumes.',
                'seo_title_it' => 'Bergamotto Reggio Calabria DOP — storia, usi e dove comprarlo',
                'seo_description_it' => "Il bergamotto DOP di Reggio Calabria: l'agrume unico al mondo usato in profumeria e gastronomia. Storia, usi e dove acquistarlo direttamente dai produttori.",
                'focus_keyword' => 'bergamotto Reggio Calabria DOP',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="https://images.unsplash.com/photo-1592421901588-7b5c3c76c2af?w=1200&q=80" alt="Bergamotti freschi sul ramo con foglie verdi" style="width:100%;height:400px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Il bergamotto — l\'agrume che cresce solo nella fascia reggina</figcaption></figure><h2>Un agrume unico al mondo</h2><p>Il <strong>bergamotto (Citrus bergamia)</strong> è un ibrido di limone e arancio amaro che cresce esclusivamente in una fascia costiera di circa 100 chilometri tra Villa San Giovanni e Locri, nella provincia di Reggio Calabria. Il microclima unico dello Stretto di Messina — caldo d\'estate, mai gelido d\'inverno — è l\'unico luogo al mondo in cui la pianta produce olio di qualità sufficiente per l\'industria profumiera.</p><h2>Il profumo del mondo</h2><p>Il <strong>Chanel N°5</strong>, l\'Aqua di Parma, il 4711 e centinaia di altri profumi iconici contengono olio essenziale di bergamotto reggino. La quasi totalità della produzione mondiale di olio di bergamotto di qualità proviene da questa striscia di terra calabrese. Allo stesso modo, il <strong>tè Earl Grey</strong> deve il suo aroma inconfondibile alla bergamottina, un derivato dell\'olio essenziale.</p><h2>Il bergamotto in cucina</h2><p>Oltre alla profumeria, il bergamotto ha conquistato la gastronomia di qualità. A Reggio Calabria si trova in: <strong>marmellata di bergamotto</strong> (colazione d\'eccellenza), <strong>granita al bergamotto</strong>, <strong>liquore di bergamotto</strong>, cioccolato fondente aromatizzato, pasta fresca al bergamotto con gamberi rossi. Molti ristoranti del centro propongono menu a tema bergamotto.</p><h2>Dove acquistarlo</h2><p>I migliori acquisti si fanno direttamente dai produttori o al <strong>mercato del Corso Garibaldi</strong>. La <strong>Fiera del Bergamotto</strong> si tiene a febbraio-marzo durante la raccolta. Online: Consorzio del Bergamotto di Reggio Calabria (bergamottoreggino.it).</p>',
            ],

            // 14. GERACE — BORGO MEDIEVALE
            [
                'post_type' => 'guide', 'category' => 'borghi',
                'color_from' => '#4A2C0A', 'color_to' => '#8B5E3C',
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80',
                'og_image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80',
                'is_published' => true, 'is_featured' => false,
                'published_at' => now()->subDays(22), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => 'Gerace: il borgo medievale più bello della Calabria',
                'title_en' => 'Gerace: the Most Beautiful Medieval Village in Calabria',
                'excerpt_it' => "Aggrappato a uno sperone di roccia a 500 metri sul Mar Ionio, Gerace conserva intatto il suo centro medievale normanno-svevo con la cattedrale romanica più grande della Calabria.",
                'excerpt_en' => 'Perched on a rocky spur 500 metres above the Ionian Sea, Gerace preserves its intact Norman-Swabian medieval centre with the largest Romanesque cathedral in Calabria.',
                'seo_title_it' => 'Gerace borgo medievale Calabria — cattedrale e cosa vedere',
                'seo_description_it' => "Guida a Gerace: borgo medievale con la cattedrale romanica più grande della Calabria. A 45 minuti da Reggio Calabria. Storia, arte e panorami sul Mar Ionio.",
                'focus_keyword' => 'Gerace borgo medievale Calabria',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80" alt="Borgo medievale su roccia con vista sul mare" style="width:100%;height:440px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Gerace — incoronato tra i Borghi più Belli d\'Italia</figcaption></figure><h2>La fortezza sul dirupo</h2><p>Gerace è costruita su uno sperone di roccia gneissica a 475 metri sul livello del mare, con il Mar Ionio visibile in ogni direzione. Inserita tra i <strong>Borghi più Belli d\'Italia</strong>, deve la sua fondazione ai profughi di Locri Epizefiri che, nel IX secolo, fuggirono dalle incursioni saracene cercando rifugio sull\'imprendibile altura.</p><h2>La Cattedrale — la più grande della Calabria</h2><p>La <strong>Cattedrale di Santa Maria Assunta</strong> (1045) è il monumento più importante di Gerace e la cattedrale romanica più grande della Calabria. La facciata sobria nasconde un interno a tre navate di straordinaria bellezza: 26 colonne di marmo e granito provenienti dall\'antica Locri Epizefiri sostengono archi a tutto sesto. La cripta conserva reperti paleocristiani e normanni.</p><h2>Il castello normanno e i vicoli</h2><p>Il <strong>castello normanno</strong> alla sommità del borgo offre il panorama più vasto: nelle giornate limpide si vedono contemporaneamente lo Stretto di Messina, l\'Etna e le Isole Eolie. I vicoli del centro storico — acciottolati, silenziosi, costellati di chiese medievali — sono tra i meglio conservati del Mezzogiorno.</p><p><strong>Come arrivare:</strong> 45 km da Reggio Calabria (50 min). Da combinare con Locri Epizefiri (15 km a valle).</p>',
            ],

            // 15. STRETTO DI MESSINA — TURISMO ESPERIENZIALE
            [
                'post_type' => 'guide', 'category' => 'esperienze',
                'color_from' => '#003366', 'color_to' => '#0077B6',
                'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?w=1200&q=80',
                'og_image' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?w=1200&q=80',
                'is_published' => true, 'is_featured' => true,
                'published_at' => now()->subDays(25), 'author' => 'Redazione CalabriaGate', 'reading_time' => 5,
                'title_it' => 'Lo Stretto di Messina: tra due mari, due regioni e un\'emozione unica',
                'title_en' => 'The Strait of Messina: Between Two Seas, Two Regions and a Unique Experience',
                'excerpt_it' => "3 km d'acqua tra Calabria e Sicilia, tra Scilla e Cariddi della mitologia omerica. Il pesce spada pescato con le lance, le correnti che cambiano colore ogni ora e il traghetto più emozionante d'Italia.",
                'excerpt_en' => '3 km of water between Calabria and Sicily, between Homer\'s Scylla and Charybdis. Swordfish hunted with lances, ever-changing currents and Italy\'s most thrilling ferry crossing.',
                'seo_title_it' => 'Stretto di Messina turismo — Scilla, pesce spada e traghetto',
                'seo_description_it' => "Scopri lo Stretto di Messina: la pesca del pesce spada con le lance, Scilla e Cariddi, il traghetto Reggio–Messina. Esperienze uniche a partire dall'aeroporto REG.",
                'focus_keyword' => 'Stretto di Messina turismo esperienziale',
                'body_it' => '<figure style="margin:0 0 2rem;border-radius:12px;overflow:hidden;"><img src="https://images.unsplash.com/photo-1599940824399-b87987ceb72a?w=1200&q=80" alt="Vista sul mare blu con montagna sullo sfondo al tramonto" style="width:100%;height:440px;object-fit:cover;"><figcaption style="background:#f8f9fa;padding:0.6rem 1rem;font-size:0.85rem;color:#64748b;">Lo Stretto di Messina — 3 km che separano e uniscono due mondi</figcaption></figure><h2>Il mare più stretto d\'Europa</h2><p>Lo <strong>Stretto di Messina</strong> è largo solo 3,2 chilometri nel punto più ristretto, tra Punta Pezzo (Calabria) e Torre Faro (Sicilia). Due mari si scontrano qui: il Tirreno a nord e lo Ionio a sud. Le correnti cambiano direzione 4 volte al giorno, creando vortici e risucchi che Omero descrisse come Scilla e Cariddi nell\'Odissea.</p><h2>La pesca del pesce spada con le lance</h2><p>Da giugno ad agosto, barche con un\'altissima "antenna" verticale e una passerella orizzontale di 30 metri scivolano lentamente sullo Stretto: i <strong>felucconi</strong> usano la stessa tecnica da tremila anni. Un lanciere appostato sull\'antenna segnala i pesci spada, un altro li cattura con una lancia. Vedere questa pesca all\'alba è un\'esperienza antropologica irripetibile. Alcune escursioni turistiche permettono di salire a bordo.</p><h2>Il traghetto Reggio–Messina</h2><p>Attraversare lo Stretto in traghetto è un\'esperienza in sé: 20 minuti, acque agitate dalle correnti, Etna e Aspromonte visibili contemporaneamente. Il porto di Reggio è a 5 minuti dal centro città.</p><h2>Birdwatching sullo Stretto</h2><p>Lo Stretto è uno dei corridoi migratori più importanti d\'Europa: 300 specie di uccelli lo attraversano in primavera e autunno. Falchi, cicogne, rondini, gruccioni e rapaci di ogni tipo: per i birdwatcher è un luogo leggendario.</p>',
            ],
        ];
    }
}
