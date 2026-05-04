/**
 * AXIOS SETUP (WAJIB UNTUK AJAX & API)
 */
import axios from 'axios';

window.axios = axios;

// header default
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * 🔐 CSRF TOKEN AUTO SET (PENTING UNTUK LARAVEL)
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found. Tambahkan di <head> blade!');
}

/**
 * OPTIONAL: GLOBAL ERROR HANDLER (PROFESIONAL)
 */
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response) {
            console.error('API ERROR:', error.response.data);
        } else {
            console.error('NETWORK ERROR:', error.message);
        }
        return Promise.reject(error);
    }
);

/**
 * OPTIONAL: BASE URL (kalau nanti pakai API)
 */
// window.axios.defaults.baseURL = '/api';


/**
 * ================= REALTIME (OPTIONAL - NONAKTIF)
 * Aktifkan kalau nanti pakai notif realtime
 */

// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST
//         ? import.meta.env.VITE_PUSHER_HOST
//         : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });