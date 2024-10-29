<script setup>
import { computed, ref, onMounted, nextTick, watchEffect } from 'vue'
import { onClickOutside } from '@vueuse/core'

    const props = defineProps({
        items: {
            type: Array,
            default: () => []
        },
        fields : {
            type : Array,
            default : () => []
        },
        format : null,
        modelValue: null,
        placeholder : '',
        error : {
            type : Boolean,
            default : false
        }
    })

    const emits = defineEmits(['update:modelValue'])

    const data = computed(() => 
        props.items.filter(item => 
            item[props.fields[1]].toLowerCase().match(search.value.toLocaleLowerCase())
        )
    )

    const search = ref('')
    const item = ref({})
    const target = ref(null)
    const open = ref(false)
    const focusedIndex = ref(-1)
    const listRefs = ref([])

    function selected(val) {
        item.value = val
        open.value = false
        search.value = ''
        emits('update:modelValue', item.value[props.fields[0]])
    }

    const displayValue = computed(() => {
        if (item.value.hasOwnProperty(props.fields[0])) {
            try {
                return new Function('item', `return ${props.format}`)(item.value)
            } catch (error) {
                console.error('Error al evaluar el formato:', error)
                return ''
            }
        }
        return ''
    })

    const displayValueList = (item) => {
            try {
                return new Function('item', `return ${props.format}`)(item)
            } catch (error) {
                console.error('Error al evaluar el formato:', error)
                return ''
            }
    }

    function clearSelection() {
        item.value = {}
        emits('update:modelValue', '')
    }

    onClickOutside(target, () => open.value = false)


    function handleKeydown(event) {
        if (!open.value) return
        
        if (event.key === 'ArrowDown') {
        
            focusedIndex.value = (focusedIndex.value + 1) % data.value.length
        } else if (event.key === 'ArrowUp') {
        
            focusedIndex.value = (focusedIndex.value - 1 + data.value.length) % data.value.length
        } else if (event.key === 'Enter' || event.key === 'Tab') {
        
            if (focusedIndex.value >= 0 && focusedIndex.value < data.value.length) {
                selected(data.value[focusedIndex.value])
            }
        } else if (event.key ==='Escape') {
            open.value = false
        }


    
        nextTick(() => scrollIntoView())
    }


    function scrollIntoView() {
        const currentItem = listRefs.value[focusedIndex.value]
        if (currentItem) {
            currentItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
        }
    }


    function openDropdown() {
        open.value = true
        focusedIndex.value = -1
    }

    watchEffect(() => {

        if(props.modelValue == '') {
            item.value = {}
        }
    })

    onMounted(() => {
        item.value = props.items.find(item => item[props.fields[0]] == props.modelValue);
        document.addEventListener('keydown', handleKeydown)
    })

</script>

<template>
    <div ref="target" class="w-full">
        <div class="flex items-center input bg-white" :class="{'border-red-500' : props.error }" >
            <input :placeholder="props.placeholder" :value="props.format ? displayValue : item[props.fields[1]]" readonly @click="openDropdown" @focus="openDropdown" class="focus:outline-none w-full h-10 placeholder:text-slate-600" />
            <Icon icon="fas fa-xmark" v-if="item[props.fields[0]]" @click="clearSelection" class="text-red-400 cursor-pointer animate-jump" />
        </div>
        <div v-show="open" class="absolute bg-white border p-4 mt-1 rounded border-slate-200 z-10">
            <input v-if="props.items.length > 5" icon="search" type="search" placeholder="Buscar elemento ..." v-model="search" class="input h-10 focus:outline-none">
            <ul class="h-auto max-h-48 overflow-auto">
                <li v-for="(item, index) in data" :key="index" @click="selected(item)" ref="listRefs" class=" whitespace-nowrap"
                    :class="{'cursor-pointer hover:bg-slate-50 p-2 text-gray-600': true, 'bg-slate-100': index === focusedIndex }">
                    {{ props.format ? displayValueList(item) : item[props.fields[1]] }}
                </li>
            </ul>
        </div>
    </div>
</template>
