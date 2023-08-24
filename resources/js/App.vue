<template>
	<TextRedactor
		v-if="store.state.selected"
		id="printpage"
		class="print absolute hidden top-0 left-0 z-[1000] h-full"
		v-model="store.state.selected.html"
		:selected="store.state.selected"
		:editable="false"
		:print="true"
	/>
	<section class="h-screen flex bg-gray-100 noprint">
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
import TextRedactor from './components/TextRedactor.vue'
import { watch, reactive } from 'vue';
const store = useStore()


onafterprint = function(){
	store.state.selected = null
}

watch(() => store.state.selected, (current) => {
	if(current) setTimeout(() => print(), 400)
})
</script>