import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "../components/ExampleComponent.vue";
Vue.use(VueRouter)

let publicRoutes = [
    {
        path: '/',
        name: "home",
        component: ExampleComponent
    },
]
export default new VueRouter({
    mode: 'history',
    routes: publicRoutes
});

