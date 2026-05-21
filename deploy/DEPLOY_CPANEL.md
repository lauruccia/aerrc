# Deploy su cPanel — Guida Completa
## Aeroporto Reggio Calabria — aeroportoreggiocalabria.it

---

## PRE-REQUISITI

- cPanel con PHP 8.2+ attivato
- MySQL già configurato (database + utente)
- Accesso FTP o File Manager cPanel
- Node.js installato **localmente** (per il build Vite)

---

## STEP 1 — Setup locale (sul tuo PC)

```bash
# 1. Clona / copia la cartella aeroportorc

# 2. Installa dipendenze PHP
composer install --no-dev --optimize-autoloader

# 3. Installa dipendenze Node e compila assets
npm install
npm run build

# 4. Copia .env.example → .env e configura
cp .env.example .env
php artisan key:generate
```

Modifica `.env` con le credenziali MySQL di cPanel:

```env
APP_URL=https://aeroportoreggiocalabria.it
DB_HOST=localhost
DB_DATABASE=aeroportorc_db       # nome DB creato su cPanel
DB_USERNAME=aeroportorc_user      # utente DB su cPanel
DB_PASSWORD=la_tua_password
AVIATIONSTACK_API_KEY=la_tua_chiave   # da aviationstack.com
```

---

## STEP 2 — Struttura upload su cPanel

La struttura sul server sarà:

```
/home/aeroportorc/                  ← root account cPanel
├── aeroportorc/                    ← cartella progetto (FUORI public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── artisan
└── public_html/                    ← document root del dominio
    ├── index.php                   ← modificato per puntare a ../aeroportorc
    ├── .htaccess
    └── build/                      ← assets compilati da Vite
```

---

## STEP 3 — Upload via FTP

1. **Carica** tutta la cartella `aeroportorc/` nella home (`/home/aeroportorc/`), NON dentro `public_html`
2. **Carica** il contenuto di `aeroportorc/public/` dentro `public_html/`
3. **Carica** la cartella `aeroportorc/public/build/` dentro `public_html/build/`

---

## STEP 4 — Modifica index.php in public_html

Apri `public_html/index.php` e modifica i path così:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode
if (file_exists($maintenance = __DIR__.'/../aeroportorc/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../aeroportorc/vendor/autoload.php';

$app = require_once __DIR__.'/../aeroportorc/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

---

## STEP 5 — .htaccess in public_html

Verifica che `public_html/.htaccess` contenga:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # Redirect HTTP → HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Serve file statici normalmente
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f

    # Tutto il resto → Laravel
    RewriteRule ^ index.php [L]
</IfModule>

<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

---

## STEP 6 — Permessi storage

Dal **Terminal cPanel** (o SSH):

```bash
cd /home/aeroportorc/aeroportorc
chmod -R 775 storage bootstrap/cache
chown -R aeroportorc:aeroportorc storage bootstrap/cache
```

---

## STEP 7 — Migrazione e seeder

```bash
# Dal Terminal cPanel
cd /home/aeroportorc/aeroportorc
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## STEP 8 — Cron Job per voli (cPanel Cron Jobs)

Vai su cPanel → **Cron Jobs** e aggiungi:

```
# Ogni 5 minuti — svuota cache voli per refresh automatico
*/5 * * * * php /home/aeroportorc/aeroportorc/artisan schedule:run >> /dev/null 2>&1
```

Questo eseguirà il Laravel Scheduler che include:
- Clear cache voli ogni 5 minuti
- Eventuali job aggiuntivi che aggiungerai

---

## STEP 9 — Variabili PHP (php.ini cPanel)

In cPanel → **PHP Selettore** o `public_html/.user.ini`:

```ini
memory_limit = 256M
max_execution_time = 60
upload_max_filesize = 20M
post_max_size = 25M
```

---

## CHECKLIST FINALE

- [ ] `composer install` eseguito localmente
- [ ] `npm run build` eseguito (cartella `public/build/` presente)
- [ ] `.env` configurato con DB e API key
- [ ] `php artisan key:generate` eseguito
- [ ] File caricati su FTP (progetto fuori public_html, public/ dentro)
- [ ] `public_html/index.php` modificato con path corretti
- [ ] `.htaccess` verificato
- [ ] Permessi `storage/` impostati a 775
- [ ] `php artisan migrate --force` eseguito
- [ ] `php artisan db:seed --force` eseguito
- [ ] Cron job configurato su cPanel
- [ ] Test homepage: https://aeroportoreggiocalabria.it

---

## TROUBLESHOOTING

**500 Internal Server Error**
→ Controlla `storage/logs/laravel.log`
→ Verifica `APP_DEBUG=true` temporaneamente

**Assets non caricano (CSS/JS)**
→ Verifica `public_html/build/` presente
→ Controlla `APP_URL` nel `.env`

**Voli non mostrano**
→ Normale se `AVIATIONSTACK_API_KEY` è vuota — usa mock data
→ Per attivare: registrati su https://aviationstack.com/signup (free)

**Errore DB**
→ Verifica credenziali MySQL in `.env`
→ L'host di solito è `localhost` su cPanel
