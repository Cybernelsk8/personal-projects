<script setup>
    import { watchEffect } from 'vue'
    import { useKambanStore } from '../stores/kamban'
    import draggable from 'vuedraggable'

    const store = useKambanStore()
    const props = defineProps(['project_id'])

    watchEffect(() => {
        store.fetchTasksByStatus(props.project_id)
    })

</script>

<template>
    <div class="flex gap-4 justify-evenly">
        <Card v-for="status in store.tasksByStatus" class="bg-slate-900 p-5 w-96">
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
                        <div class="py-4">
                            <Card class="bg-gray-700 p-3 text-gray-400 cursor-move">
                                <header>
                                    <h1 class="text-xl font-medium">
                                        {{ task.title }}
                                    </h1>
                                </header>
                                <div class="pb-2 grid gap-3 text-sm">
                                    <p>
                                        {{ task.description }}
                                    </p>
                                </div>
                                <template #footer>
                                    <div class="flex justify-between">
                                        <div class="flex items-center gap-3">
                                            <Icon icon="fas fa-calendar-days"/>
                                            {{ new Date(task.created_at).toDateString() }}
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <Icon icon="fas fa-edit" />
                                            <Icon icon="fas fa-trash" />
                                        </div>
                                    </div>
                                </template >
                            </Card>
                        </div>
                    </template>
                </draggable>
            </div>

            <template #footer>
                <Button v-if="status.id == 1" text="Add Task" class="btn-primary rounded-md w-1/2 self-center" icon="fas fa-plus" />
            </template>
        </Card>
    </div>
</template>
