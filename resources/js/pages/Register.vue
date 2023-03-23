<template>
	<section class="flex flex-col h-full fixed top-0 left-0 w-full">
		<main class="flex-grow flex items-center justify-center">
			<form class="w-1/2 shadow-2xl flex" @submit.prevent="register">
				<section class="w-1/2 loginback"></section>
				<section class="p-8 w-1/2 bg-white">

					<h3 class="text-gray-900 text-2xl text-center mb-4">Ro'yhatdan o'tish</h3>

					<main class="text-red-500">
						<p v-if="errors.login">
							{{errors.login[0]}}
						</p>
						<p v-if="errors.password">
							{{errors.password[0]}}
						</p>
					</main>

					<div>
						<label for="name" class="text-gray-600 text-xs">Familiya Ism Sharifi</label>
						<input id="name" type="text" placeholder="F.I.SH" v-model="form.name" required class="w-full flex-1 py-1 border-b border-gray-200 focus:border-green-400 text-gray-600 placeholder-gray-400 outline-none"/>
					</div>
					<div>
						<label for="login" class="text-gray-600 text-xs">Login</label>
						<input id="login" type="text" placeholder="Login" v-model="form.login" required class="w-full flex-1 py-1 border-b border-gray-200 focus:border-green-400 text-gray-600 placeholder-gray-400 outline-none"/>
					</div>
					
					<div>
						<label for="password" class="text-gray-600 text-xs">Parol</label>
						<input id="password" type="password"  minlength="6" v-model="form.password" autocomplete="off" required class="w-full flex-1 py-1 border-b border-gray-200 focus:border-green-400 text-gray-600 placeholder-gray-400 outline-none"/>
					</div>
					<div>
						<label for="password2" class="text-gray-600 text-xs">Parolni qaytadan tering</label>
						<input id="password2" type="password" minlength="6" v-model="form.password_confirmation" autocomplete="off" required class="w-full flex-1 py-1 border-b border-gray-200 focus:border-green-400 text-gray-600 placeholder-gray-400 outline-none"/>
					</div>
					<div class="text-right mb-4 text-xs mt-2">
						<router-link to="/login" class="hover:text-blue-500 text-blue-400">Ro'yhatdan o'tganmisiz?</router-link>
					</div>
					<div class="flex text-sm justify-between">
						<button type="submit" class="bg-gray-600 text-center hover:bg-gray-400 transition duration-150 shadow-xl w-full text-white p-2">Ro'yhatdan o'tish</button>
					</div>
				</section>
			</form>
		</main>
	</section>
</template>
<script setup lang="ts">
import { ref, reactive } from "vue"
import { useStore } from "vuex";
const store = useStore()
const form = reactive({
	name: "",
	login: "",
	password: "",
	password_confirmation: ""
})

const errors = ref({
	password: null,
	login: null
})

async function register(){
	const { data } = await store.dispatch('register', form)
	errors.value = data
}
</script>

<style scoped>
.loginback{
	background: url('/images/register.jpg') no-repeat;
	background-size: cover;
	background-position: center;
}
</style>