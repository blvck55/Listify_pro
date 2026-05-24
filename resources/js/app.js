import axios from 'axios';

/**
 * Axios is configured here and exposed as window.axios so any Blade view
 * can call window.axios.get('/api/tasks') without re-importing.
 *
 * For Bearer token auth:
 *   1. Call POST /api/login  → get back { token: "..." }
 *   2. Store it:  localStorage.setItem('api_token', token)
 *   3. All subsequent requests automatically include  Authorization: Bearer <token>
 */

// Set the base URL so we can write '/api/tasks' instead of 'http://localhost:8000/api/tasks'
axios.defaults.baseURL = window.location.origin;

// Laravel expects this header to identify AJAX requests
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Attach the stored Bearer token to every request (if one exists)
const token = localStorage.getItem('api_token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Helper: update the Authorization header after login
axios.setToken = (newToken) => {
    localStorage.setItem('api_token', newToken);
    axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`;
};

// Helper: clear the token on logout
axios.clearToken = () => {
    localStorage.removeItem('api_token');
    delete axios.defaults.headers.common['Authorization'];
};

window.axios = axios;

export default axios;
