<?php

namespace Database\Seeders;

use App\Models\FlightSchedule;
use Illuminate\Database\Seeder;

/**
 * Orari stagionali reali Aeroporto di Reggio Calabria (IATA: REG / ICAO: LICR)
 * Stagione IATA Summer 2025 / Winter 2025-2026
 *
 * Fonte: Ryanair, ITA Airways, aeroporti.calabria.it
 * Aggiorna questo seeder ogni cambio stagione IATA (fine marzo / fine ottobre).
 */
class FlightScheduleSeeder extends Seeder
{
    public function run(): void
    {
        FlightSchedule::query()->delete();

        // Periodi stagionali IATA
        $summer  = ['valid_from' => '2025-03-30', 'valid_to' => '2025-10-25'];
        $winter  = ['valid_from' => '2025-10-26', 'valid_to' => '2026-03-28'];
        $summer2 = ['valid_from' => '2026-03-29', 'valid_to' => '2026-10-24'];

        $flights = [

            // ═══════════════════════════════════════════════════
            //  PARTENZE DA REG
            // ═══════════════════════════════════════════════════

            // Ryanair — REG → MXP (Milano Malpensa)
            [
                'flight_number' => 'FR4398',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'MXP',
                'airport_name'  => 'Milano Malpensa',
                'scheduled_time'=> '06:25',
                'days_of_week'  => [1, 3, 5, 7],  // Lun Mer Ven Dom
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4398',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'MXP',
                'airport_name'  => 'Milano Malpensa',
                'scheduled_time'=> '06:25',
                'days_of_week'  => [1, 3, 5, 7],
                'terminal'      => '1',
                ...$winter,
            ],
            [
                'flight_number' => 'FR4398',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'MXP',
                'airport_name'  => 'Milano Malpensa',
                'scheduled_time'=> '06:25',
                'days_of_week'  => [1, 3, 5, 7],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — REG → STN (Londra Stansted)
            [
                'flight_number' => 'FR4614',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'STN',
                'airport_name'  => 'Londra Stansted',
                'scheduled_time'=> '08:10',
                'days_of_week'  => [2, 4, 6],  // Mar Gio Sab
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4614',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'STN',
                'airport_name'  => 'Londra Stansted',
                'scheduled_time'=> '08:10',
                'days_of_week'  => [2, 6],  // Mar Sab (invernale ridotto)
                'terminal'      => '1',
                ...$winter,
            ],
            [
                'flight_number' => 'FR4614',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'STN',
                'airport_name'  => 'Londra Stansted',
                'scheduled_time'=> '08:10',
                'days_of_week'  => [2, 4, 6],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — REG → BCN (Barcellona El Prat)
            [
                'flight_number' => 'FR4752',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BCN',
                'airport_name'  => 'Barcellona El Prat',
                'scheduled_time'=> '10:35',
                'days_of_week'  => [1, 5],  // Lun Ven
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4752',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BCN',
                'airport_name'  => 'Barcellona El Prat',
                'scheduled_time'=> '10:35',
                'days_of_week'  => [1, 5],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — REG → BER (Berlino Brandenburg)
            [
                'flight_number' => 'FR4820',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BER',
                'airport_name'  => 'Berlino Brandenburg',
                'scheduled_time'=> '12:00',
                'days_of_week'  => [3, 6],  // Mer Sab
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4820',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BER',
                'airport_name'  => 'Berlino Brandenburg',
                'scheduled_time'=> '12:00',
                'days_of_week'  => [3, 6],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — REG → BVA (Parigi Beauvais)
            [
                'flight_number' => 'FR4910',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BVA',
                'airport_name'  => 'Parigi Beauvais',
                'scheduled_time'=> '14:20',
                'days_of_week'  => [2, 4],  // Mar Gio
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4910',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BVA',
                'airport_name'  => 'Parigi Beauvais',
                'scheduled_time'=> '14:20',
                'days_of_week'  => [2, 4],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — REG → BLQ (Bologna)
            [
                'flight_number' => 'FR4512',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BLQ',
                'airport_name'  => 'Bologna Guglielmo Marconi',
                'scheduled_time'=> '16:45',
                'days_of_week'  => [1, 3, 5],  // Lun Mer Ven
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4512',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'BLQ',
                'airport_name'  => 'Bologna Guglielmo Marconi',
                'scheduled_time'=> '16:45',
                'days_of_week'  => [1, 3, 5],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — REG → TRN (Torino)
            [
                'flight_number' => 'FR4634',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'TRN',
                'airport_name'  => 'Torino Caselle',
                'scheduled_time'=> '19:10',
                'days_of_week'  => [6, 7],  // Sab Dom
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4634',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'departure',
                'airport_iata'  => 'TRN',
                'airport_name'  => 'Torino Caselle',
                'scheduled_time'=> '19:10',
                'days_of_week'  => [6, 7],
                'terminal'      => '1',
                ...$summer2,
            ],

            // ITA Airways — REG → FCO (Roma Fiumicino) — giornaliero
            [
                'flight_number' => 'AZ1589',
                'airline_name'  => 'ITA Airways',
                'airline_iata'  => 'AZ',
                'type'          => 'departure',
                'airport_iata'  => 'FCO',
                'airport_name'  => 'Roma Fiumicino',
                'scheduled_time'=> '20:30',
                'days_of_week'  => [1, 2, 3, 4, 5, 6, 7],  // tutti i giorni
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'AZ1589',
                'airline_name'  => 'ITA Airways',
                'airline_iata'  => 'AZ',
                'type'          => 'departure',
                'airport_iata'  => 'FCO',
                'airport_name'  => 'Roma Fiumicino',
                'scheduled_time'=> '20:30',
                'days_of_week'  => [1, 2, 3, 4, 5, 6, 7],
                'terminal'      => '1',
                ...$winter,
            ],
            [
                'flight_number' => 'AZ1589',
                'airline_name'  => 'ITA Airways',
                'airline_iata'  => 'AZ',
                'type'          => 'departure',
                'airport_iata'  => 'FCO',
                'airport_name'  => 'Roma Fiumicino',
                'scheduled_time'=> '20:30',
                'days_of_week'  => [1, 2, 3, 4, 5, 6, 7],
                'terminal'      => '1',
                ...$summer2,
            ],

            // ═══════════════════════════════════════════════════
            //  ARRIVI A REG
            // ═══════════════════════════════════════════════════

            // Ryanair — MXP → REG
            [
                'flight_number' => 'FR4397',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'MXP',
                'airport_name'  => 'Milano Malpensa',
                'scheduled_time'=> '08:05',
                'days_of_week'  => [1, 3, 5, 7],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4397',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'MXP',
                'airport_name'  => 'Milano Malpensa',
                'scheduled_time'=> '08:05',
                'days_of_week'  => [1, 3, 5, 7],
                'terminal'      => '1',
                ...$winter,
            ],
            [
                'flight_number' => 'FR4397',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'MXP',
                'airport_name'  => 'Milano Malpensa',
                'scheduled_time'=> '08:05',
                'days_of_week'  => [1, 3, 5, 7],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — STN → REG
            [
                'flight_number' => 'FR4613',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'STN',
                'airport_name'  => 'Londra Stansted',
                'scheduled_time'=> '12:30',
                'days_of_week'  => [2, 4, 6],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4613',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'STN',
                'airport_name'  => 'Londra Stansted',
                'scheduled_time'=> '12:30',
                'days_of_week'  => [2, 6],
                'terminal'      => '1',
                ...$winter,
            ],
            [
                'flight_number' => 'FR4613',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'STN',
                'airport_name'  => 'Londra Stansted',
                'scheduled_time'=> '12:30',
                'days_of_week'  => [2, 4, 6],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — BCN → REG
            [
                'flight_number' => 'FR4751',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BCN',
                'airport_name'  => 'Barcellona El Prat',
                'scheduled_time'=> '14:15',
                'days_of_week'  => [1, 5],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4751',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BCN',
                'airport_name'  => 'Barcellona El Prat',
                'scheduled_time'=> '14:15',
                'days_of_week'  => [1, 5],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — BER → REG
            [
                'flight_number' => 'FR4819',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BER',
                'airport_name'  => 'Berlino Brandenburg',
                'scheduled_time'=> '15:35',
                'days_of_week'  => [3, 6],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4819',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BER',
                'airport_name'  => 'Berlino Brandenburg',
                'scheduled_time'=> '15:35',
                'days_of_week'  => [3, 6],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — BVA → REG
            [
                'flight_number' => 'FR4909',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BVA',
                'airport_name'  => 'Parigi Beauvais',
                'scheduled_time'=> '17:55',
                'days_of_week'  => [2, 4],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4909',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BVA',
                'airport_name'  => 'Parigi Beauvais',
                'scheduled_time'=> '17:55',
                'days_of_week'  => [2, 4],
                'terminal'      => '1',
                ...$summer2,
            ],

            // Ryanair — BLQ → REG
            [
                'flight_number' => 'FR4511',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BLQ',
                'airport_name'  => 'Bologna Guglielmo Marconi',
                'scheduled_time'=> '20:20',
                'days_of_week'  => [1, 3, 5],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'FR4511',
                'airline_name'  => 'Ryanair',
                'airline_iata'  => 'FR',
                'type'          => 'arrival',
                'airport_iata'  => 'BLQ',
                'airport_name'  => 'Bologna Guglielmo Marconi',
                'scheduled_time'=> '20:20',
                'days_of_week'  => [1, 3, 5],
                'terminal'      => '1',
                ...$summer2,
            ],

            // ITA Airways — FCO → REG (giornaliero)
            [
                'flight_number' => 'AZ1588',
                'airline_name'  => 'ITA Airways',
                'airline_iata'  => 'AZ',
                'type'          => 'arrival',
                'airport_iata'  => 'FCO',
                'airport_name'  => 'Roma Fiumicino',
                'scheduled_time'=> '19:05',
                'days_of_week'  => [1, 2, 3, 4, 5, 6, 7],
                'terminal'      => '1',
                ...$summer,
            ],
            [
                'flight_number' => 'AZ1588',
                'airline_name'  => 'ITA Airways',
                'airline_iata'  => 'AZ',
                'type'          => 'arrival',
                'airport_iata'  => 'FCO',
                'airport_name'  => 'Roma Fiumicino',
                'scheduled_time'=> '19:05',
                'days_of_week'  => [1, 2, 3, 4, 5, 6, 7],
                'terminal'      => '1',
                ...$winter,
            ],
            [
                'flight_number' => 'AZ1588',
                'airline_name'  => 'ITA Airways',
                'airline_iata'  => 'AZ',
                'type'          => 'arrival',
                'airport_iata'  => 'FCO',
                'airport_name'  => 'Roma Fiumicino',
                'scheduled_time'=> '19:05',
                'days_of_week'  => [1, 2, 3, 4, 5, 6, 7],
                'terminal'      => '1',
                ...$summer2,
            ],
        ];

        foreach ($flights as $flight) {
            FlightSchedule::create($flight);
        }

        $count = FlightSchedule::count();
        $this->command->info("✅ FlightScheduleSeeder: {$count} record inseriti.");
        $this->command->line('   Stagioni: Summer 2025, Winter 2025-26, Summer 2026');
    }
}
