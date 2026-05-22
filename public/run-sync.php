<?php
define('SECRET', 'ARC2026sync');
if (($_GET['token'] ?? '') !== SECRET) { http_response_code(403); die('Accesso negato.'); }

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');
echo "=== ARC Flight Sync — " . date('d/m/Y H:i:s') . " ===\n\n";

$base    = '/home/aeroportorc/repo/aerrc';
$envFile = $base . '/.env';

// ── 0. Aggiorna .env con le chiavi mancanti ───────────────────
$keysToSet = [
    'AIRLABS_API_KEY'        => 'b2811011-47d4-42c5-ad31-a666136ff464',
    'FLIGHT_STATUS_CACHE_TTL'=> '7200',
    'AIRPORT_IATA'           => 'REG',
];

echo "0) Aggiorno .env...\n";
$envContent = file_get_contents($envFile);
foreach ($keysToSet as $key => $value) {
    if (preg_match("/^{$key}=/m", $envContent)) {
        // Aggiorna valore esistente (anche se vuoto)
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "   {$key} aggiornato.\n";
    } else {
        // Aggiunge in fondo
        $envContent .= "\n{$key}={$value}";
        echo "   {$key} aggiunto.\n";
    }
}
file_put_contents($envFile, $envContent);
echo "   .env salvato.\n\n";

// ── Bootstrap Laravel ─────────────────────────────────────────
require $base . '/vendor/autoload.php';
try {
    $app    = require_once $base . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (\Throwable $e) {
    echo "ERRORE bootstrap: " . $e->getMessage() . "\n";
    exit(1);
}

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
