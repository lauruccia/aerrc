<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $rows = [
            // Footer & UI
            ['key' => 'footer_tagline_it',        'value' => 'Il portale turistico ufficiale di Reggio Calabria e della Calabria. Voli, destinazioni, guide e molto altro.',  'group' => 'ui',          'label' => 'Tagline footer IT',             'type' => 'textarea'],
            ['key' => 'footer_tagline_en',        'value' => 'The official tourism portal of Reggio Calabria and Calabria. Flights, destinations, guides and much more.',      'group' => 'ui',          'label' => 'Tagline footer EN',             'type' => 'textarea'],
            ['key' => 'footer_copyright',         'value' => '© 2025 aeroportoreggiocalabria.it — Tutti i diritti riservati',                                                  'group' => 'ui',          'label' => 'Testo copyright footer',        'type' => 'text'],
            // Newsletter
            ['key' => 'newsletter_title_it',      'value' => 'Resta aggiornato',                  'group' => 'newsletter', 'label' => 'Titolo newsletter IT',     'type' => 'text'],
            ['key' => 'newsletter_title_en',      'value' => 'Stay updated',                      'group' => 'newsletter', 'label' => 'Titolo newsletter EN',     'type' => 'text'],
            ['key' => 'newsletter_desc_it',       'value' => 'Ricevi le ultime news su voli, turismo e offerte per la Calabria direttamente nella tua email.', 'group' => 'newsletter', 'label' => 'Descrizione newsletter IT', 'type' => 'textarea'],
            ['key' => 'newsletter_desc_en',       'value' => 'Get the latest news on flights, tourism and offers for Calabria directly to your inbox.',         'group' => 'newsletter', 'label' => 'Descrizione newsletter EN', 'type' => 'textarea'],
            // Hero CTA URLs
            ['key' => 'hero_cta_primary_url',     'value' => '/voli',    'group' => 'homepage', 'label' => 'URL CTA primario homepage',    'type' => 'text'],
            ['key' => 'hero_cta_secondary_url',   'value' => '/turismo', 'group' => 'homepage', 'label' => 'URL CTA secondario homepage',  'type' => 'text'],
            // Maintenance
            ['key' => 'maintenance_mode',         'value' => '0',        'group' => 'maintenance', 'label' => 'Modalità manutenzione',     'type' => 'boolean'],
            ['key' => 'maintenance_message_it',   'value' => 'Sito in manutenzione. Torneremo online a breve.', 'group' => 'maintenance', 'label' => 'Messaggio manutenzione IT', 'type' => 'textarea'],
            ['key' => 'maintenance_message_en',   'value' => 'Site under maintenance. We will be back online shortly.', 'group' => 'maintenance', 'label' => 'Messaggio manutenzione EN', 'type' => 'textarea'],
            ['key' => 'custom_head_scripts',      'value' => '',         'group' => 'maintenance', 'label' => 'Script custom <head>',       'type' => 'textarea'],
            ['key' => 'custom_body_scripts',      'value' => '',         'group' => 'maintenance', 'label' => 'Script custom </body>',       'type' => 'textarea'],
        ];

        foreach ($rows as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        // Inserisce solo se la chiave non esiste già
        foreach ($rows as $row) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $row['key']],
                $row
            );
        }
    }

    public function down(): void
    {
        $keys = [
            'footer_tagline_it', 'footer_tagline_en', 'footer_copyright',
            'newsletter_title_it', 'newsletter_title_en', 'newsletter_desc_it', 'newsletter_desc_en',
            'hero_cta_primary_url', 'hero_cta_secondary_url',
            'maintenance_mode', 'maintenance_message_it', 'maintenance_message_en',
            'custom_head_scripts', 'custom_body_scripts',
        ];
        DB::table('site_settings')->whereIn('key', $keys)->delete();
    }
};
