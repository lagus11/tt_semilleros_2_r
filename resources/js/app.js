/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue';
import vuetify from '../plugins/vuetify'
import router from "./router/router";
import axios from "axios";

Vue.prototype.$axios = axios;
Vue.component('app-vue', require('./App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    vuetify,
    router,
    render: h => h('app-vue')
}).$mount('#root')
