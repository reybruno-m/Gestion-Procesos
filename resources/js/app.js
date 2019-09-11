require('./bootstrap');

import moment from 'moment';

window.Vue = require('vue');

// Permite formatear fechas. 

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD-MM-YYYY hh:mm')
  }
});

// Verifico si existe el DIV con ID correspondiente a sus componentes. 
// Solo si existe cargo los componentes.

if (document.getElementById("origins")) 
{

	Vue.component('list-origins-component', require('./components/origins/ListOriginsComponent.vue').default);
	Vue.component('form-origins-component', require('./components/origins/FormOriginsComponent.vue').default);

	const app = new Vue({
	    el: '#origins',
	});
}



if (document.getElementById("requests")) 
{

	Vue.component('list-requests-component', require('./components/requests/ListRequestsComponent.vue').default);
	Vue.component('form-requests-component', require('./components/requests/FormRequestsComponent.vue').default);

	const app = new Vue({
	    el: '#requests',
	});
}

