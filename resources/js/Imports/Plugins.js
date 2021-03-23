
//Element UI
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/fr';
Vue.use(ElementUI, { locale });

// Buefy
import Buefy from 'buefy';
import '@mdi/font/css/materialdesignicons.css'
Vue.use(Buefy);

// VForm
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


