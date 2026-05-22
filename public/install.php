<?php
/**
 * ============================================================
 *  AEROPORTO REGGIO CALABRIA — Web Installer
 *  Esegui UNA sola volta, poi ELIMINA questo file dal server.
 * ============================================================
 *  Protetto da password. Visita: https://tuodominio.it/install.php
 * ============================================================
 */

define('INSTALL_PASSWORD', 'AeroportoRC2026!');   // ← cambia se vuoi

// ── Autenticazione ───────────────────────────────────────────
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === INSTALL_PASSWORD) {
        $_SESSION['install_ok'] = true;
    } else {
        $error = 'Password errata.';
    }
}

if (!isset($_SESSION['install_ok'])) {
    ?><!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Installer — Aeroporto RC</title>
<style>
  body{font-family:sans-serif;background:#0d1f3c;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;}
  .box{background:#fff;padding:2.5rem 3rem;border-radius:12px;max-width:380px;width:100%;text-align:center;}
  h2{color:#0d1f3c;margin:0 0 1.5rem;}
  input{width:100%;padding:.7rem 1rem;border:1px solid #ccc;border-radius:6px;font-size:1rem;margin-bottom:1rem;box-sizing:border-box;}
  button{width:100%;padding:.8rem;background:#c9a84c;color:#0d1f3c;font-weight:700;font-size:1rem;border:none;border-radius:6px;cursor:pointer;}
  .err{color:#c0392b;font-size:.9rem;margin-bottom:.8rem;}
</style>
</head>
<body>
<div class="box">
  <h2>✈ Installer</h2>
  <?php if ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <form method="POST">
    <input type="password" name="password" placeholder="Password installer" autofocus>
    <button type="submit">Accedi</button>
  </form>
</div>
</body></html>
<?php
    exit;
}

// ── Bootstrap Laravel ────────────────────────────────────────
define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// ── Esecuzione comandi ───────────────────────────────────────
$action  = $_POST['action'] ?? '';
$results = [];

function runArtisan(string $cmd, array &$out): bool {
    try {
        $code = Artisan::call($cmd);
        $out[] = ['cmd' => $cmd, 'ok' => $code === 0, 'output' => Artisan::output()];
        return $code === 0;
    } catch (\Throwable $e) {
        $out[] = ['cmd' => $cmd, 'ok' => false, 'output' => $e->getMessage()];
        return false;
    }
}

if ($action === 'run') {
    runArtisan('migrate --force', $results);
    runArtisan('db:seed --force', $results);
    runArtisan('config:cache', $results);
    runArtisan('route:cache', $results);
    runArtisan('view:cache', $results);
}

if ($action === 'delete_self') {
    session_destroy();
    @unlink(__FILE__);
    echo '<script>window.location="/";</script>';
    exit;
}

?><!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Installer — Aeroporto RC</title>
<style>
  *{box-sizing:border-box;}
  body{font-family:sans-serif;background:#0d1f3c;color:#e0e0e0;padding:2rem;margin:0;}
  .wrap{max-width:860px;margin:0 auto;}
  h1{color:#c9a84c;margin-bottom:2rem;}
  .step{background:#152a4e;border-radius:10px;padding:1.5rem 2rem;margin-bottom:1.5rem;}
  .step h3{color:#c9a84c;margin:0 0 .8rem;font-size:1.1rem;}
  .step p{color:#aaa;font-size:.9rem;margin:0 0 1rem;}
  button{padding:.7rem 1.8rem;border:none;border-radius:6px;font-weight:700;font-size:.95rem;cursor:pointer;}
  .btn-go{background:#c9a84c;color:#0d1f3c;}
  .btn-del{background:#c0392b;color:#fff;}
  .btn-go:hover{background:#e2c97e;}
  pre{background:#0a1628;padding:1rem;border-radius:6px;font-size:.8rem;overflow:auto;max-height:260px;color:#c3d6e8;margin:.5rem 0 0;}
  .ok{color:#2ecc71;font-weight:700;}
  .fail{color:#e74c3c;font-weight:700;}
  .warn{background:#7b4a00;border-radius:6px;padding:.8rem 1rem;font-size:.9rem;color:#ffd;}
  .logo{font-size:1.4rem;margin-bottom:1.5rem;}
</style>
</head>
<body>
<div class="wrap">
  <div class="logo">✈ <strong style="color:#c9a84c;">Aeroporto Reggio Calabria</strong></div>
  <h1>Web Installer</h1>

  <?php if (!$results): ?>

  <div class="step">
    <h3>📋 Checklist prima di procedere</h3>
    <p>Assicurati di aver già configurato il file <code>.env</code> con le credenziali MySQL del tuo hosting:</p>
    <pre>DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=nome_database
DB_USERNAME=nome_utente
DB_PASSWORD=password</pre>
  </div>

  <div class="warn">
    ⚠️ Questo installer eseguirà <strong>migrate</strong> e <strong>db:seed</strong>.
    Se il database ha già dati, verranno sovrascritti o duplicati.
    Procedi solo su un database <strong>vuoto</strong>.
  </div><br>

  <form method="POST">
    <input type="hidden" name="action" value="run">
    <button type="submit" class="btn-go">▶ Esegui migrazione + seed</button>
  </form>

  <?php else: ?>

  <?php foreach ($results as $r): ?>
  <div class="step">
    <h3>
      <?= $r['ok'] ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>' ?>
      &nbsp;<code>php artisan <?= htmlspecialchars($r['cmd']) ?></code>
    </h3>
    <?php if (trim($r['output'])): ?>
    <pre><?= htmlspecialchars(trim($r['output'])) ?></pre>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>

  <?php
  $allOk = !in_array(false, array_column($results, 'ok'));
  if ($allOk): ?>
  <div class="step" style="border:2px solid #2ecc71;">
    <h3 class="ok">✓ Installazione completata con successo!</h3>
    <p>Il database è pronto. Elimina subito questo file per sicurezza.</p>
    <form method="POST">
      <input type="hidden" name="action" value="delete_self">
      <button type="submit" class="btn-del">🗑 Elimina install.php ora</button>
    </form>
  </div>
  <?php else: ?>
  <div class="step" style="border:2px solid #e74c3c;">
    <h3 class="fail">✗ Alcuni passaggi hanno fallito</h3>
    <p>Controlla le credenziali nel <code>.env</code> e assicurati che il database esista e sia vuoto, poi riprova.</p>
    <form method="POST">
      <input type="hidden" name="action" value="run">
      <button type="submit" class="btn-go">↺ Riprova</button>
    </form>
  </div>
  <?php endif; ?>

  <?php endif; ?>

</div>
</body>
</html>
