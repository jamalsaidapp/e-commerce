// Vue-Router
window.Vue = require('vue').default;
import VueRouter from 'vue-router'
Vue.use(VueRouter);


let routes = [
    //Backend
    { path: '/back_index', component: require('../components/Backend/Index.vue').default ,name: 'back_index'},
    { path: '/profile', component: require('../components/Backend/Configuration/Users/Profile/Index.vue').default ,name: 'profile'},
    { path: '/Utilisateurs', component: require('../components/Backend/Configuration/Users/Index.vue').default ,name: 'Utilisateurs'},
    //Shop
    { path: '/back_categories',component: require('../components/Backend/Shop/Categories').default ,name: 'categories'},
    { path: '/back_products',component: require('../components/Backend/Shop/Products').default ,name: 'products'},
    { path: '/back_brands',component: require('../components/Backend/Shop/Brands').default ,name: 'brands'},
    { path: '/back_orders',component: require('../components/Backend/Shop/Orders').default ,name: 'orders'},
    { path: '/back_shipping',component: require('../components/Backend/Shop/Shipping').default ,name: 'shipping'},
    { path: '/back_cart',component: require('../components/Backend/Shop/Cart').default ,name: 'cart'},
    { path: '/back_reviews', component:require('../components/Backend/Shop/Reviews').default ,name: 'reviews'},

];

export default new VueRouter({
    mode: 'history',
    saveScrollPosition: true,
    routes
})

