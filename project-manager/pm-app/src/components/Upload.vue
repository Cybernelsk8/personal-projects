<script setup>
    import { ref, computed , watch } from 'vue';
    import ProgressBar from './ProgressBar.vue'

    const emit = defineEmits(['sendFile'])

    const props = defineProps({
        icon : {
            default : 'fas fa-upload'
        },
        accept : {
            default : '*'
        },
        processing : {
            default : false
        },
        finishProcess : {
            default : false
        }
    })

    const progress = ref(0)

    const file = ref({
        success : false ,
        name : 'No hay archivo seleccionado',
        size : 0
    })

    const fileInputRef = ref(null);

    const finish = computed( () => props.finishProcess )

    const handleFileChange = async (event) => {
        
        const files = event.target.files[0]

        console.log(files)
        
        file.value.name = files.name
        file.value.size = Math.round(files.size/1024)
        
        if (files) {
            const progressHandler = (event) => {
                progress.value = Math.round((event.loaded / event.total) * 100)
            }
            await emit('sendFile',files,progressHandler)

        }
        file.value.success = true
    }

    function clearFile () {
        file.value = {
            success: false,
            name: 'No hay archivo seleccionado',
            size: 0,
        }

        fileInputRef.value.value = ''
        progress.value = 0
    }

    watch(finish,() => clearFile())

</script>

<template>
    <div class="grid relative hover:scale-110">
        <label class="grid text-gray-300 justify-items-center cursor-pointer">
            <div class="flex justify-center">
                <Icon icon="fas fa-file" class="aspect-square absolute h-[100%]" :class="{'text-green-200' : progress == 100}"/>
                <Icon v-if="progress == 100" icon="fas fa-check" class="text-green-400 animate-rotate-y absolute aspect-square h-[40%] top-1/3"/>
                <Icon v-if="!file.success" icon="fas fa-arrow-up-from-bracket" class="text-gray-100 animate-bounce absolute aspect-square h-[35%] top-[40%]"/>
                <Icon v-if="progress < 100 && progress > 1 " icon="fas fa-arrows-rotate" class="text-gray-100 animate-spin absolute aspect-square h-[35%] top-1/3"/>
            </div>
            <input ref="fileInputRef" @change="handleFileChange" type="file" :accept="props.accept" hidden :disabled="props.processing">
            <ProgressBar v-if="progress" :progress="progress" class="absolute -bottom-2"/>
        </label>
        <Icon v-if="progress == 100" @click="clearFile" icon="fas fa-circle-xmark" class="text-red-500 absolute hover:scale-110 aspect-square h-[25%] top-0 right-0"/>

    </div>

</template>