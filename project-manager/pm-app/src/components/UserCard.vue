<script setup>
import { ref } from 'vue';
import { onClickOutside } from '@vueuse/core'
import { useAuthStore } from '../stores/auth'
import UserPhoto from './UserPhoto.vue'

    const auth = useAuthStore()

    const openModalHelp = ref(false);
    const open = ref(false);
    const target = ref(null)


    onClickOutside(target, (event) => open.value = false)

    defineOptions({
        inheritAttrs: false
    })
    
</script>

 <template>
    <div @click="open = !open " ref="target" v-bind="$attrs" class="">
        <div class="flex items-center space-x-3 cursor-pointer">

            <UserPhoto v-if="auth.user.hasOwnProperty('image')" :user="auth.user" class="h-12 w-12 cursor-pointer text-3xl" />
            <Icon v-else icon="fas fa-user" class="bg-gray-300 text-2xl text-slate-900 p-3 rounded-full" />
            
            <div class="font-bold text-gray-400 text-sm text-center hidden md:block">
                <p>{{ auth.user.name }}</p>
                <p>{{ auth.user?.roles ? auth.user?.roles[0]?.nombre : '' }}</p>
            </div>
        </div>

        <Transition>
            <div v-show="open" class="absolute w-72 px-5 py-3 bg-slate-900 rounded-lg shadow-lg border-2 mt-5 right-1 z-10 text-gray-400">

                <h1 class="font-bold">Perfil de usuario</h1>
                <div class="flex items-center space-x-2 py-2">
                    <UserPhoto v-if="auth.user.hasOwnProperty('image')" :user="auth.user" class="h-12 w-12" />
                    <Icon v-else icon="fas fa-user" class="bg-gray-300 text-2xl text-slate-900 p-3 rounded-full" />
                    <div class="font-bold text-sm ">
                        <p>{{ auth.user.name }}</p>
                        <small>{{ auth.user.emailmuni ?? '' }}</small>
                    </div>
                </div>
                
                <hr class="py-2">
                <ul class="space-y-3">
                    <li class="font-medium">
                        <a href="../../Ppersonal.php" class="flex items-center transform transition-colors duration-200 border-r-4 border-transparent hover:border-gray-500">
                            <div class="mr-3">
                                <i class="fas fa-address-card"></i>
                            </div>
                            Perfil
                        </a>
                    </li>
                    <li class="font-medium">
                        <a href="#" @click="openModalHelp = true" class="flex items-center transform transition-colors duration-200 border-r-4 border-transparent hover:border-gray-500">
                            <div class="mr-3">
                                <i class="fas fa-gears"></i>
                            </div>
                            Ayuda ?
                        </a>
                    </li>
                    <hr>
                    <li @click="auth.logout()" class="font-medium cursor-pointer">
                        <div class="flex items-center transform transition-colors duration-200 border-r-4 border-transparent hover:border-red-600" >
                            <div class="mr-3 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </div>
                            Cerrar sesión
                        </div>
                    </li>
                </ul>
            </div>
        </Transition>

    </div>
    <modal :open="openModalHelp" class="w-1/3">
        <template #header>
            Manual de usuario del módulo
        </template>
        <iframe src="../prescripciones/docs/help.pdf" class="w-full h-[42rem]"></iframe>
        <template #footer>
            <Button class="btn-danger shadow-red-800" text="Cerrar" @click="openModalHelp = false" />
        </template>
    </modal>
 </template>

<style scoped>
    .v-enter-active, .v-leave-active {
    transition: opacity 0.5s ease-in-out;
    }

    .v-enter-from, .v-leave-to {
    opacity: 0;
    }

</style>