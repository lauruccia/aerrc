<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_it');
            $table->string('title_en')->nullable();
            $table->string('title_de')->nullable();
            $table->string('title_fr')->nullable();
            $table->longText('content_it')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_de')->nullable();
            $table->longText('content_fr')->nullable();
            $table->string('meta_title_it')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_desc_it')->nullable();
            $table->text('meta_desc_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_footer')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        DB::table('pages')->insert([
            [
                'slug'           => 'chi-siamo',
                'title_it'       => 'Chi Siamo',
                'title_en'       => 'About Us',
                'title_de'       => 'Über uns',
                'title_fr'       => 'À propos',
                'content_it'     => '<h2>Il Portale dell\'Aeroporto di Reggio Calabria</h2><p>Siamo il portale turistico ufficiale dedicato all\'Aeroporto dello Stretto di Reggio Calabria, punto di accesso privilegiato alla Calabria e al Mezzogiorno d\'Italia.</p>',
                'content_en'     => '<h2>Reggio Calabria Airport Portal</h2><p>We are the official tourism portal dedicated to Reggio Calabria Strait Airport, the gateway to Calabria.</p>',
                'is_active'      => true,
                'show_in_footer' => true,
                'sort_order'     => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'slug'           => 'privacy-policy',
                'title_it'       => 'Privacy Policy',
                'title_en'       => 'Privacy Policy',
                'title_de'       => 'Datenschutz',
                'title_fr'       => 'Politique de confidentialité',
                'content_it'     => '<h2>Informativa sulla Privacy</h2><p>In conformità al Regolamento (UE) 2016/679 (GDPR), la presente informativa descrive le modalità di trattamento dei dati personali degli utenti che visitano questo sito.</p>',
                'content_en'     => '<h2>Privacy Policy</h2><p>In accordance with Regulation (EU) 2016/679 (GDPR), this notice describes how personal data of users visiting this site is processed.</p>',
                'is_active'      => true,
                'show_in_footer' => true,
                'sort_order'     => 2,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'slug'           => 'cookie-policy',
                'title_it'       => 'Cookie Policy',
                'title_en'       => 'Cookie Policy',
                'title_de'       => 'Cookie-Richtlinie',
                'title_fr'       => 'Politique des cookies',
                'content_it'     => '<h2>Informativa sull\'uso dei Cookie</h2><p>Questo sito utilizza cookie tecnici e, previo consenso, cookie analitici e di profilazione per migliorare l\'esperienza di navigazione.</p>',
                'content_en'     => '<h2>Cookie Policy</h2><p>This site uses technical cookies and, with prior consent, analytical and profiling cookies to improve the browsing experience.</p>',
                'is_active'      => true,
                'show_in_footer' => true,
                'sort_order'     => 3,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'slug'           => 'contatti',
                'title_it'       => 'Contatti',
                'title_en'       => 'Contact Us',
                'title_de'       => 'Kontakt',
                'title_fr'       => 'Nous contacter',
                'content_it'     => '<h2>Contattaci</h2><p>Per informazioni, collaborazioni o segnalazioni, scrivici all\'indirizzo email indicato di seguito oppure chiamaci.</p>',
                'content_en'     => '<h2>Contact Us</h2><p>For information, partnerships or reports, write to us at the email address below or call us.</p>',
                'is_active'      => true,
                'show_in_footer' => true,
                'sort_order'     => 4,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'slug'           => 'accessibilita',
                'title_it'       => 'Accessibilità',
                'title_en'       => 'Accessibility',
                'title_de'       => 'Barrierefreiheit',
                'title_fr'       => 'Accessibilité',
                'content_it'     => '<h2>Dichiarazione di Accessibilità</h2><p>Ci impegniamo a garantire l\'accessibilità di questo sito a tutti gli utenti, nel rispetto delle linee guida WCAG 2.1.</p>',
                'content_en'     => '<h2>Accessibility Statement</h2><p>We are committed to ensuring this website is accessible to all users, in compliance with WCAG 2.1 guidelines.</p>',
                'is_active'      => true,
                'show_in_footer' => true,
                'sort_order'     => 5,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
