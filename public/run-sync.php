<?php
/**
 * Script temporaneo — esegui UNA VOLTA dal browser poi elimina questo file.
 * URL: https://aeroportoreggiocalabria.it/run-sync.php?token=ARC2026sync
 * ELIMINA QUESTO FILE dopo l'uso!
 */
define('SECRET', 'ARC2026sync');
if (($_GET['token'] ?? '') !== SECRET) { http_response_code(403); die('Accesso negato.'); }

header('Content-Type: text/plain; charset=utf-8');
// Flush immediato — vedi output in tempo reale
ob_implicit_flush(true);
ob_end_flush();

echo "=== ARC Flight Sync — " . date('d/m/Y H:i:s') . " ===\n\n";

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

// 1. Svuota cache
echo "1) Svuoto la cache...\n";
Cache::flush();
echo "   Cache svuotata.\n\n";

// 2. Ricarica config
echo "2) Ricarico la configurazione...\n";
Artisan::call('config:clear');
echo "   " . trim(Artisan::output()) . "\n\n";

// 3. Sync voli
echo "3) Sincronizzo i voli da AirLabs...\n";
$exitCode = Artisan::call('flights:sync');
echo Artisan::output();
echo "   Exit code: {$exitCode}\n\n";

echo "=== COMPLETATO — " . date('H:i:s') . " ===\n";
echo "\n⚠️  RICORDATI: elimina public/run-sync.php dal File Manager!\n";
