<script setup>
    import { onMounted } from 'vue';
    import { useProjectsStore } from '../stores/projects'

    const store = useProjectsStore()

    onMounted(() => store.fetch() )
</script>

<template>
    <div class="flex gap-4">
        <Card class=" bg-slate-900 p-8 text-slate-300">
            <template #header>
                <div class="flex gap-4 items-center">
                    <Icon icon="fas fa-diagram-project" class="text-2xl" />
                    <h1 class="text-xl">Manager project</h1>
                    <Icon @click="store.openModal.new = true" icon="fas fa-plus" class="icon-button bg-slate-500"  />
                </div>
                
            </template>
        </Card>
        <Card class="flex-1 bg-slate-900 p-8 text-slate-300">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                <template v-for="project in store.projects">
                    <Card v-if="project.deleted_at == null" class="border overflow-hidden relative">
                        <template #header>
                            <img @click="store.pushKamban(project)" src="../assets/img/muni.jpg" :alt="project.title" class="cursor-pointer">
                            <Icon icon="fas fa-gear" class="absolute text-slate-900 text-2xl top-2 right-2 cursor-pointer hover:scale-110 animate-spin" />
                        </template>
                        <div @click="store.pushKamban(project)" class="p-4 cursor-pointer">
                            <h1 class="text-xl font-medium pb-2">{{ project.title }}</h1>
                            <p class="font-light text-sm">{{ project.description }}</p>
                        </div>
                    </Card>
                </template>
            </div>
        </Card>
    </div>
    
    <Modal :open="store.openModal.new" title="Create new project" icon="fas fa-diagram-project" >
        <div>
            <Input v-model="store.project.title" option="label" title="project name" :error="store.errors.hasOwnProperty('name')" />
            <Input v-model="store.project.description" maxlength="255" option="text-area" title="project description" />
        </div>
        <Validate-Errors :errors="store.errors" v-if="store.errors != 0" />
        <template #footer>
            <Button @click="store.resetData()" text="Cancel" class="btn-dark rounded-lg" icon="fas fa-xmark" />
            <Button @click="store.store()" text="Create" class="btn-primary rounded-lg" icon="fas fa-plus" :loading="store.loading.store" />
        </template>
    </Modal>
</template>
