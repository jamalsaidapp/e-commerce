window.Vue = require('vue').default;


//Layouts
Vue.component('headerr', require('../components/Backend/Layouts/Header').default);
Vue.component('sidebarr', require('../components/Backend/Layouts/Sidebar').default);
Vue.component('bodyy', require('../components/Backend/Layouts/Body').default);
Vue.component('contentt', require('../components/Backend/Layouts/Content').default);
Vue.component('footerr', require('../components/Backend/Layouts/Footer').default);
//Auth
Vue.component('login', require('../components/Backend/Auth/Login').default);

//Lib
Vue.component('j-data-table',require('../Lib/JDataTable').default);

// Errors
Vue.component('error-404',require('../components/Errors/Error-404.vue').default);
Vue.component('form-error',require('../components/Errors/FormError').default);
