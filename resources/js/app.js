require('./bootstrap');
window.Vue = require('vue').default;
import moment from 'moment';
//Prototypes
Vue.prototype.$Auth = window.Tokens.user;

//Element UI
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/fr';
Vue.use(ElementUI, { locale });

import Buefy from 'buefy';
// import '@mdi/font/css/materialdesignicons.css'
Vue.use(Buefy);

import {Form , HasError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);

// SweetAlerts
window.swal = require('sweetalert2');
window.Swal = swal;
window.Fire =  new Vue();
const toast = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
window.toast = toast;

//Layouts
 Vue.component('headerr', require('./components/Backend/Layouts/Header').default);
 Vue.component('sidebarr', require('./components/Backend/Layouts/Sidebar').default);
 Vue.component('bodyy', require('./components/Backend/Layouts/Body').default);
 Vue.component('contentt', require('./components/Backend/Layouts/Content').default);
 Vue.component('footerr', require('./components/Backend/Layouts/Footer').default);
//Auth
Vue.component('login', require('./components/Backend/Auth/Login').default);



import VueRouter from 'vue-router'
Vue.use(VueRouter);
const routes = [
    //Backend
    { path: '/back_index', component: require('./components/Backend/Index.vue').default ,name: 'back_index'},
    { path: '/profile', component: require('./components/Backend/Configuration/Users/Profile/Index.vue').default ,name: 'profile'},
    { path: '/Utilisateurs', component: require('./components/Backend/Configuration/Users/Index.vue').default ,name: 'Utilisateurs'},
    //Shop
    { path: '/back_categories',component: require('./components/Backend/Shop/Categories').default ,name: 'categories'},
    { path: '/back_products',component: require('./components/Backend/Shop/Products').default ,name: 'products'},
    { path: '/back_brands',component: require('./components/Backend/Shop/Brands').default ,name: 'brands'},
    { path: '/back_orders',component: require('./components/Backend/Shop/Orders').default ,name: 'orders'},
    { path: '/back_shipping',component: require('./components/Backend/Shop/Shipping').default ,name: 'shipping'},
    { path: '/back_cart',component: require('./components/Backend/Shop/Cart').default ,name: 'cart'},
    { path: '/back_reviews', component:require('./components/Backend/Shop/Reviews').default ,name: 'reviews'},
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

Vue.filter('myDate',function(created){
    return moment(created).format('DD/MM/YYYY');
});


const app = new Vue({
    el: '#app',
    router
});
