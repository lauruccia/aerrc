# Deploy su cPanel — Guida Completa
## Aeroporto Reggio Calabria — aeroportoreggiocalabria.it

---

## ANALISI COMPLETA: COSA MANCA PER ANDARE ONLINE

### 🔴 BLOCCANTI (il sito NON funziona senza questi)

| # | Cosa | Come risolvere |
|---|------|----------------|
| 1 | **APP_KEY mancante** | `php artisan key:generate` — obbligatorio |
| 2 | **Database MySQL non configurato** | Creare DB su cPanel e impostare credenziali in `.env` |
| 3 | **AVIATIONSTACK_API_KEY vuota** | Registrarsi su aviationstack.com (piano Basic $9.99/mese) |
| 4 | **Filament Panel Provider non creato** | `php artisan filament:install --panels` (vedi Step 0) |
| 5 | **`npm run build` non eseguito** | Gli asset CSS/JS compilati devono essere rigenerati |

### 🟡 IMPORTANTI (funzionalità parzialmente rotte)

| # | Cosa | Come risolvere |
|---|------|----------------|
| 6 | **MAIL_PASSWORD vuota** | Impostare password SMTP in `.env` (newsletter non funziona) |
| 7 | **SSL/HTTPS da attivare** | Attivare Let's Encrypt da cPanel → SSL/TLS |
| 8 | **APP_URL ancora su localhost** | Cambiare in `.env` con `https://aeroportoreggiocalabria.it` |
| 9 | **APP_DEBUG=true** | Cambiare in `false` nel `.env` di produzione (sicurezza) |

### 🟢 GIÀ RISOLTI (da questa sessione di sviluppo)

| # | Cosa | Stato |
|---|------|-------|
| ✅ | WeatherApiController mancante | Creato in `app/Http/Controllers/Api/` |
| ✅ | Auto-refresh voli in tempo reale | `wire:poll` ogni 60s + toggle pausa |
| ✅ | Modello User + migration | Creati con interfaccia Filament |
| ✅ | Admin seeder Filament | `AdminUserSeeder` — email + password iniziale |
| ✅ | Chiave lingua `origin` mancante | Aggiunta in tutti e 4 i file lingua |

---

## PRE-REQUISITI

- cPanel con PHP 8.2+ attivato
- MySQL già configurato (database + utente)
- Accesso FTP o File Manager cPanel
- Node.js installato **localmente** (per il build Vite)
- Dominio aeroportoreggiocalabria.it puntato sul server

---

## STEP 0 — Installare Filament Panel Provider (UNA SOLA VOLTA)

```bash
# Sul tuo PC, dentro la cartella aeroportorc/
php artisan filament:install --panels
# Quando chiede il nome del panel → premi invio (usa "admin" di default)
# Quando chiede l'ID → premi invio
```

Questo crea `app/Providers/Filament/AdminPanelProvider.php`.
**Senza questo file il pannello admin NON esiste.**

---

## STEP 1 — Setup locale (sul tuo PC)

```bash
# 1. Entra nella cartella
cd aeroportorc

# 2. Installa dipendenze PHP
composer install --no-dev --optimize-autoloader

# 3. Installa dipendenze Node e compila assets
npm install
npm run build

# 4. Copia .env.example → .env e configura
cp .env.example .env
php artisan key:generate
```

Modifica `.env` con le credenziali reali:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://aeroportoreggiocalabria.it

DB_HOST=localhost
DB_DATABASE=aeroportorc_db        # nome DB creato su cPanel
DB_USERNAME=aeroportorc_user       # utente DB su cPanel
DB_PASSWORD=la_tua_password_mysql

AVIATIONSTACK_API_KEY=la_tua_chiave_aviationstack

MAIL_PASSWORD=la_tua_password_smtp
```

---

## STEP 2 — Struttura upload su cPanel

```
/home/aeroportorc/                  ← root account cPanel
├── aeroportorc/                    ← progetto Laravel (FUORI public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env                        ← con credenziali reali
│   └── artisan
└── public_html/                    ← document root del dominio
    ├── index.php                   ← modificato (vedi Step 4)
    ├── .htaccess
    └── build/                      ← assets compilati da Vite
```

---

## STEP 3 — Upload via FTP

1. Carica tutta la cartella `aeroportorc/` in `/home/aeroportorc/` (NON dentro `public_html`)
2. Carica il contenuto di `aeroportorc/public/` dentro `public_html/`
3. Carica `aeroportorc/public/build/` dentro `public_html/build/`

---

## STEP 4 — Modifica index.php in public_html

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

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

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

---

## STEP 6 — Permessi storage (da Terminal cPanel o SSH)

```bash
cd /home/aeroportorc/aeroportorc
chmod -R 775 storage bootstrap/cache
chown -R aeroportorc:aeroportorc storage bootstrap/cache
```

---

## STEP 7 — Migrazione, seeder e ottimizzazione

```bash
cd /home/aeroportorc/aeroportorc

# Migra il database (crea tutte le tabelle incluso users)
php artisan migrate --force

# Popola con dati iniziali + crea utente admin
php artisan db:seed --force

# Ottimizza per produzione
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

**Credenziali admin pannello (da cambiare subito dopo il primo login):**
- URL: `https://aeroportoreggiocalabria.it/admin`
- Email: `admin@aeroportoreggiocalabria.it`
- Password: `AeroportoRC_2026!`

---

## STEP 8 — SSL / HTTPS

In cPanel → **SSL/TLS** → **Let's Encrypt** → attiva per `aeroportoreggiocalabria.it`

Dopo l'attivazione SSL, assicurati che in `.env`:
```env
APP_URL=https://aeroportoreggiocalabria.it
AVIATIONSTACK_BASE_URL=https://api.aviationstack.com/v1
```
> ⚠️ AviationStack HTTPS richiede almeno il piano BASIC ($9.99/mese).
> Il piano FREE funziona solo con HTTP.

---

## STEP 9 — Cron Job (cPanel → Cron Jobs)

```
*/5 * * * * php /home/aeroportorc/aeroportorc/artisan schedule:run >> /dev/null 2>&1
```

Questo esegue ogni 5 minuti:
- Svuota cache voli (rinnova dati AviationStack)
- Svuota cache meteo ogni 30 minuti

---

## STEP 10 — Variabili PHP (public_html/.user.ini)

```ini
memory_limit = 256M
max_execution_time = 60
upload_max_filesize = 20M
post_max_size = 25M
```

---

## CHECKLIST FINALE GO-LIVE

### Preparazione locale
- [ ] `php artisan filament:install --panels` eseguito
- [ ] `composer install --no-dev --optimize-autoloader` eseguito
- [ ] `npm run build` eseguito (cartella `public/build/` presente)
- [ ] `.env` configurato con DB, API key, mail, APP_URL, APP_DEBUG=false
- [ ] `php artisan key:generate` eseguito

### Upload server
- [ ] Progetto caricato fuori da `public_html`
- [ ] Contenuto di `public/` caricato in `public_html/`
- [ ] `public_html/index.php` modificato con path corretti
- [ ] `.htaccess` verificato

### Configurazione server
- [ ] Permessi `storage/` e `bootstrap/cache/` impostati a 775
- [ ] SSL/HTTPS attivato (Let's Encrypt)
- [ ] PHP 8.2+ selezionato in cPanel

### Database e app
- [ ] `php artisan migrate --force` eseguito
- [ ] `php artisan db:seed --force` eseguito
- [ ] `php artisan config:cache` + `route:cache` + `view:cache` eseguiti
- [ ] `php artisan storage:link` eseguito
- [ ] Cron job configurato su cPanel

### Test finale
- [ ] Homepage carica: https://aeroportoreggiocalabria.it
- [ ] Tabellone voli mostra dati reali (non mock)
- [ ] Pannello admin accessibile: /admin
- [ ] Password admin cambiata dal primo accesso
- [ ] Meteo mostra temperatura reale
- [ ] Newsletter iscrizione funziona (test email)
- [ ] Pagina /voli con refresh automatico ogni 60 secondi

---

## TROUBLESHOOTING

**500 Internal Server Error**
→ Controlla `storage/logs/laravel.log`
→ Imposta `APP_DEBUG=true` temporaneamente per vedere l'errore

**Voli mostrano dati mock (non reali)**
→ `AVIATIONSTACK_API_KEY` vuota o errata
→ Verifica su aviationstack.com che la chiave sia attiva
→ Piano FREE: massimo 100 richieste/mese — con cron ogni 5 min esaurisci in 8 ore!
→ **Consiglio:** usa piano BASIC per produzione (10.000 req/mese)

**Pannello /admin non trovato**
→ `php artisan filament:install --panels` non è stato eseguito
→ Controlla che `app/Providers/Filament/AdminPanelProvider.php` esista

**Assets non caricano (CSS/JS)**
→ Verifica che `public_html/build/` sia presente
→ Ricontrolla `APP_URL` nel `.env`

**Errore HTTPS con AviationStack**
→ Il piano FREE non supporta HTTPS — usa `http://` nell'URL oppure upgradia al piano BASIC

**Email non inviata (newsletter)**
→ Controlla `MAIL_PASSWORD` in `.env`
→ Verifica che la porta 587 sia aperta su cPanel

---

## COSTO STIMATO MENSILE IN PRODUZIONE

| Servizio | Piano | Costo |
|----------|-------|-------|
| Hosting cPanel | Condiviso base | ~5-15€/mese |
| Dominio .it | Annuale | ~10-15€/anno |
| AviationStack | Basic (10k req) | ~9$/mese |
| SSL | Let's Encrypt | Gratuito |
| Open-Meteo (meteo) | Free tier | Gratuito |
| **TOTALE** | | **~20-30€/mese** |
