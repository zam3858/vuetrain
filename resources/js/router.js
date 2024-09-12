import App from './components/App.vue'
import Dashboard from "./components/Dashboard.vue"
import Index from "./components/User/Index.vue"
import Create from "./components/User/Create.vue"
import Edit from "./components/User/Edit.vue"
import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login/Login.vue'

const routes = [
    {
        path: '/vue',
        name: 'vue.app',
        component: App,
    },
    {
        path: '/dashboard',
        name: 'vue.dashboard',
        component: Dashboard,
    },
    {
        path: '/users',
        name: 'vueUsers',
        component: Index,
    },
    {
        path: '/users/create',
        name: 'vue.users.create',
        component: Create,
    },
    {
        path: '/users/edit/:id',
        name: 'vue.users.edit',
        component: Edit,
    },
    {
        path: '/login',
        name: 'vue.login',
        component: Login,
    }
]

const router = createRouter({
    history: createWebHistory(),  // Use HTML5 history mode
    routes                         // Pass the routes array
  });
  
  // Export the router instance
  export default router;