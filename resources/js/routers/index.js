import Vue from "vue";
import Router from 'vue-router';
import store from '../stores/index';

Vue.use(Router);


const routes = [{
        path: "/",
        name: "Login",
        component: () => import("../pages/Login.vue"),
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('auth')) {
                next({
                    name: 'Dashboard'
                });
            } else {
                next();
            }
        },
        meta: {
            requiresAuth: false,
        }
    },
    // AUTHENTICATED
    {
        path: "/participant",
        name: "Dashboard",
        component: () => import("../pages/Home.vue"),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/participant/:id",
        name: "DetailParticipant",
        component: () => import("../pages/DetailParticipant.vue"),
        meta: {
            requiresAuth: true,
        },
    },
]

const router = new Router({
    routes,
    mode: 'history'
});



export default router

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('auth')
    if (to.meta.requiresAuth) {
        if (!isAuthenticated) {
            next({
                name: 'Login'
            })
        } else {
            next()
        }
    } else {
        next()
    }
});
