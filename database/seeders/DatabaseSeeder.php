<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,         // utente admin Filament
            DestinationSeeder::class,       // destinazioni aeroporto
            TourismArticleSeeder::class,    // articoli turismo Calabria
            FlightScheduleSeeder::class,    // orari stagionali voli REG
        ]);
    }
}
