<?php

namespace Database\Seeders;

use App\Models\TourismArticle;
use Illuminate\Database\Seeder;

class TourismArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'category'    => 'mare',
                'color_from'  => '#0D6EFD',
                'color_to'    => '#0DCAF0',
                'is_published'=> true,
                'is_featured' => true,
                'published_at'=> now(),
                'title_it'    => 'Le spiagge più belle della Costa Viola',
                'title_en'    => 'The Most Beautiful Beaches of the Costa Viola',
                'title_de'    => 'Die schönsten Strände der Costa Viola',
                'title_fr'    => 'Les plus belles plages de la Costa Viola',
                'excerpt_it'  => 'Acque cristalline e tramonti mozzafiato: la Costa Viola è uno dei tesori nascosti del Mediterraneo.',
                'excerpt_en'  => 'Crystal-clear waters and breathtaking sunsets: the Costa Viola is one of the Mediterranean\'s hidden treasures.',
                'excerpt_de'  => 'Kristallklares Wasser und atemberaubende Sonnenuntergänge: die Costa Viola ist ein verborgenes Juwel.',
                'excerpt_fr'  => 'Eaux cristallines et couchers de soleil à couper le souffle : la Costa Viola est un trésor caché.',
                'body_it'     => '<p>La Costa Viola si estende tra Palmi e Bagnara Calabra, offrendo circa 30 km di litorale con acque tra le più limpide del Mediterraneo...</p>',
            ],
            [
                'category'    => 'storia',
                'color_from'  => '#6C2D0E',
                'color_to'    => '#A04000',
                'is_published'=> true,
                'is_featured' => true,
                'published_at'=> now()->subDays(2),
                'title_it'    => 'Il Museo Nazionale della Magna Grecia',
                'title_en'    => 'The National Museum of Magna Graecia',
                'title_de'    => 'Das Nationalmuseum von Magna Graecia',
                'title_fr'    => 'Le Musée National de la Grande Grèce',
                'excerpt_it'  => 'I Bronzi di Riace e millenni di storia greca e romana nel cuore di Reggio Calabria.',
                'excerpt_en'  => 'The Riace Bronzes and millennia of Greek and Roman history in the heart of Reggio Calabria.',
                'excerpt_de'  => 'Die Bronzestatuen von Riace und Jahrtausende griechischer und römischer Geschichte.',
                'excerpt_fr'  => 'Les Bronzes de Riace et des millénaires d\'histoire grecque et romaine.',
                'body_it'     => '<p>Il Museo Nazionale della Magna Grecia conserva i famosi Bronzi di Riace, due statue greche del V secolo a.C....</p>',
            ],
            [
                'category'    => 'gastronomia',
                'color_from'  => '#7E5109',
                'color_to'    => '#D4AC0D',
                'is_published'=> true,
                'is_featured' => false,
                'published_at'=> now()->subDays(5),
                'title_it'    => 'La cucina calabrese: sapori autentici del Sud',
                'title_en'    => 'Calabrian Cuisine: Authentic Flavours of the South',
                'title_de'    => 'Kalabrische Küche: authentische Aromen des Südens',
                'title_fr'    => 'La cuisine calabraise : saveurs authentiques du Sud',
                'excerpt_it'  => 'Nduja, peperoncino, bergamotto e prodotti DOP: la Calabria è un paradiso gastronomico.',
                'excerpt_en'  => 'Nduja, chilli, bergamot and DOP products: Calabria is a gastronomic paradise.',
                'excerpt_de'  => 'Nduja, Peperoncino, Bergamott und geschützte Herkunftsbezeichnungen.',
                'excerpt_fr'  => 'Nduja, piment, bergamote et produits AOP : la Calabre est un paradis gastronomique.',
                'body_it'     => '<p>La gastronomia calabrese è ricca di sapori intensi e prodotti tipici di eccellenza...</p>',
            ],
            [
                'category'    => 'borghi',
                'color_from'  => '#145A32',
                'color_to'    => '#1E8449',
                'is_published'=> true,
                'is_featured' => true,
                'published_at'=> now()->subDays(7),
                'title_it'    => 'I borghi medievali dell\'Aspromonte',
                'title_en'    => 'The Medieval Villages of Aspromonte',
                'title_de'    => 'Die mittelalterlichen Dörfer des Aspromonte',
                'title_fr'    => 'Les villages médiévaux de l\'Aspromonte',
                'excerpt_it'  => 'Pentedattilo, Gerace, Stilo: borghi sospesi nel tempo tra le montagne della Calabria.',
                'excerpt_en'  => 'Pentedattilo, Gerace, Stilo: villages frozen in time in the Calabrian mountains.',
                'excerpt_de'  => 'Pentedattilo, Gerace, Stilo: in der Zeit eingefrorene Dörfer in den kalabresischen Bergen.',
                'excerpt_fr'  => 'Pentedattilo, Gerace, Stilo : villages figés dans le temps dans les montagnes calabraises.',
                'body_it'     => '<p>L\'entroterra calabrese nasconde borghi di rara bellezza, molti dei quali classificati tra i \"Borghi più belli d\'Italia\"...</p>',
            ],
        ];

        foreach ($articles as $article) {
            TourismArticle::updateOrCreate(
                ['title_it' => $article['title_it']],
                $article
            );
        }

        $this->command->info('✅ Articoli turismo inseriti: ' . count($articles));
    }
}
