// service-worker.js

// Listen for the install event
self.addEventListener('install', event => {
  console.log('Service worker installed');
});

// Listen for the activate event
self.addEventListener('activate', event => {
  console.log('Service worker activated');
});

// Listen for fetch events
self.addEventListener('fetch', event => {
  console.log('Fetching:', event.request.url);
});
