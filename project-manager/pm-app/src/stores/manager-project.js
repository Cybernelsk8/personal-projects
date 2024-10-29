import axios from 'axios'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useGlobalStore } from '../stores/global'

export const useManagerProjectStore = defineStore('manager-project', () => {
    
    const global = useGlobalStore()

    const headers = [
        { title : 'title', key : 'title' },
        { title : 'description', key : 'description', class : 'w-96 truncate'},
        { title : 'project', key : 'project.title' },
        { title : 'created', key : 'created_at', type : 'date' },
        { title : 'status', key : 'status.id' },
        { title : 'ASSIGNE USER', key : 'user.name', align : 'center' },
        { title : '', key : 'actions', align : 'right' },
    ]
    const users = ref([])
    const projects = ref([])
    const tasks = ref([])
    const task = ref({})
    const statuses = ref([])
    const project = ref({
        title : '',
        description : '',
        tasks : []
    })

    const loading = ref({
        tasks : false,
        projects : false,
        users : false,
        statuses : false,
        store : false,
    })
    
    const errors = ref([])
    const openModalNewProject = ref(false)
    const openModalEditTask = ref(false)


    function fetchStatuses () {
        loading.value.statuses = true
        axios.get('pm/statuses/index')
        .then(response => {
            statuses.value = response.data
        })
        .catch(error => {
            errors.value = error.response.data.errors
        })
        .finally(() => loading.value.statuses = false)
    }

    function fetchProjects () {
        loading.value.statuses = true
        axios.get('pm/projects/index')
        .then(response => {
            projects.value = response.data
        })
        .catch(error => {
            errors.value = error.response.data.errors
        })
        .finally(() => loading.value.statuses = false)
    }

    function fetchUsers () {
        loading.value.statuses = true
        axios.get('users')
        .then(response => {
            users.value = response.data
        })
        .catch(error => {
            errors.value = error.response.data.errors
        })
        .finally(() => loading.value.statuses = false)
    }

    function fetchTasks () {
        loading.value.statuses = true
        statuses.value.forEach(el => el.active = false)
        axios.get('pm/tasks/index')
        .then(response => tasks.value = response.data)
        .catch(error => errors.value = error.response.data.error)
        .finally(() => loading.value.statuses = false)
    }

    function getStatus(id){
        
        statuses.value.forEach(el => (el.id == id) ? el.active = true : el.active = false )
              
        loading.value.statuses = true
        axios.get('pm/statuses/show/' + id)
        .then(response => tasks.value = response.data.tasks)
        .catch(error => errors.value = error.response.data.error)
        .finally(() => loading.value.statuses = false)
    }

    function addTask () {
        project.value.tasks.push({
            title : '',
            description : '',
            user_id : '',
        })
    }

    function removeTask (index) {
        project.value.tasks.splice(index,1)
    }

    function storeProjectTasks () {
        loading.value.store = true
        axios.post('pm/tasks/store/project-tasks',{
            project : project.value
        }).then(response => {
            global.setAlert(response.data,'success')
            fetchTasks()
            resetData()
        }).catch(error => {
            global.setAlert(error.response.data.error,'danger')
        })
        .finally(() => loading.value.store = false)

    }

    function editTask(item){
        task.value = item
        openModalEditTask.value = true
    }

    function resetData () {
        project.value = {
            title : '',
            description : '',
            tasks : []
        }

        openModalNewProject.value = false
        openModalEditTask.value = false
        errors.value = []
    }

    return {
        headers,
        projects,
        users,
        tasks,
        task,
        project,
        statuses,
        loading,
        errors,
        openModalNewProject,
        openModalEditTask,

        fetchStatuses,
        fetchTasks,
        fetchProjects,
        fetchUsers,
        getStatus,
        resetData,
        addTask,
        removeTask,
        storeProjectTasks,
        editTask,
    }
});
