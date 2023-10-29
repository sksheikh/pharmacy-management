import { createRouter, createWebHistory} from 'vue-router';

import LoginPage from '../pages/Login.vue';
import DashboardPage from '../pages/Dashboard.vue';
const OverviewPage  = () => import('../pages/dashboard/Overview.vue');
const DrugsPage  = () => import('../pages/dashboard/Drugs.vue');
const VendorsPage  = () => import('../pages/dashboard/Vendors.vue');
const SellingHistoryPage  = () => import('../pages/dashboard/SellingHistory.vue');
const SettingsPage  = () => import('../pages/dashboard/Settings.vue');



const routes = [
    {
        path: '/',
        component: LoginPage
    },

    {
        path: '/dashboard',
        component: DashboardPage,
        redirect: '/dashboard/overview',
        children: [
            {path: 'overview', component: OverviewPage },
            {path: 'drugs', component: DrugsPage },
            {path: 'vendors', component: VendorsPage },
            {path: 'selling-history', component: SellingHistoryPage },
            {path: 'settings', component: SettingsPage },

        ]
    }
];


const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;
