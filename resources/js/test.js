import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        console.error('CSRF token missing');
        return;
    }
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

    const authUserId = window.authUserId;
    if (!authUserId) {
        console.error('authUserId is undefined');
        return;
    }

    console.log('Environment:', {
        key: import.meta.env.VITE_REVERB_APP_KEY,
        host: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
        port: import.meta.env.VITE_REVERB_PORT || 8080,
    });

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
        wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
        forceTLS: false,
        encrypted: false,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
    });

    console.log('Echo initialized', window.Echo);
    window.Echo.connector.pusher.config.logToConsole = true;

    // Subscribe to course-specific submission channel
    const courseId = document.getElementById('course-id')?.value;
    if (courseId) {
        window.Echo.channel(`submissions.${courseId}`)
            .listen('TestSubmitted', (e) => {
                console.log('TestSubmitted event:', e);
                const notification = document.createElement('div');
                notification.textContent = `${e.user} submitted ${e.test} with score ${e.score}`;
                document.getElementById('notifications')?.appendChild(notification);
            })
            .error((error) => {
                console.error('Echo channel error:', error);
            })
            .subscribed(() => {
                console.log(`Successfully subscribed to submissions.${courseId}`);
            });
    } else {
        console.error('courseId is undefined');
    }
});