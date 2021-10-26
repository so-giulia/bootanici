import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './pages/Home.vue';
import Search from './pages/Search.vue';
import Profile from './pages/Profile.vue';


const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/search/:slug_specialization',
            name: 'search',
            component: Search
        },
        {
            path: '/profile/:slug',
            name: 'profile',
            component: Profile
        }


    ]

});
export default router;
