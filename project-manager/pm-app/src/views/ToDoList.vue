<script setup>
    import { onMounted } from 'vue';
    import { useToDoListStore } from '../stores/to-do-list'
    const store = useToDoListStore()

    onMounted(() => store.fetch())
    
</script>

<template>
    <div class="flex gap-4">
        <Card class=" bg-slate-900 p-8 text-slate-300">
            <template #header>
                <div class="flex gap-4 items-center">
                    <Icon icon="fas fa-clipboard-list" class="text-2xl" />
                    <h1 class="text-xl">To Do List</h1>
                </div>
                <hr class="my-4 border-slate-700">
            </template>
            <ul>
                <li class="flex items-center justify-between hover:bg-slate-700 rounded-lg px-1 py-1 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <Icon icon="fas fa-list-check" />
                        <span>Inbox</span>
                    </div>
                    <span class="bg-slate-700 px-2 py-1 rounded-lg">{{ store.tasksUser.length }}</span>
                </li>
            </ul>
            <template #footer>
                <hr class="my-4 border-slate-700">
                <Button text="Add New Task" icon="fas fa-plus" class="btn-dark rounded-lg" />
            </template>
        </Card>
        <Card class="flex-1 bg-slate-900 p-8 text-slate-300">
           <Data-Table :headers="store.headers" :data="store.tasksUser" :loading="store.loading" color="bg-slate-900" /> 
        </Card>
    </div>
</template>

