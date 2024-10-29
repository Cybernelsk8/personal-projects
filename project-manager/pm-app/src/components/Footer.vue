<script setup>
    import { useGlobalStore } from '../stores/global'

    const global = useGlobalStore()
</script>
<template>
    <p class=" font-medium text-center text-slate-400"> Cybernelsk8 © 2024 - {{ global.year.getFullYear() }}</p>
</template>
