<script setup>

    import { useAuthStore } from '../stores/auth'

    const auth = useAuthStore()

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
                        <Input v-model="auth.user.email" option="label" title="Email" type="email" class="w-full" :error="auth.errors.hasOwnProperty('email')" />
                        <Input v-model="auth.user.password" option="label" title="Password" type="password" class="w-full" :error="auth.errors.hasOwnProperty('password')"/>
                    </div>
                    <br>
                    <div class="flex justify-center">
                        <Button @click="auth.login" text="Acceder" class="btn-dark rounded-full shadow-black" icon="fas fa-right-to-bracket" :loadin="auth.loading" />
                    </div>
                </form>
                <Validate-Errors :errors="auth.errors" v-if="auth.errors != 0" />
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