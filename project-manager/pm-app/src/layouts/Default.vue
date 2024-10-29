<script setup>
    import { useGlobalStore } from '../stores/global'
    import NavBar from '../components/NavBar.vue'
    import SideBar from '../components/SideBar.vue'
    import Footer from '../components/Footer.vue'

</script>

<template>
    <main class="h-screen flex">
        <SideBar />
        <section class="flex-1">
            <article class="h-full flex flex-col">
                <NavBar />
                <div id="main" class=" overflow-auto flex-1 flex flex-col">
                    <div id="content" class="flex-1 p-4">
                        <RouterView />
                    </div>
                    <Footer />
                </div>
            </article>
        </section>
    </main>
</template>

