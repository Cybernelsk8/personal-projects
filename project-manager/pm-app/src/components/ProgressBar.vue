<script setup>
    const props = defineProps({
        size : {
            type : String,
            default : 'h-1'
        },
        color : {
            type : String,
            default : 'bg-green-400'
        },
        progress : {
            type : Number,
            default : 50
        },
    })
</script>

<template>
    <div class="w-full">
        <div class="bg-gray-300 rounded-full border-none overflow-hidden flex items-center">
            <div class="text-center font-bold leading-none transition-all" 
                :class="props.size + ' ' + props.color"
                :style="{ width: progress + '%' }">
            </div>
        </div>
    </div>
</template>