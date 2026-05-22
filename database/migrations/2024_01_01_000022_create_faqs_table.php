<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category', 60)->default('generale');
            $table->string('question_it');
            $table->string('question_en')->nullable();
            $table->string('question_de')->nullable();
            $table->string('question_fr')->nullable();
            $table->text('answer_it');
            $table->text('answer_en')->nullable();
            $table->text('answer_de')->nullable();
            $table->text('answer_fr')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('faqs')->insert([
            [
                'category'    => 'voli',
                'question_it' => 'Come arrivo all\'aeroporto di Reggio Calabria?',
                'question_en' => 'How do I get to Reggio Calabria Airport?',
                'answer_it'   => 'L\'Aeroporto dello Stretto si trova a Ravagnese, a circa 5 km dal centro di Reggio Calabria. È raggiungibile in taxi, con bus di linea o in auto tramite la SS106.',
                'answer_en'   => 'Reggio Calabria Strait Airport is located in Ravagnese, about 5 km from the city center. It can be reached by taxi, local bus, or by car via the SS106.',
                'sort_order'  => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'category'    => 'voli',
                'question_it' => 'Quali compagnie aeree operano su Reggio Calabria?',
                'question_en' => 'Which airlines operate at Reggio Calabria?',
                'answer_it'   => 'L\'aeroporto è servito principalmente da ITA Airways con voli per Roma Fiumicino e Milano Linate. Consultare la sezione Voli per gli orari aggiornati.',
                'answer_en'   => 'The airport is mainly served by ITA Airways with flights to Rome Fiumicino and Milan Linate. Check the Flights section for updated schedules.',
                'sort_order'  => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'category'    => 'turismo',
                'question_it' => 'Cosa vedere a Reggio Calabria?',
                'question_en' => 'What to see in Reggio Calabria?',
                'answer_it'   => 'Assolutamente da visitare sono i Bronzi di Riace al Museo Nazionale della Magna Grecia, il Lungomare Falcomatà (considerato uno dei più belli d\'Italia), e il Castello Aragonese.',
                'answer_en'   => 'Must-sees include the Riace Bronzes at the National Museum of Magna Graecia, the Falcomatà Waterfront (considered one of the most beautiful in Italy), and the Aragonese Castle.',
                'sort_order'  => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'category'    => 'turismo',
                'question_it' => 'Quando è il periodo migliore per visitare la Calabria?',
                'question_en' => 'When is the best time to visit Calabria?',
                'answer_it'   => 'La primavera (aprile-giugno) e l\'inizio dell\'autunno (settembre-ottobre) offrono il miglior equilibrio tra clima, folla e prezzi. L\'estate è ideale per il mare.',
                'answer_en'   => 'Spring (April-June) and early autumn (September-October) offer the best balance of weather, crowds, and prices. Summer is ideal for the sea.',
                'sort_order'  => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'category'    => 'generale',
                'question_it' => 'Il sito è ufficiale dell\'aeroporto?',
                'question_en' => 'Is this the official airport website?',
                'answer_it'   => 'Questo è un portale turistico indipendente dedicato ai viaggiatori in arrivo e in partenza da Reggio Calabria. Per informazioni ufficiali sull\'aeroporto consultare il sito SACAL.',
                'answer_en'   => 'This is an independent tourism portal dedicated to travelers arriving and departing from Reggio Calabria. For official airport information, visit the SACAL website.',
                'sort_order'  => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
