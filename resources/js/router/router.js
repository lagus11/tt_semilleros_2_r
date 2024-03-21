import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "../components/ExampleComponent.vue";
import login from "../views/login/login.vue";
import book from "../views/book/book.vue";
import category from "../views/category/category.vue";
import editorial from "../views/editorial/editorial.vue";
import writer from "../views/writer/writer.vue";
import loan from "../views/loan/loan.vue";
import user from "../views/user/user.vue";
import searchBooks from "../views/book/searchBooks.vue";

Vue.use(VueRouter)

let publicRoutes = [
    {
        path: '/login',
        name: 'login',
        component: login,
        meta: { showNavbar: false}
    },
    {
        path: '/',
        name: "home",
        component: ExampleComponent,
        meta: { showNavbar: true}
    },
    {
        path: '/book',
        name: "book",
        component: book,
        meta: { showNavbar: true}
    },
    {
        path: '/category',
        name: "category",
        component: category,
        meta: { showNavbar: true}
    },
    {
        path: '/editorial',
        name: "editorial",
        component: editorial,
        meta: { showNavbar: true}
    },
    {
        path: '/writer',
        name: "writer",
        component: writer,
        meta: { showNavbar: true}
    },
    {
        path: '/loan',
        name: "loan",
        component: loan,
        meta: { showNavbar: true}
    },
    {
        path: '/user',
        name: "user",
        component: user,
        meta: { showNavbar: true}
    },
    {
        path: '/search-books',
        name: "searchBooks",
        component: searchBooks,
        meta: { showNavbar: true}
    },
]
export default new VueRouter({
    mode: 'history',
    routes: publicRoutes
});

