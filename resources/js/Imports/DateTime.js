import moment from 'moment';


    Vue.filter('upText', function(text){
        return text.charAt(0).toUpperCase() + text.slice(1)
    });

    Vue.filter('myDate',function(created){
        return moment(created).format('DD/MM/YYYY');
    });
    Vue.filter('myDate1',function(created){
        return moment(created).format('YYYY-MM-DD');
    });
    Vue.filter('myDate2',function(created){
        return moment(created).format('DD/MM/YYYY HH:mm');
    });
    Vue.filter('myDate3',function(created){
        return moment(created).format('HH:mm');
    });
    Vue.filter('myDate4',function(created){
        moment.locale('fr');
        return moment(created).fromNow();
    });
    Vue.filter('fixsize', function(size){
        if(size / 1024 <  1024)
        {
            let SZ = size / 1000 ;
            return  SZ.toFixed(0) + ' Ko'
        }
        else if(size / 1024 > 1024)
        {
            let SZ = size / 1000000;
            return  SZ.toFixed(0) + ' Mo'
        }
    });
    Vue.filter('isAdminLable', function(text){

        return '<span class="right badge badge-danger">' +text +'</span>'
    });
    Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('hh:mm')
        }
    });

    Vue.filter('truncate', function (value, limit) {
        if (value.length > limit) {
            value = value.substring(0, (limit - 3)) + '...';
        }
        return value
    });

    //*******************************************************Vue Directives*******************************************************\\

    Vue.directive("dater", {
        update: function (el) {
        el.value = moment(el.value).format('DD/MM/YYYY');
    }
});
Vue.directive("dater2", {
    update: function (el) {
        el.value = moment(el.value).format('DD/MM/YYYY HH:mm ');
    }
});


