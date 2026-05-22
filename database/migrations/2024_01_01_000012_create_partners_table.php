<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('contact_email')->nullable();

            // Tipologia e visibilità
            $table->enum('category', [
                'airline',        // Compagnia aerea
                'hotel',          // Hotel / struttura ricettiva
                'tour_operator',  // Tour operator / agenzia
                'institution',    // Ente pubblico (Comune, Regione)
                'media',          // Media partner
                'service',        // Servizi aeroportuali
                'other',
            ])->default('other');

            $table->enum('tier', ['gold', 'silver', 'bronze', 'standard'])->default('standard')
                  ->comment('Livello partnership commerciale');

            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured_homepage')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);

            // Descrizioni multilingua
            $table->text('description_it')->nullable();
            $table->text('description_en')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
