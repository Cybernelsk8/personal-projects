import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

export const useAuthStore = defineStore('auth', () => {

	const router = useRouter()

	const user = ref({})
	const loading = ref(false)
	const errors = ref([])

	const login = () => {
		
		loading.value = true
		axios.post('auth/login',user.value)
		.then(response => {
			user.value = response.data
			router.push({ name: 'Projects' })
		})
		.catch(error => {
			if(error.response.data.errors) {
				errors.value = error.response.data.errors
			}else {
				errors.value = error.response.data.message
			}
		})
		.finally(() => loading.value = false)
		

	}
	
	const validateAuth = () => {
		axios.post('auth/me')
		.then(response =>{
			user.value = response.data
		}) 		
		.catch(error => {
			resetData()
			router.push({name:'Login'})
		})
	}

	const resetData = () => {
		user.value = {}
		errors.value = []
		localStorage.clear()
	}

	const logout = () => {
		axios.post('logout')
		resetData()
		router.push({name:'Login'})
	}

	const checkPermission = (el) => {
		for (var key in permisos.value) {
			if (permisos.value.hasOwnProperty(key)) {
				var value = permisos.value[key];

				if (value === el) {
					return true;
				}

				if (typeof value === 'object' && checkPermission(el)) {
					return true;
				}
			}
		}

		return false;
	}

	function generateKey() {
		const caracteres = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ.,;:}{-+¿?¡¨*][abcdefghijñklmnopqrstuvwxyz0123456789';
		let cadenaAleatoria = '';
		for (let i = 0; i < 64; i++) {
			cadenaAleatoria += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
		}
		return cadenaAleatoria;
	}

	return {
		user,
 
		errors,
		loading,

		login,
		logout,
		validateAuth,
		checkPermission,
		generateKey,
	}
})
