<script setup>
import { computed, ref } from 'vue';

    const props = defineProps(['items'])

    defineEmits(['update:modelValue'])
    
    defineOptions({
        inheritAttrs: false
    })


</script>

<template>
    <input v-bind="$attrs" :value="props.modelValue" @input="$emit('update:modelValue', $event.target.value)" type="search" list="options">
    <datalist id="options">
        <option v-for="item in props.items" :value="item.nombre"></option>
    </datalist>
</template>

