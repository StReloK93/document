<template>
    <section @mousedown="emit('close')" class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-20 p-4 pl-40 pt-12 z-50 flex justify-end">
        <form @mousedown.stop @submit.prevent="negative" class="bg-white w-[700px] h-full flex flex-col justify-between ">
            <aside>
                <div class="bg-gray-100 flex justify-between">
                    <span class="px-4 py-1.5 text-gray-500">
                        Hujjatni bekor qilish
                    </span>
                    <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:bg-gray-200  hover:text-red-500">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <main class="p-4 flex-grow">
                    <textarea class="outline-none border-b w-full h-32" placeholder="Hujjat bekor qilinishi sababi" v-model="formData.description" required></textarea>
                </main>
            </aside>


            <main class="p-4 text-right">
                <button @click="emit('close')" type="button" class="px-5 py-1.5 rounded-sm shadow bg-gray-200 text-gray-700">
                    Yopish <i class="fa-light fa-xmark ml-3"></i>
                </button>
                <button type="submit" class="px-5 py-1.5 rounded-sm shadow bg-pink-600 text-white ml-4">
                    Hujjatni bekor qilish <i class="fa-solid fa-check ml-3"></i>
                </button>
            </main>
        </form>
    </section>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import axios from '../../modules/axios';
const { document } = defineProps(['document'])
const emit = defineEmits(['close', 'negatived'])

const formData = reactive({
    description: ''
})

function negative(){
    axios.put(`backup/${document.id}`, formData).then(() => {
        emit('negatived')
    }) 
}
</script>
<style>
textarea {
  resize: none;
}
</style>

<!-- 935213939 -->