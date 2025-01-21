import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../vue/pages/Home.vue'),
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../vue/pages/About.vue'),
    },
    {
        path: '/edit/:id',
        name: 'edit',
        component: () => import('../vue/pages/Edit.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
