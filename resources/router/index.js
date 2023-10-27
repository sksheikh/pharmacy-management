import { createRouter, createWebHistory} from 'vue-router';

import LoginPage from '../pages/Login.vue';
import DashboardPage from '../pages/Dashboard.vue';

const routes = [
    {
        path: '/',
        component: LoginPage
    },

    {
        path: '/dashboard',
        component: DashboardPage
    }
];


const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;
