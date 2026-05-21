<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('country')->nullable();
            $table->string('iata_code', 3)->nullable()->index();
            $table->string('flag_emoji', 10)->nullable();
            $table->string('slug')->unique();
            $table->decimal('price_from', 8, 2)->default(0);
            $table->string('color_from', 20)->default('#1A5276');
            $table->string('color_to',   20)->default('#2E86C1');
            $table->string('airlines_string')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            // Descrizioni multilingua
            $table->text('description_it')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->text('description_fr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
