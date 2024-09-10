import './bootstrap';

import { createApp,h } from 'vue/dist/vue.esm-bundler.js'
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes.js'
import Welcome from './components/Welcome.vue';

const app = createApp(Welcome);

const router = createRouter({
    routes: Routes,
    history: createWebHistory() 
})

app.use(router)

app.mount('#app')