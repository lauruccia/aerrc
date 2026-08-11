/**
 * Service Worker — Aeroporto Reggio Calabria (aeroportoreggiocalabria.it)
 *
 * Strategia:
 *  - Tabellone voli (/voli, /en/voli, ecc.) e rotte API: NETWORK-FIRST
 *    (dati che cambiano ogni pochi minuti — mostra la cache solo se offline)
 *  - Tutto il resto (home, guide turismo, destinazioni, asset statici):
 *    CACHE-FIRST (contenuto che cambia raramente — velocità massima,
 *    consultabile anche offline in aeroporto con connessione instabile)
 */

const CACHE_NAME = 'arc-cache-v1';
const FLIGHTS_PATH_RE = /\/voli(\/|$|\?)/;

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((names) =>
            Promise.all(
                names
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            )
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const req = event.request;

    // Solo GET, solo stesso dominio — lascia passare tutto il resto
    // (POST/newsletter, analytics, domini esterni, ecc.) senza intercettarlo.
    if (req.method !== 'GET' || new URL(req.url).origin !== self.location.origin) {
        return;
    }

    const isFlights = FLIGHTS_PATH_RE.test(new URL(req.url).pathname);

    if (isFlights) {
        event.respondWith(networkFirst(req));
    } else {
        event.respondWith(cacheFirst(req));
    }
});

async function cacheFirst(req) {
    const cached = await caches.match(req);
    if (cached) return cached;

    try {
        const res = await fetch(req);
        if (res && res.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(req, res.clone());
        }
        return res;
    } catch (err) {
        // Offline e non in cache: se è una navigazione HTML, prova a servire
        // almeno la home come fallback minimo.
        if (req.mode === 'navigate') {
            const fallback = await caches.match('/');
            if (fallback) return fallback;
        }
        throw err;
    }
}

async function networkFirst(req) {
    try {
        const res = await fetch(req);
        if (res && res.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(req, res.clone());
        }
        return res;
    } catch (err) {
        const cached = await caches.match(req);
        if (cached) return cached;
        throw err;
    }
}
