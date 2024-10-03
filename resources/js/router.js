import {createRouter, createWebHistory} from "vue-router";
import Dashboard from "./Pages/Dashboard.vue";

const routes = [
    {
        path: '/app/dashboard',
        component: Dashboard,
    },
    {
        path: '/app/batches',
        children: [
            {
                path: '',
                component: () => import('./Pages/Batches.vue')
            },{
                path: ':id/dispatch',
                component: () => import('./Pages/Dispatch.vue')
            },{
                path: ':id/items-out',
                component: () => import('./Pages/ItemsOut.vue')
            }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    linkExactActiveClass: "active",
    routes
})

export default router
