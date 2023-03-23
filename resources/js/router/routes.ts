export default [
	{
		path: '/',
		component: () => import('../pages/Home.vue'),
		name: 'home',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/process',
		component: () => import('../pages/documents/Process.vue'),
		name: 'process',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/finished',
		component: () => import('../pages/documents/Finished.vue'),
		name: 'finished',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/rejected',
		component: () => import('../pages/documents/Rejected.vue'),
		name: 'rejected',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/backup',
		component: () => import('../pages/documents/Backup.vue'),
		name: 'backup',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/organizations',
		component: () => import('../pages/settings/Organizations.vue'),
		name: 'organizations',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/rejecttypes',
		component: () => import('../pages/settings/RejectTypes.vue'),
		name: 'rejecttypes',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/subscribes',
		component: () => import('../pages/Subscribes.vue'),
		name: 'subscribes',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/positions',
		component: () => import('../pages/settings/Positions.vue'),
		name: 'positions',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/bans',
		component: () => import('../pages/settings/Bans.vue'),
		name: 'bans',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/password',
		component: () => import('../pages/Password.vue'),
		name: 'password',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/users',
		component: () => import('../pages/settings/Users.vue'),
		name: 'users',
		meta: {
			guard: 'auth'
		},
	},
	{
		path: '/login',
		component: () => import('../pages/Login.vue'),
		name: 'login',
		meta: {
			guard: 'guest'
		}
	},
	{
		path: '/register',
		component: () => import('../pages/Register.vue'),
		name: 'register',
		meta: {
			guard: 'guest'
		}
	}
];