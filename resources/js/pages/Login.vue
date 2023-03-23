<template>
	<section class="flex flex-col h-full fixed top-0 left-0 w-full bg-gradient-to-tr from-red-100 to-pink-100">
		<main class="flex-grow flex items-center justify-center">
			<form class="min-w-[900px] w-2/3 h-[800px] shadow-2xl flex rounded overflow-hidden" @submit.prevent="login">
				<section class="w-2/3 bg-gradient-to-bl from-red-500 to-pink-500 font-bold text-white relative ">
					<span class="absolute top-1 left-2 text-rose-500">
						RUZZIFER
					</span>
					<aside class="absolute bottom-1 right-8 font-normal">
						<i class="fa-regular fa-mobile"></i> +998 79-597-40-39
					</aside>
					<div class="text-4xl font-bold text-gray-100 text-left flex-center h-full ">
						<main class="text-center font-sans">
							"Hujjatlarni tasdiqlash tizimi" <span class="font-normal">ga</span>  <br>
							<span class="font-normal">
								xush kelibsiz
							</span>
							<div>
								<i class="fa-solid fa-pen-nib text-[100px] mt-10"></i>
							</div>
						</main>
					</div>
				</section>

				<section class="p-8 w-1/3 bg-white relative">
					<p class="text-sm text-gray-400 absolute left-0 bottom-8 px-8 w-full">
						<i class="fa-regular fa-bell text-pink-500 mr-3"></i> Agar tizimga kirishga ruxsat olmoqchi bo'lsangiz yoki parolni unutgan bo'lsangiz ushbu raqamga qo'ng'iroq qiling 597-40-39
					</p>
					<main class="w-full pt-8">						
						<h3 class="text-gray-700 text-2xl mb-8 font-semibold">Tizimga kirish</h3>
						<p v-if="errors" class="text-center text-red-500 text-sm">
							{{errors}}
						</p>
						<div class="mb-5">
							<label for="number" class="text-gray-400 text-xs">Login</label>
							<input id="number" type="text" v-model="form.login" required class="w-full flex-1 py-1 border-b border-gray-200 focus:border-pink-500 text-gray-600 placeholder-gray-400 outline-none"/>
						</div>
						<div class="mb-5">
							<label for="password" class="text-gray-400 text-xs">Parol</label>
							<input id="password" type="password" minlength="6" v-model="form.password" autocomplete="off" required class="w-full flex-1 py-1 border-b border-gray-200 focus:border-pink-500 text-gray-600 placeholder-gray-400 outline-none"/>
						</div>
						<div class="flex text-sm justify-between my-12">
							<button type="submit" class="px-5 py-1.5 rounded-sm shadow bg-gradient-to-bl from-red-500 to-pink-500 hover:bg-pink-500 text-white w-full">Kirish</button>
						</div>
					</main>
				</section>
			</form>
		</main>
	</section>
</template>
<script setup lang="ts">
import { ref , reactive } from "vue"
import { useStore } from "vuex"
const store = useStore()
const form: any = reactive({login: "", password: ""})

const errors = ref(null)

async function login(){
	const result = await store.dispatch('login', form)
	
	if(result) errors.value = result.message
	else errors.value = null
}
</script>
