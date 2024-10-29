import axios from 'axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useKambanStore = defineStore('kamban', () => {
    
    const projects = ref([])
    const project = ref({})
    const tasks = ref([])
    const task = ref({})
    const statuses = ref([])
    const errors = ref([])
    const loading = ref(false)

    const openModalNewProject = ref(false)
    const openModalNewTask = ref(false)

    function fetch (id = '') {
        loading.value = true
        axios.get('pm/projects/index')
        .then(response => projects.value = response.data)
        .catch(error => console.error(error.response.data))
        .finally(() => loading.value = false)
    }

    function fetchStatus () {
        axios.get('pm/statuses/tasks-user')
        .then(response => statuses.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    function resetData () {
        errors.value = []
        openModalNewProject.value = false
        task.value = {}
        openModalNewTask.value = false
    }

    function storeProject() {
        loading.value = true
        axios.post('pm/projects/store',project.value)
        .then(response => console.log(response.data))
        .catch(error => console.error(error.response.data))
    }

    return {
        projects,
        project,
        tasks,
        task,
        statuses,
        loading,
        errors,

        openModalNewProject,
        openModalNewTask,

        fetch,
        fetchStatus,
        resetData,

        storeProject,
    }
});
