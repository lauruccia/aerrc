<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('position', 20)->default('header')->comment('header|footer|both');
            $table->string('label_it');
            $table->string('label_en')->nullable();
            $table->string('label_de')->nullable();
            $table->string('label_fr')->nullable();
            $table->string('url')->nullable();
            $table->string('target', 10)->default('_self')->comment('_self|_blank');
            $table->string('icon', 80)->nullable()->comment('Heroicon name, es: heroicon-o-home');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_highlight')->default(false)->comment('Evidenzia con colore accent');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('menu_items')->nullOnDelete();
        });

        $now = now();

        // Header menu
        DB::table('menu_items')->insert([
            ['position' => 'header', 'label_it' => 'Home',           'label_en' => 'Home',        'url' => '/',               'sort_order' => 1,  'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'header', 'label_it' => 'Voli',           'label_en' => 'Flights',     'url' => '/voli',           'sort_order' => 2,  'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'header', 'label_it' => 'Destinazioni',   'label_en' => 'Destinations','url' => '/destinazioni',   'sort_order' => 3,  'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'header', 'label_it' => 'Turismo',        'label_en' => 'Tourism',     'url' => '/turismo',        'sort_order' => 4,  'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'header', 'label_it' => 'News',           'label_en' => 'News',        'url' => '/news',           'sort_order' => 5,  'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'header', 'label_it' => 'Contatti',       'label_en' => 'Contact',     'url' => '/pagina/contatti','sort_order' => 6,  'is_active' => true, 'is_highlight' => true,  'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Footer menu
        DB::table('menu_items')->insert([
            ['position' => 'footer', 'label_it' => 'Chi Siamo',      'label_en' => 'About Us',    'url' => '/pagina/chi-siamo',      'sort_order' => 1, 'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'footer', 'label_it' => 'Privacy Policy', 'label_en' => 'Privacy',     'url' => '/pagina/privacy-policy', 'sort_order' => 2, 'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'footer', 'label_it' => 'Cookie Policy',  'label_en' => 'Cookies',     'url' => '/pagina/cookie-policy',  'sort_order' => 3, 'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
            ['position' => 'footer', 'label_it' => 'Accessibilità',  'label_en' => 'Accessibility','url' => '/pagina/accessibilita', 'sort_order' => 4, 'is_active' => true, 'is_highlight' => false, 'target' => '_self', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
