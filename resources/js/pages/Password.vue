<template>
    <main class="w-[500px]">
        <h3 class="text-xl text-gray-700 mb-2">Parolni o'zgartirish</h3>
        <div class="text-gray-600 p-4 bg-white">
            <aside>
                <form @submit.prevent="passwordReset">
                    <div v-if="errors.message" class="text-red-500 flex justify-between items-center">
                        <span>
                            {{ errors.message }}
                        </span>
                        <span @click="errors.message = null">
                            <i class="fal fa-times"></i>
                        </span>
                    </div>
                    <div v-if="errors.new" class="flex justify-between items-center text-red-500">
                        <section>
                            <main v-for="error in errors.new" :key="error" class="w-full">
                                <span>
                                    {{ error }}
                                </span>
                            </main>
                        </section>
                        <span @click="errors.new = null">
                            <i class="fal fa-times"></i>
                        </span>
                    </div>
                    <div>
                        <label for="oldPassword" class="text-gray-400 text-xs">Hozirgi parol</label>
                        <input id="oldPassword" minlength="6" v-model="pass.old" type="password" required
                            class="border-b p-2 outline-none w-full text-sm">
                    </div>
                    <div>
                        <label for="newPassword" class="text-gray-400 text-xs">Yangi parol</label>
                        <input id="newPassword" minlength="6" v-model="pass.new" type="password" required
                            class="border-b p-2 outline-none w-full text-sm">
                    </div>
                    <div>
                        <label for="newPassword_confirm" class="text-gray-400 text-xs">Yangi parolni tasdiqlang</label>
                        <input id="newPassword_confirm" minlength="6" v-model="pass.new_confirmation" type="password"
                            required
                            class="border-b p-2 outline-none w-full text-sm">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="px-5 py-1.5 w-full rounded-sm shadow bg-pink-600 text-white hover:bg-pink-500">
                            Parolni yangilash
                            <i class="fa-solid fa-lock-keyhole ml-3"></i>
                        </button>
                    </div>
                </form>
            </aside>
            <!-- menu -->

        </div>
    </main>
</template>
<script setup lang="ts">
import { ref, reactive } from 'vue'
import swal from '../modules/swal'
import axios from '../modules/axios'


const password = ref(false)
const pass = reactive({
    old: "",
    new: "",
    new_confirmation: "",
})
const errors = reactive({
    message: null,
    new: null,
})


async function passwordReset() {
    const result = await axios.post('/passwordreset', pass)
    if (result.data == 1) {
        swal.fire({
            icon: 'success',
            title: "Parol yangilandi",
            showConfirmButton: false,
            showCancelButton: false,
            timer: 2000
        })
        pass.old = ""
        pass.new = ""
        pass.new_confirmation = ""

        password.value = false
        errors.message = null
        errors.new = null
    }
    else {
        errors.message = result.data.message
        errors.new = result.data.new
    }
}
</script>