import App from './components/App.vue'
import Dashboard from "./components/Dashboard.vue"
import Index from "./components/User/Index.vue"

export default [
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
        name: 'vue.users',
        component: Index,
    }
]