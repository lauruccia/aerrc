<?php
/**
 * Script temporaneo — esegui UNA VOLTA dal browser poi elimina questo file.
 * URL: https://aeroportoreggiocalabria.it/run-sync.php?token=ARC2026sync
 *
 * ELIMINA QUESTO FILE dopo l'uso!
 */

// Token di sicurezza — cambia se vuoi
define('SECRET', 'ARC2026sync');

if (($_GET['token'] ?? '') !== SECRET) {
    http_response_code(403);
    die('Accesso negato.');
}

// Percorso base Laravel (un livello sopra /public)
$base = dirname(__DIR__);
$php  = PHP_BINARY ?: '/opt/cpanel/ea-php83/root/usr/bin/php';
$artisan = $base . '/artisan';

header('Content-Type: text/plain; charset=utf-8');

echo "=== ARC Flight Sync — " . date('d/m/Y H:i:s') . " ===\n\n";

// 1. Cache clear
echo "1) Svuoto la cache...\n";
$out = shell_exec("{$php} {$artisan} cache:clear 2>&1");
echo $out . "\n";

// 2. Config clear (per leggere il nuovo .env)
echo "2) Ricarico la configurazione...\n";
$out = shell_exec("{$php} {$artisan} config:clear 2>&1");
echo $out . "\n";

// 3. Flights sync
echo "3) Sincronizzo i voli da AirLabs...\n";
$out = shell_exec("{$php} {$artisan} flights:sync 2>&1");
echo $out . "\n";

echo "=== COMPLETATO ===\n";
echo "\n⚠️  ELIMINA QUESTO FILE ORA: public/run-sync.php\n";
