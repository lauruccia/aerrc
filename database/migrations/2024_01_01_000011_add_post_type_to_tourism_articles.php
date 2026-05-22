<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tourism_articles', function (Blueprint $table) {
            if (!Schema::hasColumn('tourism_articles', 'post_type')) {
                $table->string('post_type', 30)->default('tourism')->after('id')->index();
            }
            if (!Schema::hasColumn('tourism_articles', 'is_breaking')) {
                $table->boolean('is_breaking')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('tourism_articles', 'source')) {
                $table->string('source', 200)->nullable()
                      ->comment('Fonte notizia (es. ANSA, Comune di RC)');
            }
        });

        // Articoli senza post_type diventano 'tourism'
        DB::table('tourism_articles')
            ->whereNull('post_type')
            ->orWhere('post_type', '')
            ->update(['post_type' => 'tourism']);
    }

    public function down(): void
    {
        Schema::table('tourism_articles', function (Blueprint $table) {
            $columns = ['post_type', 'is_breaking', 'source'];
            $existing = array_filter($columns, fn($c) => Schema::hasColumn('tourism_articles', $c));
            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
