<script setup>

    import { computed, ref } from 'vue';
    import UserPhoto from '../components/UserPhoto.vue'

    const props = defineProps({
        users : {
            typo : Array,
            default : () => []
        },
        modelValue : null
    })

    const emit = defineEmits(['update:modelValue'])

    const open = ref(false)
    const users = computed(() => props.users)
    const search = ref('')

    const result = computed(() => {
        return users.value.filter(user => user.name.toLowerCase().match(search.value.toLocaleLowerCase())).slice(0,5)
    })

    const showOption = () => {
        open.value = search.value.length > 0 ? true : false
    }

    function sendData (user) {
        search.value = user.name
        emit('update:modelValue', user.id)
        open.value = false
    }


</script>
<template>
    <div class="relative">
        <Input @keyup="showOption" type="search" v-model="search" icon="search" placeholder="Search user ...." class="h-14" />
        <div v-show="open" class="absolute z-10 border p-4 rounded-lg bg-white mt-1 w-full">
            <div @click="sendData(user)" v-for="user in result" class="flex items-center gap-2 cursor-pointer py-1 hover:bg-slate-100 rounded-lg">
                <UserPhoto  :user="user" class="h-12 w-12" />
                <div class="text-sm">
                    <strong>{{ user.name }}</strong>
                    <p>{{ user.email }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

