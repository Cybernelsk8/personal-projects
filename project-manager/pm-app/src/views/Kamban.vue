<script setup>
    import { onMounted } from 'vue'
    import { useKambanStore } from '../stores/kamban'
    import draggable from 'vuedraggable'

    const store = useKambanStore()


    onMounted(() => {
        store.fetch()
        store.fetchStatus()
    })

</script>

<template>
    <div class="flex gap-4 justify-evenly">
        <Card v-for="status in store.statuses" class="bg-slate-900 p-5 w-96">
            <template #header>
                <div class="text-gray-300 font-semibold flex justify-between">
                    <div class="flex gap-2 items-center">
                        <Icon :icon="status.icon" />
                        <h1 :class="`text-${status.color}`">{{ status.name }}</h1>
                    </div>
                    <div>
                        <Icon icon="fas fa-ellipsis" />
                    </div>
                </div>
            </template>

            <div class="h-full">
                <draggable v-model="status.tasks" tag="ul" group="store.statuses" :animation="300" class="h-full">
                    <template #item="{element : task}">
                        <Card class="bg-gray-700 p-4 text-gray-400 cursor-move">
                            <header>
                                <h1 class="text-xl font-medium">
                                    {{ task.title }}
                                </h1>
                            </header>
                            <div class="py-3 grid gap-3">
                                <p>
                                    {{ task.description }}
                                </p>
                            </div>
                            <template #footer>
                                <div class="flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <Icon icon="fas fa-calendar-days" class="text-xl"/>
                                        {{ new Date(task.created_at).toDateString() }}
                                    </div>
                                    <div class="flex items-center gap-3 text-xl">
                                        <Icon icon="fas fa-edit" />
                                        <Icon icon="fas fa-trash" />
                                    </div>
                                </div>
                            </template >
                        </Card>
                    </template>
                </draggable>
            </div>

            <template #footer>
                <Button text="Add Task" class="btn-primary rounded-md w-1/2 self-center" icon="fas fa-plus" />
            </template>
        </Card>
    </div>
    <Modal :open="store.openModalNewProject" title="New Project" icon="fas fa-plus">
        <template #close>
            <Icon @click="store.resetData()" icon="fas fa-xmark" class="text-slate-100 text-2xl cursor-pointer" />
        </template>
        <Input option="label" title="title project" v-model="store.project.title" />
        <Input option="text-area" title="description project" rows="5" v-model="store.project.description" />
        <template #footer>
            <Button @click="store.resetData()" text="Cancel" icon="fas fa-xmark" class="btn-danger" />
            <Button @click="store.storeProject()" text="Save" icon="fas fa-save" class="btn-dark" />
        </template>
    </Modal>
    <Modal :open="store.openModalNewTask" title="New Task" icon="fas fa-plus">
        <template #close>
            <Icon @click="store.resetData()" icon="fas fa-xmark" class="text-slate-100 text-2xl cursor-pointer" />
        </template>
        <Input option="label" title="title task" v-model="store.task.title" />
        <Input option="text-area" title="description task" rows="5" v-model="store.task.description" />
        <template #footer>
            <Button @click="store.resetData()" text="Cancel" icon="fas fa-xmark" class="btn-danger" />
            <Button @click="store.storeProject()" text="Save" icon="fas fa-save" class="btn-dark" />
        </template>
    </Modal>
</template>
