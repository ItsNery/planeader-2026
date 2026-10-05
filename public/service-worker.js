self.addEventListener('push', function(event) {
    const data = event.data ? event.data.json() : {};
    event.waitUntil(self.registration.showNotification(data.title || 'Planeader', {
        body: data.body || 'Tienes una nueva solicitud de agenda.',
        icon: '/img/favicon.png',
        data: { url: data.url || '/' },
    }));
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url));
});
