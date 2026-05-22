<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            if (!Schema::hasColumn('destinations', 'flight_duration')) {
                $table->string('flight_duration', 20)->nullable()->after('airlines_string');
            }
            if (!Schema::hasColumn('destinations', 'highlights_it')) {
                $table->text('highlights_it')->nullable()->after('description_en');
            }
            if (!Schema::hasColumn('destinations', 'hotel_link')) {
                $table->string('hotel_link')->nullable()->after('highlights_it');
            }
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['flight_duration', 'highlights_it', 'hotel_link']);
        });
    }
};
