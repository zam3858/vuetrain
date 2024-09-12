import './bootstrap';
import 'bootstrap/dist/js/bootstrap.js'

import { createApp,h } from 'vue/dist/vue.esm-bundler.js'
import router from './router.js'
import Welcome from './components/Welcome.vue';
import WelcomePelulus from './components/WelcomePelulus.vue';

const app = createApp(Welcome);

app.use(router)

app.mount('#app')

const apppelulus = createApp(WelcomePelulus);

apppelulus.use(router)

apppelulus.mount('#apppelulus')