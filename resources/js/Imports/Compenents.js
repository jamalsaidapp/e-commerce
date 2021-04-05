/////////////////////////////////////////////BACKTEND/////////////////////////////////////////////////////
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
Vue.component('j-data-table',require('../Lib/JTable/JDataTable').default);

// Errors
Vue.component('error-404',require('../components/Errors/Error-404.vue').default);
Vue.component('form-error',require('../components/Errors/FormError').default);






/////////////////////////////////////////////FRONTEND/////////////////////////////////////////////////////

//Layouts
Vue.component('header_f', require('../components/Frontend/Layouts/Header_f').default);
Vue.component('body_f', require('../components/Frontend/Layouts/Body_f').default);
Vue.component('content_f', require('../components/Frontend/Layouts/Content_f').default);
Vue.component('footer_f', require('../components/Frontend/Layouts/Footer_f').default);
