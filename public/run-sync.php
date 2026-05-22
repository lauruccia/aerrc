<?php
/**
 * Script temporaneo — esegui UNA VOLTA dal browser poi elimina questo file.
 * URL: https://aeroportoreggiocalabria.it/run-sync.php?token=ARC2026sync
 * ELIMINA QUESTO FILE dopo l'uso!
 */
define('SECRET', 'ARC2026sync');
if (($_GET['token'] ?? '') !== SECRET) { http_response_code(403); die('Accesso negato.'); }

header('Content-Type: text/plain; charset=utf-8');
echo "=== ARC Flight Sync — " . date('d/m/Y H:i:s') . " ===\n\n";

// Laravel è in /home/aeroportorc/aerrc/repo/aerrc/
$laravelBase = '/home/aeroportorc/aerrc/repo/aerrc';

$autoload  = $laravelBase . '/vendor/autoload.php';
$bootstrap = $laravelBase . '/bootstrap/app.php';

echo "Laravel base: {$laravelBase}\n";

if (!file_exists($autoload))  die("ERRORE: vendor/autoload.php non trovato in {$laravelBase}\n");
if (!file_exists($bootstrap)) die("ERRORE: bootstrap/app.php non trovato in {$laravelBase}\n");

echo "Autoload OK. Bootstrap OK.\n\n";

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
$out = trim(Artisan::output());
echo "   " . ($out ?: 'OK.') . "\n\n";

// 3. Sync voli
echo "3) Sincronizzo i voli da AirLabs...\n";
$exitCode = Artisan::call('flights:sync');
echo Artisan::output();
echo "   Exit code: {$exitCode}\n\n";

echo "=== COMPLETATO — " . date('H:i:s') . " ===\n";
echo "\n*** ELIMINA public/run-sync.php dal File Manager! ***\n";
