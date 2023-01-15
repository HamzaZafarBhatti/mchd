importScripts('https://www.gstatic.com/firebasejs/8.6.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.6.0/firebase-messaging.js');


self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    var url = null;
    //var tag = event.notification.tag;
    if (event.notification) {
        url = event.notification.body
    }
    event.waitUntil(
        clients.matchAll({type: 'window'}).then( windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
})


firebase.initializeApp({
    apiKey: "AIzaSyBcffmPoCZJERSa2-RJaebPu9-K1G4IRGU",
    projectId: "ahamd-hospital-fc738",
    messagingSenderId: "144395845459",
    appId: "1:144395845459:web:f8b5f3f5fb6995afadaba6",
});

const messaging = firebase.messaging();
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/

messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const noteTitle = payload.notification.title;

    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };

    return self.registration.showNotification(
        noteTitle,
        noteOptions,
    );
});

messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
})

