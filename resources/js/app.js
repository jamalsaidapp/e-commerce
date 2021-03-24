window.Vue = require('vue').default;
require('./bootstrap');
require('./Imports/Plugins');
require('./Imports/DateTime')
require('./Imports/Compenents')
import router from './Imports/Router';


//Prototypes
Vue.prototype.$Auth = window.Tokens.user;
Vue.prototype.$R = require('ramda');


const app = new Vue({
    el: '#app',
    router,
});
