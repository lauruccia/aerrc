<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'city'           => 'Milano Malpensa',
                'country'        => 'Italia',
                'iata_code'      => 'MXP',
                'flag_emoji'     => '🇮🇹',
                'price_from'     => 19.99,
                'color_from'     => '#1A5276',
                'color_to'       => '#2E86C1',
                'airlines_string'=> 'Ryanair',
                'description_it' => 'Vola direttamente da Reggio Calabria a Milano Malpensa con Ryanair.',
                'description_en' => 'Fly directly from Reggio Calabria to Milan Malpensa with Ryanair.',
                'sort_order'     => 1,
            ],
            [
                'city'           => 'Roma Fiumicino',
                'country'        => 'Italia',
                'iata_code'      => 'FCO',
                'flag_emoji'     => '🇮🇹',
                'price_from'     => 24.99,
                'color_from'     => '#7D3C98',
                'color_to'       => '#A569BD',
                'airlines_string'=> 'ITA Airways',
                'description_it' => 'Collegamento diretto con la capitale italiana via ITA Airways.',
                'description_en' => 'Direct connection to the Italian capital via ITA Airways.',
                'sort_order'     => 2,
            ],
            [
                'city'           => 'Londra Stansted',
                'country'        => 'Gran Bretagna',
                'iata_code'      => 'STN',
                'flag_emoji'     => '🇬🇧',
                'price_from'     => 34.99,
                'color_from'     => '#1A5276',
                'color_to'       => '#0D2B4B',
                'airlines_string'=> 'Ryanair',
                'description_it' => 'Vola a Londra Stansted con Ryanair. Frequenti partenze da Reggio Calabria.',
                'description_en' => 'Fly to London Stansted with Ryanair. Frequent departures from Reggio Calabria.',
                'sort_order'     => 3,
            ],
            [
                'city'           => 'Barcellona El Prat',
                'country'        => 'Spagna',
                'iata_code'      => 'BCN',
                'flag_emoji'     => '🇪🇸',
                'price_from'     => 29.99,
                'color_from'     => '#C0392B',
                'color_to'       => '#E74C3C',
                'airlines_string'=> 'Ryanair',
                'description_it' => 'Barcellona raggiungibile direttamente da REG.',
                'description_en' => 'Barcelona reachable directly from REG.',
                'sort_order'     => 4,
            ],
            [
                'city'           => 'Berlino Brandenburg',
                'country'        => 'Germania',
                'iata_code'      => 'BER',
                'flag_emoji'     => '🇩🇪',
                'price_from'     => 39.99,
                'color_from'     => '#1C2833',
                'color_to'       => '#2C3E50',
                'airlines_string'=> 'Ryanair',
                'description_it' => 'Collegamento diretto Reggio Calabria — Berlino.',
                'description_de' => 'Direktverbindung Reggio Calabria — Berlin.',
                'sort_order'     => 5,
            ],
            [
                'city'           => 'Parigi Beauvais',
                'country'        => 'Francia',
                'iata_code'      => 'BVA',
                'flag_emoji'     => '🇫🇷',
                'price_from'     => 32.99,
                'color_from'     => '#1A3A5C',
                'color_to'       => '#2471A3',
                'airlines_string'=> 'Ryanair',
                'description_it' => 'Raggiungete Parigi da Reggio Calabria con Ryanair.',
                'description_fr' => 'Rejoignez Paris depuis Reggio Calabria avec Ryanair.',
                'sort_order'     => 6,
            ],
            [
                'city'           => 'Bologna',
                'country'        => 'Italia',
                'iata_code'      => 'BLQ',
                'flag_emoji'     => '🇮🇹',
                'price_from'     => 22.99,
                'color_from'     => '#7E5109',
                'color_to'       => '#D4AC0D',
                'airlines_string'=> 'Ryanair',
                'sort_order'     => 7,
            ],
            [
                'city'           => 'Torino',
                'country'        => 'Italia',
                'iata_code'      => 'TRN',
                'flag_emoji'     => '🇮🇹',
                'price_from'     => 21.99,
                'color_from'     => '#1F618D',
                'color_to'       => '#2980B9',
                'airlines_string'=> 'Ryanair',
                'sort_order'     => 8,
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(['iata_code' => $dest['iata_code']], $dest);
        }

        $this->command->info('✅ Destinazioni inserite: ' . count($destinations));
    }
}
