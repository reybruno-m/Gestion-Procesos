import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
	routes: [

		{
			path: '/inicio',
			name: 'inicio',
			component: require('./views/Home').default
		},

		{
			path: '/tareas',
			name: 'tareas',
			component: require('./views/Tasks').default,
			props: true
		},

		{
			path: '/reportes',
			name: 'reportes',
			component: require('./views/Reports').default
		},

		{
			path: '/origenes',
			name: 'origenes',
			component: require('./views/Origins').default,
		},

		{
			path: '*',
			component: require('./views/Home').default
		}
	],

	mode: 'history', // Evita que aparezca # en las rutas, Ej. #/home

})


