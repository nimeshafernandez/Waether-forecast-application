/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');
window.Fire = new Vue();

import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

import { Form, HasError, AlertError } from 'vform';
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form = Form;

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

//v-calender
// import Calendar from 'v-calendar/lib/components/calendar.umd'
// import DatePicker from 'v-calendar/lib/components/date-picker.umd'

// // Register components in your 'main.js'
// Vue.component('v-calendar', Calendar)
// Vue.component('v-date-picker', DatePicker)

import moment from 'moment';
Vue.filter('myDate',function(date){
  return moment(date).format("MMM Do YYYY");
});
Vue.filter('billDate',function(date){
  return moment(date).format("DD-MM-YYYY H:mm");
});


//toast
import Toaster from 'v-toaster'

// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'

// optional set default imeout, the default is 10000 (10 seconds).
Vue.use(Toaster, {timeout: 5000})

import Swal from 'sweetalert2'
window.swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

window.Toast = Toast;

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);

import VueNumberInput from '@chenfengyuan/vue-number-input';
Vue.component('number-input', VueNumberInput);


Vue.filter('currency', function(amount){
  let val = 'Rs. ' + (amount/1).toFixed(2);
  return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);
Vue.component('role-permissions-component', require('./components/RolePermission.vue').default);
Vue.component('brand-management-component', require('./components/BrandComponent.vue').default);
Vue.component('category-management-component', require('./components/CategoryComponent.vue').default);
Vue.component('supplier-management-component', require('./components/SupplierComponent.vue').default);

Vue.component('add-product-component', require('./components/AddProductComponent.vue').default);
Vue.component('view-all-products-component', require('./components/SearchProductComponent.vue').default);
Vue.component('stock-overview-component', require('./components/StockOverview.vue').default);

Vue.component('customer-management-component', require('./components/CustomerComponent.vue').default);
Vue.component('customer-overview-component', require('./components/CustomerOverview.vue').default);
Vue.component('customer-show-componenet', require('./components/CustomerShow.vue').default);
Vue.component('customer-payment-module', require('./components/CustomerPayment.vue').default);

Vue.component('add-stock-component', require('./components/AddStockComponent.vue').default);

Vue.component('point-of-sales-component', require('./components/PosComponent.vue').default);

//Modules
//For Edit User
Vue.component('edit-user-module', require('./components/modules/EditUserModule.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
});
