<script setup>
    import { useAuthStore } from '../stores/auth'
    import { ref, shallowRef } from 'vue'


    
    const props = defineProps(['tabs'])
    const currentTab = shallowRef(props.tabs[0].component)
    const active = ref(props.tabs[0].title)
    const auth = useAuthStore()

    

</script>

<template>
    <nav class="bg-blue-500 rounded-bl-full rounded-tr-full py-5 text-gray-300 font-semibold">
        <div class="flex justify-center items-center space-x-10">
            <div v-for="(tab,index) in tabs" :key="index">
                <button v-if="auth.checkPermission(tab.title)" @click="currentTab = tab.component, active = tab.title" class="hover:text-white hover:font-bold hover:border-b cursor-pointer transition-all" :class="{'font-bold text-white border-b' : active == tab.title}">
                    {{ tab.title }}
                </button>
            </div>
        </div>
    </nav>
    <component :is="currentTab" ></component>
</template>
