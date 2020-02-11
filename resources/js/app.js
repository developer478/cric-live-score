/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// vue-router import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from '../assets/js/views/App'
import Home from '../assets/js/views/Home'
import About from '../assets/js/views/About'

// Global Component Widget----------------------
import LiveScrore from '../assets/js/component/widget/live-score'
import upComingMatches from '../assets/js/component/widget/upcoming-matches'


// App Routes ----------------------
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: './',
            name: 'home',
            component: Home
        },
        {
            path: './about',
            name: 'about',
            component: About
        },
    ],
});




const app = new Vue({
    el: '#app',
    components: {
        App,
        'live_score': LiveScrore,
        'upcoming_matches': upComingMatches,
    },
    router,
});
