import './assets/main.css'

import { createApp } from 'vue'

import App from './App.vue'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
// Vuetify
import vuetify from '@/plugins/vuetify'
//Pinia
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

//Axios Config
axios.defaults.withXSRFToken = true
axios.defaults.withCredentials = true
axios.defaults.baseURL = import.meta.env.VITE_BACKEND_URL
axios.defaults.headers.common['Access-Control-Origin'] = import.meta.env.VITE_URL;
axios.defaults.headers.common['Access-Control-Allow-Origin'] = import.meta.env.VITE_URL;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';
// axios.defaults.headers.common['X-Authorization'] = '';

/**
 * https://github.com/axios/axios/issues/6047
 */
//Define XSRF token
axios.interceptors.response.use((config) => {
    const cookie = getCookie('XSRF-TOKEN');
    const token = decodeURIComponent(cookie);

    axios.defaults.headers.common['X-XSRF-TOKEN'] = token;  
    return config;
});
// Utility function to retrieve a cookie value by name
function getCookie(name) {
    const cookies = document.cookie.split(';')
    for (const cookie of cookies) {
        const [key, value] = cookie.split('=')

        if (key.trim() === name) {
            return value
        }
    }

    return ''
}

const app = createApp(App)

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

app.use(router)
    .use(VueAxios, axios)
    .use(vuetify)
    .use(pinia)

app.mount('#app')
