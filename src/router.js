import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path:"/",
        name:"HomePage",
        component: () => import('./pages/HomePage.vue'),
    },
    {
        path:"/CalendarPage",
        name:"CalendarPage",
        component: () => import('./pages/CalendarPage.vue'),
    },
    {
        path:"/TaskPage",
        name:"TaskPage",
        component: () => import('./pages/TaskPage.vue'),
        props: true
    },{
        path:"/TestPage",
        name:"TestPage",
        component: () => import('./pages/TestPage.vue')
    },
    {
        path:"/ObakePage",
        name:"ObakePage",
        component: () => import('./pages/ObakePage.vue')
    },
    {
        path:"/SampleDB",
        name:"SampleDB",
        component: () => import('./components/SampleDB.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router