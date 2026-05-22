<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tourism_articles', function (Blueprint $table) {
            if (!Schema::hasColumn('tourism_articles', 'image_url')) {
                $table->string('image_url')->nullable()->after('color_to');
            }
            if (!Schema::hasColumn('tourism_articles', 'seo_title_it')) {
                $table->string('seo_title_it', 70)->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'seo_title_en')) {
                $table->string('seo_title_en', 70)->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'seo_description_it')) {
                $table->string('seo_description_it', 165)->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'seo_description_en')) {
                $table->string('seo_description_en', 165)->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'focus_keyword')) {
                $table->string('focus_keyword', 100)->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'og_image')) {
                $table->string('og_image')->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'canonical_url')) {
                $table->string('canonical_url')->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'robots')) {
                $table->string('robots', 30)->default('index');
            }
            if (!Schema::hasColumn('tourism_articles', 'author')) {
                $table->string('author', 100)->nullable();
            }
            if (!Schema::hasColumn('tourism_articles', 'reading_time')) {
                $table->unsignedTinyInteger('reading_time')->nullable()
                      ->comment('Minuti stimati di lettura');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tourism_articles', function (Blueprint $table) {
            $columns = ['image_url', 'seo_title_it', 'seo_title_en',
                        'seo_description_it', 'seo_description_en',
                        'focus_keyword', 'og_image', 'canonical_url', 'robots',
                        'author', 'reading_time'];
            $existing = array_filter($columns, fn($c) => Schema::hasColumn('tourism_articles', $c));
            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
