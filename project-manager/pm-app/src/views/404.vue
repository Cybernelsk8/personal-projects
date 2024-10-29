<script setup>
    import { useGlobalStore } from '../stores/global'

    const global = useGlobalStore()

</script>

<template>
    <div class="h-screen background bg-no-repeat bg-cover bg-center ">
        <a href="../../" class="px-4 fixed top-14 cursor-pointer  left-0 bg-lime-muni rounded-r-lg w-36 py-4 border-r-2 border-y-2 border-blue-muni">
            <icon icon="fas fa-house-user" class="text-blue-muni text-3xl font-extrabold" />
            <span class="text-blue-muni text-xl font-extrabold">
                Inicio
            </span>
        </a>
        <div class="grid lg:grid-cols-2 h-screen">
            <div></div>
            <div class="flex flex-col">
                <div class="flex-grow"></div>
                <div class=" flex-grow text-center self-center">
                    <logo class="w-48 mx-auto" />
                    <img src="../assets/img/404.png" alt="404 page not found" class=" mx-auto w-[35rem]">
                    <h2 class="text-4xl font-semibold text-blue-muni">Página no encontrada.</h2>   
                </div>
                <span class="flex-grow text-blue-muni font-medium text-center ">© {{ global.year.getFullYear() }} Dirección de Catastro y Administración del IUIS</span>
            </div>
        </div>
    </div>
</template>

<style scoped>
.background{
    background-image: url('../assets/img/bg.jpg');
}

</style>