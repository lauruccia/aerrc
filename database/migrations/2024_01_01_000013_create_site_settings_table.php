<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group', 50)->default('general')->index();
            $table->string('label', 150)->nullable();
            $table->string('type', 30)->default('text')
                  ->comment('text|textarea|boolean|color|url|number|select');
            $table->timestamps();
        });

        // Seed valori di default
        $now = now();
        DB::table('site_settings')->insert([
            // ── Homepage ──────────────────────────────────────────
            ['key' => 'hero_title',           'value' => 'Reggio Calabria.\nIl tuo portale\ndi viaggio.',  'group' => 'homepage', 'label' => 'Titolo Hero',              'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'hero_subtitle',        'value' => 'Voli, turismo e informazioni su Reggio Calabria e la Calabria — tutto in un posto.',  'group' => 'homepage', 'label' => 'Sottotitolo Hero',          'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'hero_cta_primary',     'value' => 'Consulta i Voli',   'group' => 'homepage', 'label' => 'CTA Primario (testo)',      'type' => 'text',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'hero_cta_secondary',   'value' => 'Scopri la Calabria','group' => 'homepage', 'label' => 'CTA Secondario (testo)',    'type' => 'text',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'banner_text',          'value' => '',                  'group' => 'homepage', 'label' => 'Banner avvisi (es. scioperi, novità)', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'banner_active',        'value' => '0',                 'group' => 'homepage', 'label' => 'Mostra banner',             'type' => 'boolean',  'created_at' => $now, 'updated_at' => $now],
            ['key' => 'banner_color',         'value' => '#C9A84C',           'group' => 'homepage', 'label' => 'Colore banner',             'type' => 'color',    'created_at' => $now, 'updated_at' => $now],

            // ── Contatti ──────────────────────────────────────────
            ['key' => 'contact_email',        'value' => 'info@aeroportoreggiocalabria.it', 'group' => 'contact', 'label' => 'Email principale',   'type' => 'text',  'created_at' => $now, 'updated_at' => $now],
            ['key' => 'contact_phone',        'value' => '+39 0965 640517',   'group' => 'contact', 'label' => 'Telefono',               'type' => 'text',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'contact_address',      'value' => 'Via Ravagnese, Reggio Calabria RC 89131', 'group' => 'contact', 'label' => 'Indirizzo',  'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'whatsapp_number',      'value' => '',                  'group' => 'contact', 'label' => 'Numero WhatsApp',         'type' => 'text',     'created_at' => $now, 'updated_at' => $now],

            // ── Social ────────────────────────────────────────────
            ['key' => 'social_facebook',      'value' => '',  'group' => 'social', 'label' => 'Facebook URL',   'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_instagram',     'value' => '',  'group' => 'social', 'label' => 'Instagram URL',  'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_twitter',       'value' => '',  'group' => 'social', 'label' => 'X / Twitter URL','type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_linkedin',      'value' => '',  'group' => 'social', 'label' => 'LinkedIn URL',   'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_youtube',       'value' => '',  'group' => 'social', 'label' => 'YouTube URL',    'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_tiktok',        'value' => '',  'group' => 'social', 'label' => 'TikTok URL',     'type' => 'url', 'created_at' => $now, 'updated_at' => $now],

            // ── SEO & Analytics ───────────────────────────────────
            ['key' => 'seo_site_name',        'value' => 'Aeroporto Reggio Calabria — Portale Turismo Calabria', 'group' => 'seo', 'label' => 'Nome sito (og:site_name)', 'type' => 'text',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'seo_default_desc',     'value' => 'Il portale ufficiale dell\'Aeroporto di Reggio Calabria: voli, turismo, guide sulla Calabria.', 'group' => 'seo', 'label' => 'Meta description globale', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'seo_og_image',         'value' => '',  'group' => 'seo', 'label' => 'OG Image di default (URL)',    'type' => 'url',      'created_at' => $now, 'updated_at' => $now],
            ['key' => 'ga_id',                'value' => '',  'group' => 'seo', 'label' => 'Google Analytics ID (G-XXXX)', 'type' => 'text',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'gtm_id',               'value' => '',  'group' => 'seo', 'label' => 'Google Tag Manager ID (GTM-XXXX)', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'fb_pixel_id',          'value' => '',  'group' => 'seo', 'label' => 'Facebook Pixel ID',           'type' => 'text',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'cookie_banner_active', 'value' => '1', 'group' => 'seo', 'label' => 'Mostra banner cookie GDPR',   'type' => 'boolean',  'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
