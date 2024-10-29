<script setup>
    import { useRoute } from 'vue-router';
    import { useGlobalStore } from '../stores/global'
    const store = useGlobalStore()

    const router = useRoute()

</script>

<template>

    <div class="top-0 bg-blue-muni border-2 rounded-br-full border-blue-800 py-3 pl-4 pr-8 text-white font-bold text-3xl text-center flex gap-3">
        <Icon :icon="store.titlePage.icon" />
        <h1 class="whitespace-nowrap" >{{ router.name }}</h1>
    </div>
</template>