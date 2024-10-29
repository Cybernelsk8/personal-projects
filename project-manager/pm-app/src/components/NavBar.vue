<script setup>
    import { useGlobalStore } from '../stores/global'
    import UserCard from './UserCard.vue'
    
    import Logo from './Logo.vue'
    
    const global = useGlobalStore()

    

</script>

<template>
    <nav class="flex justify-between px-3 items-center h-16 bg-slate-900 relative text-gray-300 shadow-lg ">
        <div class="flex items-center gap-3">
            <div v-if="!global.showSide" class="flex font-bold items-center justify-between w-56">
                <div class="flex items-center">
                    <Logo class="fill-gray-300 h-12 w-auto"  />
                    <h1 class="text-2xl">CyberSoft</h1>
                </div>
                <Icon @click="global.toggleSide" icon="fas fa-bars" class="text-xl cursor-pointer" />
            </div>
            <div class="flex items-center gap-4">
                <Tool-Tip message="To Do list" class="text-gray-300 mt-4">
                    <Icon @click="$router.push({name:'To Do List'})" icon="far fa-clipboard" class="text-xl cursor-pointer" />
                </Tool-Tip>
                <Tool-Tip message="Kanban" class="text-gray-300 mt-4">
                    <Icon @click="$router.push({name:'Kamban'})" icon="fas fa-table-columns" class="text-xl cursor-pointer" />
                </Tool-Tip>
                <Tool-Tip message="Chat" class="text-gray-300 mt-4">
                    <Icon icon="far fa-comment" class="text-xl cursor-pointer" />
                </Tool-Tip>
                <Input type="search" icon="fas fa-search" placeholder="search ..." />
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="mr-3 flex gap-4">
                <div class="relative">
                    <Icon icon="far fa-envelope" class="text-xl" />
                    <Icon icon="fas fa-circle" class="text-[8px] text-red-500 absolute"/>
                    <Icon icon="fas fa-circle" class="text-[8px] animate-ping text-red-500 absolute"/>
                </div>
                <div class="relative">
                    <Icon icon="far fa-bell" class="text-xl" />
                    <Icon icon="fas fa-circle" class="text-[8px] text-red-500 absolute"/>
                    <Icon icon="fas fa-circle" class="text-[8px] animate-ping text-red-500 absolute"/>
                </div>
            </div>
            <UserCard />
            
        </div>
    </nav>
</template>