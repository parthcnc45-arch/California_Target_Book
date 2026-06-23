import axios from 'axios';

const api = axios.create();

api.interceptors.request.use((config) => {
    // Dynamic CSRF Token attachment
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        config.headers['X-CSRF-TOKEN'] = csrfToken.content;
    }

    // Identify request as AJAX for Laravel backend
    config.headers['X-Requested-With'] = 'XMLHttpRequest';

    // Retrieve API token exclusively from localStorage
    const token = localStorage.getItem('api_token');

    // Automatically attach token to outgoing requests containing /api/
    if (token && config.url && config.url.includes('/api/')) {
        // Option 1: Standard Bearer Header
        config.headers['Authorization'] = `Bearer ${token}`;
        if (config.headers.common) {
            config.headers.common['Authorization'] = `Bearer ${token}`;
        }

        // Option 2: Request Parameter (bypasses server config that strips Authorization headers)
        config.params = config.params || {};
        config.params['api_token'] = token;
    }

    // Always request JSON responses
    config.headers['Accept'] = 'application/json';
    if (config.headers.common) {
        config.headers.common['Accept'] = 'application/json';
    }

    return config;
}, (error) => {
    return Promise.reject(error);
});

// Sync api_token to localStorage on load from meta tag if available
try {
    const apiTokenMeta = document.head.querySelector('meta[name="api_token"]') || document.head.querySelector('meta[name="ctb_api_token"]');
    if (apiTokenMeta && apiTokenMeta.content) {
        localStorage.setItem('api_token', apiTokenMeta.content.trim());
    }
} catch (e) {
    console.error('Failed to sync api_token to localStorage', e);
}

export default api;
