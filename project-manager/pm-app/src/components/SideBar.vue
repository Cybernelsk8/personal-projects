<script setup>
    import { useGlobalStore } from '../stores/global'

    import Logo from './Logo.vue'

    const global = useGlobalStore()

</script>

<template>
    <div v-if="global.showSide" class="w-60 bg-slate-900 text-gray-300 flex flex-col">
        <div class="flex items-center h-16 w-60 pl-3 justify-between">
            <div class="flex items-center">
                <Logo class="fill-gray-300 h-12 w-auto"/>
                <h1 class="text-2xl font-bold">CyberSoft</h1>
            </div>
            <Icon @click="global.toggleSide" icon="fas fa-angles-left" class="text-xl cursor-pointer" />
        </div>
        <div class="flex-1 overflow-x-auto no-scrollbar px-2 pt-5 border-r-2 border-slate-700">
            <ul class="grid gap-y-3">
                <li v-for="i in 100" class="flex items-center gap-3 text-sm hover:bg-slate-800 px-4 py-2 rounded-md cursor-pointer group">
                    <Icon icon="fas fa-circle" class="group-hover:text-blue-900" />
                    {{ `Option ${i}` }}
                </li>
            </ul>
        </div>
        <span class="h-8 border-r-2 border-slate-700"></span>
    </div>
</template>
<style scoped>

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }


    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

