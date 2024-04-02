const preLoad = function () {
    return caches.open("offline").then(function (cache) {
        // caching index and important routes
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
});

const filesToCache = [
    '/',
    '/offline.html'
];

const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
};

const addToCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.put(request, response);
        });
    });
};

const returnFromCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                return cache.match("offline.html");
            } else {
                return matching;
            }
        });
    });
};

self.addEventListener("fetch", function (event) {
    // S'assurer que l'événement fetch concerne une requête HTTP ou HTTPS.
    if (!event.request.url.startsWith('http') && !event.request.url.startsWith('https')) {
        return; // Si ce n'est pas le cas, on ne fait rien.
    }

    // Essayer de répondre avec la version en cache de la ressource demandée.
    event.respondWith(
        checkResponse(event.request).catch(function () {
            return returnFromCache(event.request);
        })
    );

    // Essayer d'ajouter la ressource demandée au cache pour une utilisation hors ligne future.
    // Remarque : Cela n'interfère pas avec event.respondWith ci-dessus.
    event.waitUntil(addToCache(event.request));
});
