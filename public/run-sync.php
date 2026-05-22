<?php
/**
 * Script temporaneo — esegui UNA VOLTA dal browser poi elimina questo file.
 * URL: https://aeroportoreggiocalabria.it/run-sync.php?token=ARC2026sync
 * ELIMINA QUESTO FILE dopo l'uso!
 *
 * Su cPanel: public_html/ → app in /home/aeroportorc/aerrc/
 */
define('SECRET', 'ARC2026sync');
if (($_GET['token'] ?? '') !== SECRET) { http_response_code(403); die('Accesso negato.'); }

header('Content-Type: text/plain; charset=utf-8');

echo "=== ARC Flight Sync — " . date('d/m/Y H:i:s') . " ===\n\n";

// Percorso reale dell'app Laravel su cPanel
// public_html/ è separata da aerrc/ — non si può usare __DIR__/../
$appBase = '/home/aeroportorc/aerrc';

echo "Base path: {$appBase}\n";

$autoload = $appBase . '/vendor/autoload.php';
$bootstrap = $appBase . '/bootstrap/app.php';

if (!file_exists($autoload)) {
    die("ERRORE: vendor/autoload.php non trovato in {$appBase}\nVerifica il percorso.\n");
}
if (!file_exists($bootstrap)) {
    die("ERRORE: bootstrap/app.php non trovato in {$appBase}\n");
}

echo "Autoload trovato. Bootstrap trovato.\n\n";

// Bootstrap Laravel
require $autoload;
$app = require_once $bootstrap;
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

// 1. Svuota cache
echo "1) Svuoto la cache...\n";
Cache::flush();
echo "   OK.\n\n";

// 2. Ricarica config
echo "2) Ricarico la configurazione...\n";
Artisan::call('config:clear');
echo "   " . trim(Artisan::output()) ?: "OK.";
echo "\n\n";

// 3. Sync voli
echo "3) Sincronizzo i voli da AirLabs...\n";
$exitCode = Artisan::call('flights:sync');
echo Artisan::output();
echo "   Exit code: {$exitCode}\n\n";

echo "=== COMPLETATO — " . date('H:i:s') . " ===\n";
echo "\n*** ELIMINA public/run-sync.php dal File Manager! ***\n";
