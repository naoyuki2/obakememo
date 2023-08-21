import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: "/",
        name: "HomePage",
        component: () => import('./pages/HomePage.vue'),
    },
    {
        path: "/GravePage",
        name: "GravePage",
        component: () => import('./pages/GravePage.vue'),
    },
    {
        path: "/CalendarPage",
        name: "CalendarPage",
        component: () => import('./pages/CalendarPage.vue'),
    },
    {
        path: "/GhostPage",
        name: "GhostPage",
        component: () => import('./pages/GhostPage.vue'),
    },
    {
        path: "/TaskPage",
        name: "TaskPage",
        component: () => import('./pages/TaskPage.vue'),
        props: true
    },
    {
        path: "/TestPage",
        name: "TestPage",
        component: () => import('./pages/TestPage.vue')
    },
    {
        path: "/ObakePage",
        name: "ObakePage",
        component: () => import('./pages/ObakePage.vue'),
        props: true
    },
    {
        path:"/InsertPage",
        name:"InsertPage",
        component: () => import('./pages/InsertPage.vue'),
    },
    {
        path:"/UpdatePage",
        name:"UpdatePage",
        component: () => import('./pages/UpdatePage.vue')
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router