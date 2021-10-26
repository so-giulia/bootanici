/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 require('./bootstrap');


 window.Vue = require('vue');
 window.axios = require('axios');
 window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


 

 import router from './router';
 import Vue from 'vue';
 import App from './views/App.vue';
 import StarRating from 'vue-star-rating';
//  import VueCoreVideoPlayer from 'vue-core-video-player';

//  Vue.use(VueCoreVideoPlayer);
 Vue.component('star-rating', StarRating);

 window.onload = function () {
    const app = new Vue({
        el: '#root',
        render: h => h(App),
        router
    });
}
