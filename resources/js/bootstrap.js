import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST,
//     wsPort: import.meta.env.VITE_REVERB_PORT,
//     wssPort: import.meta.env.VITE_REVERB_PORT,
//     forceTLS: true,
//     enabledTransports: ['ws', 'wss'],
// });


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});
if (window.Laravel && window.Laravel.userId) {
    window.Echo.private(`tailor.${window.Laravel.userId}`)
        .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
            const notif = e.notification.data;
            console.log("Notifikasi masuk:", notif);
            showToast(notif.title, notif.message);
        });
}

function showToast(title, message) {
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-bg-info border-0 position-fixed bottom-0 end-0 m-3 show';
    toast.role = 'alert';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <strong>${title}</strong><br>${message}
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 6000);
}


window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
