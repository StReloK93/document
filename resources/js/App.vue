<template>
	<section class="h-screen flex bg-gray-100">

		<LeftMenu v-if="store.state.user"></LeftMenu>
		
		<main class="p-7 pt-0 flex-grow flex flex-col relative">
			<MyHeader v-if="store.state.user"></MyHeader>
			<div class="flex-grow" :class="{'w-2/3': $route.name == 'subscribes'}">
				<router-view ></router-view>
			</div>
		</main>

	</section>
</template>

<script setup lang="ts">
import { useStore } from 'vuex';
import LeftMenu from './components/LeftMenu.vue'
import MyHeader from './components/MyHeader.vue'
const store = useStore()
</script>