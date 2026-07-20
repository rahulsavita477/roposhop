self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('ropo-cache').then(cache => {
      return cache.addAll([
        '/',
        '/index.php/dashboard',
        '/assets/admin/css/bootstrap.min.css',
        '/assets/admin/js/app.min.js',
        '/assets/admin/img/avatar3.png'
      ]);
    })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
