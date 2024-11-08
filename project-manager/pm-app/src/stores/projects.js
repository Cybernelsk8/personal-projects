import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from './global'
import { useRouter } from 'vue-router'
import { useKambanStore } from './kamban'

export const useProjectsStore = defineStore('projects', () => {
   
    const global = useGlobalStore()
    const router = useRouter()
    const kamban = useKambanStore()

    const projects = ref([])
    const project = ref({})
    const users = ref([])
    const loading = ref({
        index : false,
        store : false,
    })
    const errors = ref([])
    const openModal = ref({
        new : false,
        edit : false,
    })

    async function fetch () {
        try {
            loading.value.index = true
            const response = await axios.get('pm/projects/projects-by-user')
            projects.value = response.data
        } catch (error) {
            errors.value = error
            console.error(error)
        } finally {
            loading.value.index = false
        }
    }

    async function fetchUsers () {
        try {
            loading.value.index = true
            const response = await axios.get('users')
            users.value = response.data
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

    function edit (item) {
        project.value = item
        openModal.value.edit = true
    }

    function pushKamban (item) {
        kamban.tasksByStatus = []
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
            new : false,
            edit : false,
        }
        errors.value = []
    }
    
    return {

        projects,
        project,
        users,
        loading,
        errors,
        openModal,

        fetch,
        fetchUsers,
        store,
        edit,
        resetData,
        pushKamban,
    }
})
