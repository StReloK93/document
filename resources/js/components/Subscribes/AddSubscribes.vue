<template>
	<main class="absolute-black-full p-8 z-50">
		<form @submit.prevent="sendForm" @click.stop class="bg-white h-full flex flex-col justify-between relative">
			<main class="bg-gray-100 text-right">
				<button type="button" @click="emit('close')" class="px-4 py-1.5 hover:bg-gray-200 hover:text-red-500">
					<i class="fa-sharp fa-regular fa-xmark"></i>
				</button>
			</main>
			<main class="flex-grow shadow p-4">
				<h3 class="text-xl text-gray-500 mb-2">
					Shablon tayyorlash
				</h3>
				<div class="mb-3">
					<input type="text" v-model="formData.name" class="border-b p-2 outline-none w-full text-sm"
						placeholder="Shablon nomi" required>
				</div>
				<VueSelect v-if="pageData.rejectTypes" class="mb-3" v-model="formData.rejectType"
					:options="pageData.rejectTypes" label="name" track-by="name" placeholder="Buyruq turlari"
					selectLabel="Tanlang" deselectLabel="O'chirish" selectedLabel="Tanlangan" required>
				</VueSelect>
				<VueSelect v-if="pageData.positions" v-model="formData.positions" :options="pageData.positions" :multiple="true"
					label="name" track-by="id" placeholder="Tasdiqlovchilar" selectLabel="Tanlang" deselectLabel="O'chirish"
					selectedLabel="Tanlangan" required>
				</VueSelect>
			</main>
			<main class="text-right p-4">
				<button class="px-5 py-1.5 rounded-sm shadow-xl bg-pink-600 text-white font-semibold">
					Kiritish <i class="fa-solid fa-right-long-to-line ml-3"></i>
				</button>
			</main>
		</form>
	</main>
</template>

<script setup lang="ts">
import axios from '../../modules/axios'
import { reactive } from 'vue'
const emit = defineEmits(['close','add-pattern'])
const pageData: any = reactive({
	rejectTypes: null,
	positions: null
})

const formData = reactive({
	name: null,
	rejectType: null,
	positions: null,
})

function sendForm() {
	if(formData.positions == null || formData.rejectType == null) return 

	axios.post('pattern', formData).then(({ data }) => {
		console.log(data, 'pattern Add');
		
		emit('add-pattern', data)
		emit('close')
	})
}



axios.all([axios.get('reject-type'), axios.get('positions')])
	.then(axios.spread(({ data: reject }, { data: positions }) => {
		pageData.rejectTypes = reject
		pageData.positions = positions
	}));
</script>