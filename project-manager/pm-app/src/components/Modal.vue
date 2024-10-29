<script setup>
    const props = defineProps({
        open:{
            type: Boolean,
            default : false
        },
        title : {
            type : String,
            default : ''
        },
        icon : ''
    })
    defineOptions({
        inheritAttrs: false
    })
</script>

<template>
    <Transition>
        <div v-show="props.open" class ='inset-0 fixed h-screen bg-gray-900 bg-opacity-30 z-30 overflow-y-auto'>
            <div  class="relative flex justify-center mt-6">
                <div class = "bg-white mx-4 max-w-7xl min-w-96 rounded-xl shadow-lg overflow-hidden" v-bind="$attrs">
                    <header v-if="$props.title" class="flex items-center justify-between py-2 relative px-2 bg-slate-800">
                        <div class="flex items-center gap-x-2 text-slate-50">
                            <Icon v-if="props.icon" :icon="props.icon" class="text-2xl" />
                            <h1 class="text-2xl font-medium tracking-tight text-center">{{ props.title }}</h1>
                        </div>
                        <slot name="close"></slot>
                    </header>
                    <section class="py-4 px-4">
                        <slot></slot>
                    </section>
                    <hr v-if="$slots.footer">
                    <footer v-if="$slots.footer" class= "p-4 flex justify-between">
                        <slot name="footer"></slot>
                    </footer>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style>
    .v-enter-active, .v-leave-active {
        transition: opacity 0.5s ease;
    }

    .v-enter-from, .v-leave-to {
        opacity: 0;
    }
</style>