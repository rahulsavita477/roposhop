const CACHE_NAME = 'roposhop-cache-v2';
const urlsToCache = [
	'/',
	'/assets/manifest.json',
	'/assets/favicon.ico',
	'/assets/user/assets2/images/logo.png',
	'/assets/admin/img/ajax-loader1.gif',
	// CSS/JS from css.php and js.php
	'/assets/user/assets2/css/style.css',
	'/assets/user/assets2/css/responsive.css',
	'/assets/user/assets2/js/app.js',
	'https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
	'https://www.gstatic.com/firebasejs/7.15.4/firebase-app.js',
	'https://www.gstatic.com/firebasejs/7.15.4/firebase-analytics.js'
];

self.addEventListener('install', event => {
	event.waitUntil(
		caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
	);
});

self.addEventListener('fetch', event => {
	event.respondWith(
		caches.match(event.request).then(response => {
			return response || fetch(event.request).then(fetchResponse => {
				return caches.open(CACHE_NAME).then(cache => {
					cache.put(event.request, fetchResponse.clone());
					return fetchResponse;
				});
			});
		})
	);
});
