import { createRouter, createWebHistory } from 'vue-router'
import Layout from '../layouts/Default.vue'
import UnAuthorize from '../views/401.vue'
import NotFound from '../views/404.vue'
import { useAuthStore } from '../stores/auth'



const router = createRouter({
	history: createWebHistory(import.meta.env.VITE_MY_BASE),
	routes: [
		{
			path: '/',
			component: Layout,
			children: [
				{
					path: 'projects',
					name: 'Projects',
					component: () => import('../views/Projects.vue'),
					meta: {
						auth : true
					}
				},
				{
					path: 'kamban/:project_id',
					name: 'Kamban',
					component: () => import('../views/Kamban.vue'),
					props : true,
					meta: {
						auth : true
					}
				},
				{
					path: 'manager-project',
					name: 'Manager Project',
					component: () => import('../views/ManagerProject.vue'),
					meta: {
						auth : true
					}
				}
			]
		},
		{
			path: '/login',
			name: 'Login',
			component: () => import('../views/Login.vue'),
		},
		{
			path: '/register',
			name: 'Register',
			component: () => import('../views/Register.vue'),
		},
		{
			path: '/401',
			name: '401',
			component: UnAuthorize,
		},
		{
			//MANEJA TODAS LAS PAGINAS QUE NO EXISTEN Y LA REDIRIJE AL 404 NOT FOUND
			path: '/:catchAll(.*)',
			component: NotFound,
		}
	]
})

router.beforeEach((to, from) => {

	const auth = useAuthStore()
	if(!localStorage.getItem('key') && to.name != 'Login'){
		return { name : 'Login'}
	}

	if (to.meta.auth) {

		const hasPermission = auth.user;

		if (!hasPermission) {

			return { name : 'Login'};
		}
	}
	return true
  
})

export default router
