<script setup>
    import { onMounted } from 'vue';
    import { useManagerProjectStore } from '../stores/manager-project'
    import UserPhoto from '../components/UserPhoto.vue'

    const store = useManagerProjectStore()

    onMounted(() => {
        store.fetchTasks()
        store.fetchStatuses()        
        store.fetchProjects()        
        store.fetchUsers()        
    })
    
</script>

<template>
    <div class="flex gap-4">
        <Card class=" bg-slate-900 p-8 text-slate-300">
            <template #header>
                <div class="flex gap-4 items-center">
                    <Icon icon="fas fa-list-check" class="text-2xl" />
                    <h1 class="text-xl">Manager tasks</h1>
                </div>
                <hr class="my-4 border-slate-700">
            </template>
            <ul class="grid gap-y-3">
                <li @click="store.fetchTasks()" class="flex items-center justify-between hover:bg-slate-700 rounded-lg px-1 py-1 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <Icon icon="fas fa-list-check" />
                        <span>All tasks</span>
                    </div>
                </li>
                <li v-for="status in store.statuses" @click="store.getStatus(status.id)" 
                    class="flex items-center justify-between hover:bg-slate-700 rounded-lg pl-2 py-1 cursor-pointer"
                    :class="{' bg-slate-700 font-bold' : status.active}">
                    <div class="flex items-center gap-3">
                        <Icon :icon="status.icon" />
                        <span :class="`text-${status.color}`">{{ status.name }}</span>
                    </div>
                    <span class="bg-slate-700 w-8 flex justify-center rounded-lg">{{ status.tasks_count}}</span>
                </li>
            </ul>
            <template #footer>
                <hr class="my-4 border-slate-700">
                <Button @click="store.openModalNewProject = true" text="Add New Project" icon="fas fa-plus" class="btn-dark rounded-lg" />
            </template>
        </Card>
        <Card class="flex-1 bg-slate-900 p-8 text-slate-300">
           <Data-Table :headers="store.headers" :data="store.tasks" :loading="store.loading.statuses">
                <template #status.id="{item}">
                    <span class="text-xs py-1 px-2 rounded-full" :class="`bg-${item.status.color}`">
                        {{ item.status.name }}
                    </span>
                    <span class="bg-orange-400 text-orange-400"></span>
                    <span class="bg-gray-500 text-gray-500"></span>
                </template>
                <template #user.name="{item}">
                    <Tool-Tip :message="item.user.name" class="-mt-6 -ml-[50%]">
                        <UserPhoto :user="item.user" class="h-10 w-10 text-2xl" />
                    </Tool-Tip>
                </template>
                <template #actions="{item}">
                    <Icon @click="store.editTask(item)" icon="fas fa-ellipsis-vertical" class="text-gray-300 text-xl py-2 px-4 cursor-pointer" />
                </template>
           </Data-Table> 
        </Card>
    </div>

    <p></p>

    <Modal :open="store.openModalNewProject" title="New Project" icon="fas fa-list-check">
        <template #close>
            <Icon @click="store.resetData()" icon="fas fa-xmark" class="text-slate-400 text-2xl cursor-pointer" />
        </template>
        <div class="">
            <Input option="label" title="Title project" v-model="store.project.title" :error="store.errors.hasOwnProperty('title')" />
            <Input option="text-area" title="Description project" v-model="store.project.description" :error="store.errors.hasOwnProperty('description')" />
            <template v-for="(task,index) in store.project.tasks">
                <hr>
                <br>
                <div class="flex items-center gap-2">
                    <Input option="label" title="Title Task" v-model="task.title" :error="store.errors.hasOwnProperty('title')" />
                    <Select-Search :items="store.users" placeholder="SELECT USER" :fields="['id','name']" class="-mt-3" v-model="task.user_id" />
                    <Icon @click="store.removeTask(index)" icon="fas fa-xmark" class="text-red-500 cursor-pointer" />
                </div>
                <Input option="text-area" title="Description task" v-model="task.description" :error="store.errors.hasOwnProperty('description')" />
            </template>
            <div class="flex justify-center">
                <Button @click="store.addTask()" text="Add Task" icon="fas fa-plus" class="btn-dark rounded-lg" />
            </div>
        </div>
        <template #footer>
            <Button @click="store.resetData()" text="Cancel" icon="fas fa-xmark" class="btn bg-slate-900 text-slate-400 rounded-lg" />
            <Button @click="store.storeProjectTasks()" text="Create" icon="fas fa-plus" class="btn-danger rounded-lg" />
        </template>
    </Modal>

    <template v-if="store.task.hasOwnProperty('id')">
        <Modal :open="store.openModalEditTask" title="Edit task" icon="fas fa-edit" class=" w-1/3">
            <template #close>
                <Icon @click="store.resetData()" icon="fas fa-xmark" class="text-slate-400 text-2xl cursor-pointer" />
            </template>
            <div class="grid gap-5">
                <span class="grid">
                    TITLE TASK
                    <Input v-model="store.task.title" />
                </span>
                <span class="grid">
                    DESCRIPTION TASK 
                    <textarea v-model="store.task.description" rows="5" class="input p-4"></textarea>
                </span>
                <span class="grid">
                    PROJECT
                    <Select-Search placeholder="SELECT PROJECT" :items="store.projects" :fields="['id','title']" v-model="store.task.project_id" :error="store.errors.hasOwnProperty('project_id')" />
                </span>
                <span class="grid">
                    ASSIGNE USER 
                    <Select-Search placeholder="SELECT USER" :items="store.users" :fields="['id','name']" v-model="store.task.user_id" :error="store.errors.hasOwnProperty('user_id')" />
                </span>
                <span class="grid">
                    STATUS TASK 
                    <Select-Search placeholder="SELECT USER" :items="store.statuses" :fields="['id','name']" v-model="store.task.status_id" :error="store.errors.hasOwnProperty('user_id')" />
                </span>
            </div>
            <template #footer>
                <Button @click="store.resetData()" text="Cancel" icon="fas fa-xmark" class="btn bg-slate-900 text-slate-400 rounded-lg" />
                <Button text="Update" icon="fas fa-arrows-rotate" class="btn-danger rounded-lg" />
            </template>
        </Modal>
    </template>
</template>

