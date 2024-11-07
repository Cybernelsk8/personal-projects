import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from './global'
import { useRouter } from 'vue-router'

export const useProjectsStore = defineStore('projects', () => {
   
    const global = useGlobalStore()
    const router = useRouter()

    const projects = ref([])
    const project = ref({})
    const loading = ref({
        index : false,
        store : false,
    })
    const errors = ref([])
    const openModal = ref({
        new : false,
    })

    async function fetch () {
        try {
            loading.value.index = true
            const response = await axios.get('pm/projects/index')
            projects.value = response.data
        } catch (error) {
            errors.value = error
            console.error(error)
        } finally {
            loading.value.index = false
        }
    }

    function store () {
        loading.value.store = true
        axios.post('pm/projects/store',project.value)
        .then(response => {
            fetch()
            global.setAlert(response.data,'success')
            resetData()
        })
        .catch(error => {

            if(error.response.data.message && error.response.data.errors) {
                errors.value = error.response.data.errors
            }else {
                console.log(error)
            }

            console.error(error)
        })
        .finally(() => loading.value.store = false)
    }

    function pushKamban (item) {
        router.push({
            name : 'Kamban',
            params : {
                project_id : item.id
            }
        })
    }

    function resetData () {
        project.value = {}
        openModal.value = {
            new : false
        }
        errors.value = []
    }
    
    return {

        projects,
        project,
        loading,
        errors,
        openModal,

        fetch,
        store,
        resetData,
        pushKamban
    }
})
