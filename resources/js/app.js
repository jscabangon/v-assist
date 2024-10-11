import { createApp } from 'vue';
import App from './components/App.vue';
import axios from 'axios';

/** Axios base url */
axios.defaults.baseURL = '/api';

// Function to set the Bearer token
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('x-access-token') || null;
  
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
    
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

import '../css/app.css';
/** Main CSS */

import router from './router'
import store from './store'

/** Mounting Vue App */
const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app');