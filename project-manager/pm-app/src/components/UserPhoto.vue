<script setup>
    import { ref, onMounted, watch } from 'vue'

    const props = defineProps(['user'])
    const exist = ref(false)

    function verificarImagen(){

        var img = new Image()
        img.src = props.user?.image

        img.onload = function() {
            exist.value = true
        }
        
        img.onerror = function() {
            exist.value = false
        }
    }


    watch(()=> props.user?.image, () => {
        verificarImagen()
    })
    
    onMounted( () => {
        verificarImagen()
    })
    


</script>

<template>
        <img v-if="exist" :src="props.user?.image" class="rounded-full bg-gray-300 object-cover" >
        <span v-else class="text-slate-900 font-bold rounded-full overflow-hidden bg-gray-300 flex justify-center items-center">
            {{ user?.inicial }}
        </span>
</template>