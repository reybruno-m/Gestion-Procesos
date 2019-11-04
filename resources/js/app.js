require('./bootstrap');

//window.Vue = require('vue');
//window.Axios = require('axios').default;

import Vue from "vue";
import axios from "axios";

window.Vue = Vue;

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + Laravel.apiToken,
};

window.Vue.prototype.$http = axios;


Vue.component('module', require('./components/AppComponent.vue').default);
Vue.component('home', require('./views/Home.vue').default);
Vue.component('detail-task-component', require('./components/tasks/DetailTaskComponent.vue').default);

Vue.component('list-origins-component', require('./components/origins/ListOriginsComponent.vue').default);
Vue.component('form-origins-component', require('./components/origins/FormOriginsComponent.vue').default);
Vue.component('list-tasks-component', require('./components/tasks/ListTasksComponent.vue').default);
Vue.component('form-tasks-component', require('./components/tasks/FormTasksComponent.vue').default);
Vue.component('users-managment-component', require('./components/managment/UsersManagmentComponent.vue').default);
Vue.component('roles-managment-component', require('./components/managment/RolesManagmentComponent.vue').default);
Vue.component('miscs-managment-component', require('./components/managment/MiscsManagmentComponent.vue').default);
Vue.component('states-managment-component', require('./components/managment/StatesManagmentComponent.vue').default);
Vue.component('reports-component', require('./components/reports/ReportsComponent.vue').default);

import moment from 'moment';

Vue.filter('formatDate', function(value) {
	if (value) {
		return moment(String(value)).format('DD-MM-YYYY hh:mm')
	}
});

Vue.filter('formatDateMov', function(value) {
	if (value) {
		return moment(String(value)).format('DD-MM-YY')
	}
});




import router from './routes';

router.push('inicio')

const workspace = new Vue({
    el: '#workspace',
    router
});

