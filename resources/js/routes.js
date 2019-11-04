import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
	//mode: 'history', // Evita que aparezca # en las rutas, Ej. #/home
	//base: process.env.BASE_URL,
	routes: [

		{
			path: '/inicio',
			name: 'inicio',
			component: require('./views/Home').default,
			meta : { title :  'Inicio | Gestion - Procesos' }
		},

		{
			path: '/tareas',
			name: 'tareas',
			component: require('./views/Tasks').default,
			props: true,
			meta : { title :  'Tareas | Gestion - Procesos' }
		},

		{
			path: '/detalle-tarea/:id?',
			name: 'detalle-tarea',
			component: require('./views/DetailTask').default,
			props: true,
			meta : { title :  'Detalle Tarea | Gestion - Procesos' }
		},

		{
			path: '/reportes',
			name: 'reportes',
			component: require('./views/Reports').default,
			meta : { title :  'Reportes | Gestion - Procesos' }
		},

		{
			path: '/origenes',
			name: 'origenes',
			component: require('./views/Origins').default,
			meta : { title :  'Origenes | Gestion - Procesos' }
		},

		/*{
			path: '*',
			component: require('./views/Home').default
		}*/
	],
})


