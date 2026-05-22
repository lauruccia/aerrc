<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_schedules', function (Blueprint $table) {
            $table->id();

            // Dati volo
            $table->string('flight_number', 10);   // es. FR1234
            $table->string('airline_name', 60);     // es. Ryanair
            $table->string('airline_iata', 3);      // es. FR

            // Direzione: partenza o arrivo rispetto a REG
            $table->enum('type', ['departure', 'arrival']);

            // Aeroporto remoto (destinazione o provenienza)
            $table->string('airport_iata', 4);      // es. MXP
            $table->string('airport_name', 80);     // es. Milano Malpensa

            // Orario programmato (solo HH:MM, il giorno lo calcoliamo noi)
            $table->time('scheduled_time');

            // Giorni della settimana: array ISO [1=Lun … 7=Dom]
            // es. [1,3,5] = Lunedì, Mercoledì, Venerdì
            $table->json('days_of_week');

            // Validità stagionale
            $table->date('valid_from');
            $table->date('valid_to');

            // Info aggiuntive
            $table->string('terminal', 5)->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indici utili per le query di oggi
            $table->index(['type', 'is_active', 'valid_from', 'valid_to']);
            $table->index('flight_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_schedules');
    }
};
