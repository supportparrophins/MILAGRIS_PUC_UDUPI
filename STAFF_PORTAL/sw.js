const staticCacheName = 'sjpuc-bang-site-static-cache-v1';

const assets = [

  'https://sjpuchassan.schoolphins.com/staff/',

  'https://sjpuchassan.schoolphins.com/staff/offline/index.html',

  'https://sjpuchassan.schoolphins.com/staff/offline/logo.png'

];



// install event

self.addEventListener('install', evt => {

  //console.log('service worker installed');

  evt.waitUntil(

    caches.open(staticCacheName).then((cache) => {

      console.log('caching shell assets');

      cache.addAll(assets);

    })

  );

});



// activate event

self.addEventListener('activate', evt => {

  console.log('service worker activated');

  const currentCaches = [staticCacheName];

  evt.waitUntil(

    caches.keys().then(cacheNames => {

      return cacheNames.filter(cacheName => !currentCaches.includes(cacheName));

    }).then(cachesToDelete => {

      return Promise.all(cachesToDelete.map(cacheToDelete => {

        return caches.delete(cacheToDelete);

      }));

    }).then(() => self.clients.claim())

  );

});



// fetch events

self.addEventListener('fetch', event => {

  event.respondWith(

    caches.match(event.request)

        .then(function(response) {

            // You can remove this line if you don't want to load other files from cache anymore.

            //if (response) return response;

            // If fetch fails, we return offline.html from cache.

            return fetch(event.request)

                .catch(err => {

                  return event.request.url.startsWith(self.location.origin) && caches.match('offline/index.html');                                     

                });

        })

  );

});