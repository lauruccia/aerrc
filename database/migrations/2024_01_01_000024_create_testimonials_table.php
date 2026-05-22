<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('testimonials');

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('author_role')->nullable()->comment('es: Turista da Milano, Viaggiatore business');
            $table->string('author_avatar')->nullable();
            $table->text('text_it');
            $table->text('text_en')->nullable();
            $table->text('text_de')->nullable();
            $table->text('text_fr')->nullable();
            $table->unsignedTinyInteger('stars')->default(5);
            $table->string('source', 40)->default('sito')->comment('sito|google|tripadvisor|facebook');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('testimonials')->insert([
            [
                'author_name' => 'Marco B.',
                'author_role' => 'Turista da Milano',
                'text_it'     => 'Finalmente un portale completo sull\'aeroporto di Reggio! Informazioni chiare sui voli e ottime guide turistiche per scoprire la Calabria.',
                'text_en'     => 'Finally a complete portal about Reggio Airport! Clear flight information and excellent tourist guides to discover Calabria.',
                'text_de'     => null,
                'text_fr'     => null,
                'stars'       => 5, 'source' => 'google', 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'author_name' => 'Giulia F.',
                'author_role' => 'Viaggiatrice frequente',
                'text_it'     => 'Uso questo sito ogni volta che devo organizzare un viaggio a Reggio. Gli orari voli sono sempre aggiornati e le destinazioni ben descritte.',
                'text_en'     => 'I use this site every time I need to organize a trip to Reggio. Flight schedules are always up to date and destinations well described.',
                'text_de'     => null,
                'text_fr'     => null,
                'stars'       => 5, 'source' => 'sito', 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'author_name' => 'Thomas K.',
                'author_role' => 'Tourist from Germany',
                'text_it'     => 'Ho scoperto la Calabria grazie a questo portale. Le guide sono dettagliate e mi hanno aiutato a pianificare un viaggio indimenticabile.',
                'text_en'     => 'I discovered Calabria thanks to this portal. The guides are detailed and helped me plan an unforgettable trip.',
                'text_de'     => 'Ich habe Kalabrien dank dieses Portals entdeckt. Die Reiseführer sind ausführlich und haben mir geholfen, eine unvergessliche Reise zu planen.',
                'text_fr'     => null,
                'stars'       => 5, 'source' => 'tripadvisor', 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
