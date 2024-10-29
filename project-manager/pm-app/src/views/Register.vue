<script setup>

    import { useRegisterStore } from '../stores/register'

    const store = useRegisterStore()

</script>

<template>
    <div class="h-screen bg-slate-900 grid grid-cols-2">
        <div class="self-center w-1/2 mx-auto z-20">
            <div>
                <Logo class="w-auto h-64 mx-auto z-20 fill-gray-600" />
                <h1 class="text-center text-4xl font-bold text-gray-600">CyberSoft</h1>
                <br>
                <form @submit.prevent="login" >
                    <div class="grid gap-4 z-20">
                        <Input v-model="store.data.name" option="label" title="Name" type="text" class="w-full" :error="store.errors.hasOwnProperty('name')" />
                        <Input v-model="store.data.email" option="label" title="Email" type="email" class="w-full" :error="store.errors.hasOwnProperty('email')" />
                        <Input v-model="store.data.password" option="label" title="Password" type="password" class="w-full" :error="store.errors.hasOwnProperty('password')"/>
                        <Input v-model="store.data.password_confirmation" option="label" title="Confirm password" type="password" class="w-full" :error="store.errors.hasOwnProperty('password_confirmation')"/>
                    </div>
                    <br>
                    <div class="flex justify-center">
                        <Button @click="store.register" text="Acceder" class="btn-dark rounded-full shadow-black" icon="fas fa-right-to-bracket" />
                    </div>
                </form>
                <Validate-Errors :errors="store.errors" v-if="store.errors != 0" />
            </div>
        </div>
        <div class="bg-image1 bg-cover bg-center bg-no-repeat z-20 rounded-bl-[10rem]"></div>
    </div>
</template>

<style scoped>
    .bg-image1{
        background-image: url('../assets/img/muni.jpg');
        z-index: 1;
    }
</style>