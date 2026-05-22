<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea l'utente amministratore per il pannello Filament.
     *
     * IMPORTANTE: Cambia email e password prima di andare in produzione.
     * Dopo il primo login, cambia la password dal pannello admin.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@aeroportoreggiocalabria.it'],
            [
                'name'     => 'Amministratore',
                'email'    => 'admin@aeroportoreggiocalabria.it',
                'password' => Hash::make('AeroportoRC_2026!'),  // ← CAMBIA IN PRODUZIONE
            ]
        );

        $this->command->info('✅ Admin creato: admin@aeroportoreggiocalabria.it');
        $this->command->warn('⚠️  Ricorda di cambiare la password dopo il primo accesso!');
    }
}
