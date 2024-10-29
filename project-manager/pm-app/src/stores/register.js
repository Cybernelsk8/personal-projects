import axios from 'axios';
import { defineStore } from 'pinia';
import { ref } from 'vue'

import { useRouter } from 'vue-router';


export const useRegisterStore = defineStore('register', () => {
    

    const router = useRouter()
    
    const data = ref({
        'name' : '',
        'email' : '',
        'password': '',
        'password_confirmation':''
    });

    const loading = ref(false)
    const errors = ref([])


    const register = () => {
        loading.value = true

        axios.post('auth/register',data.value)
        .then(response => {
            if(!response.data.error) {
                router.push({name:'Home'})
            }
        })
        .catch(error => {
            errors.value = error.response.data.errors
            console.error(error.response.data)
        })
        .finally(() => loading.value = false)
    }


    return {
        
        data,
        loading,
        errors,

        register,
    }
});
