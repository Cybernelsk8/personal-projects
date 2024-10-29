<script setup>
import { onMounted } from 'vue'
import { ref } from 'vue'

    const showButton = ref(false)

    const scrollToTop = () => {
        window.scrollTo({
        top: 0,
        behavior: 'smooth',
        })
    }

    const handleScroll = () => {
        showButton.value = window.scrollY > 100;
    }

    onMounted(() => {
      window.addEventListener('scroll', handleScroll);
    })


</script>

<template>
    <button v-show="showButton" @click="scrollToTop" class="fixed z-30 bottom-6 rounded-full border-2 bg-lime-500 border-lime-600 h-12 w-12 right-4 animate-bounce shadow-lg shadow-lime-800">
        <span class="flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
        </span>
    </button>
</template>