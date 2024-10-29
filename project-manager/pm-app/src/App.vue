<script setup>
	import { onMounted } from 'vue'
	import { useAuthStore } from './stores/auth'
	import { useGlobalStore } from './stores/global'
	import Toast from './components/Toast.vue'

	const auth = useAuthStore()
	const global = useGlobalStore()

	onMounted(() => auth.validateAuth())
	
</script>

<template>
	<div v-if="global.toasts.length > 0" class="fixed top-12 right-2 grid z-30">
		<Toast v-for="toast in global.toasts" :message="toast.message" :type="toast.type" :title="toast.title" />
	</div>
	<RouterView />
</template>


