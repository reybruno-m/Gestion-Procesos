require('./bootstrap');

window.Vue = require('vue');

// Verifico si existe el DIV con ID app. 
// Solo si existe cargo los componentes.

if (document.getElementById("app")) {

	Vue.component('list-origins-component', require('./components/origins/ListOriginsComponent.vue').default);
	Vue.component('form-origins-component', require('./components/origins/FormOriginsComponent.vue').default);

	const app = new Vue({
	    el: '#app',
	});
}

if (document.getElementById("app2")) {

	Vue.component('example-component', require('./components/ExampleComponent.vue').default);

	const app = new Vue({
	    el: '#app2',
	});
}

