import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useKambanStore = defineStore('kamban', () => {

    const tasksByStatus = ref([])
    const task = ref({})
    const loading = ref({
        index : false,
        store : false
    })
    const errors = ref([])

    async function fetchTasksByStatus (project_id) {
        try {
            loading.value.index = true
            const response = await axios.get('pm/tasks/tasks-by-status/'+ project_id)
            tasksByStatus.value = response.data
        } catch (error) {
            console.error(error)
        } finally {
            loading.value.index = false
        }
    }

    return {
        tasksByStatus,
        task,
        loading,
        errors,

        fetchTasksByStatus,
    }
})
