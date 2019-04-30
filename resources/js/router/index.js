// vueとvue-routerの定義
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const routes = [
        { name: 'book-list', path: '/books', component: require('../components/Books/Index.vue').default },
        { name: 'book-create', path: '/books/create', component: require('../components/Books/Create.vue').default },
    ];

const router = new Router({mode: 'history', routes: routes}); 

export default router;