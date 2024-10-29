import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'

export const useToDoListStore = defineStore('to-do-list', () => {
    
    const headers = [
        { title : 'title', key : 'title' },
        { title : 'description', key : 'description' },
        { title : 'project', key : 'project.title' },
        { title : 'created', key : 'created_at' },
        { title : 'status', key : 'status' },
        { title : '', key : 'actions' },
    ]
    const tasksUser = ref([])
    const task = ref({})
    const loading = ref(false)
    const errors = ref([])

    function fetch () {
        loading.value = true
        axios.get('pm/tasks/for-user')
        .then(response => tasksUser.value = response.data)
        .catch(error => {
            errors.value = error.response.data.errors
        })
        .finally(() => loading.value = false)
    }

    return {
        headers,
        tasksUser,
        task,
        loading,
        errors,

        fetch,
    }
});
