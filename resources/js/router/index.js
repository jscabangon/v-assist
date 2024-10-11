import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';

/** Components */
import Main from '../components/Main.vue';
import Login from '../components/Login.vue';
import Users from '../components/Users.vue';
import Todo from '../components/Todo.vue';

/** Routes */
const routes = [
    { 
        path: '/', 
        name: 'Main',
        component: Main,
        meta: { requiresAuth: true }
    },
    { 
        path: '/login',
        name:'Login',
        component: Login
    },
    { 
        path: '/users', 
        name: 'Users',
        component: Users,
        meta: { requiresAuth: true }
    },
    { 
        path: '/todo', 
        name: 'Todo',
        component: Todo,
        meta: { requiresAuth: true }
    }
];

/** Instanciate Router */
const router = createRouter({
    history: createWebHistory(),
    routes,
});

/** Auth check on page change */
router.beforeEach(async (to, from, next) => {
    const authenticated = store.getters.isAuthenticated;

    if (to.matched.some(record => record.meta.requiresAuth) && !authenticated) {
        next('/login');
    } else {
        next();
    }
});

export default router;