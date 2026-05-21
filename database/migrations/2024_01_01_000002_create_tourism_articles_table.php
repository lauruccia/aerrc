<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tourism_articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category')->default('natura')->index();
            $table->string('color_from', 20)->default('#0D2B4B');
            $table->string('color_to',   20)->default('#1A5276');
            $table->boolean('is_published')->default(false)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            // Titoli multilingua
            $table->string('title_it');
            $table->string('title_en')->nullable();
            $table->string('title_de')->nullable();
            $table->string('title_fr')->nullable();
            // Excerpt multilingua
            $table->text('excerpt_it')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_de')->nullable();
            $table->text('excerpt_fr')->nullable();
            // Body multilingua
            $table->longText('body_it')->nullable();
            $table->longText('body_en')->nullable();
            $table->longText('body_de')->nullable();
            $table->longText('body_fr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_articles');
    }
};
