<?php
define('SECRET', 'ARC2026sync');
if (($_GET['token'] ?? '') !== SECRET) { http_response_code(403); die('Accesso negato.'); }

header('Content-Type: text/plain; charset=utf-8');
echo "=== ARC Flight Sync — " . date('d/m/Y H:i:s') . " ===\n\n";

// vendor è un livello sopra, bootstrap è in repo/aerrc
$autoload  = '/home/aeroportorc/aerrc/vendor/autoload.php';
$bootstrap = '/home/aeroportorc/aerrc/repo/aerrc/bootstrap/app.php';

echo "autoload : {$autoload} — " . (file_exists($autoload)  ? 'OK' : 'NON TROVATO') . "\n";
echo "bootstrap: {$bootstrap} — " . (file_exists($bootstrap) ? 'OK' : 'NON TROVATO') . "\n\n";

if (!file_exists($autoload))  die("ERRORE: vendor/autoload.php non trovato.\n");
if (!file_exists($bootstrap)) die("ERRORE: bootstrap/app.php non trovato.\n");

require $autoload;
$app    = require_once $bootstrap;
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

echo "1) Svuoto la cache...\n";
Cache::flush();
echo "   OK.\n\n";

echo "2) Config clear...\n";
Artisan::call('config:clear');
echo "   " . (trim(Artisan::output()) ?: 'OK.') . "\n\n";

echo "3) Sync voli da AirLabs...\n";
$code = Artisan::call('flights:sync');
echo Artisan::output();
echo "   Exit code: {$code}\n\n";

echo "=== COMPLETATO — " . date('H:i:s') . " ===\n";
echo "*** ELIMINA public/run-sync.php dal File Manager! ***\n";
