require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import App from './components/App'
import Product from './components/Product'
import Login from './components/Login'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/product',
            name: 'product',
            component: Product
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App, Product, Login},
    router,
});
