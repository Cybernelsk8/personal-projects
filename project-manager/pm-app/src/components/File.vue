<script setup>
    import { ref,computed,watch } from 'vue'
    import ProgressBar from './ProgressBar.vue'

    const emit = defineEmits(['sendFile'])

    const props = defineProps({
        icon : {
            default : 'fas fa-upload'
        },
        accept : {
            default : '*'
        },
        loading : {
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
    <div class="grid w-full">
        <div class="border-2 w-full rounded-lg overflow-hidden flex items-center relative " :class="{'border-green-500 active:border-green-700' : props.loading == false, 'border-gray-500 active:border-gray-700' : props.loading == true,}">
            <label class="flex cursor-pointer w-full" :class="{'cursor-pointer' : props.loading == false , 'cursor-wait' : props.loading == true}">
                <div class="p-2 btn-success space-x-3 font-semibold select-none" :class="{'btn-success' : props.loading == false, 'btn-dark' : props.loading == true}">
                    <icon :icon="props.icon" class="text-lg" />
                    <span>Seleccione un archivo y se procesara</span>
                </div>
                <input ref="fileInputRef" @change="handleFileChange" type="file" :accept="props.accept" hidden :disabled="props.loading">
                <span class=" self-center flex-1 pl-4 pr-8 text-gray-500 font-semibold select-none flex justify-between">
                    <span>{{ file.name }}</span>
                    <div>
                        <span>Size: {{ file.size >= 1024 ? Math.round(file.size / 1024) : file.size }} </span>
                        <span>{{ file.size >= 1024 ? ' mb' : ' kb' }}</span>
                    </div>
                </span>
            </label>
            
            <icon v-if="file.success" @click="clearFile" icon="fas fa-trash" class="text-red-500 absolute right-0 mr-2 cursor-pointer hover:scale-125" />
        </div>
        <ProgressBar :progress="progress" class="mt-1" />
    </div>
</template>