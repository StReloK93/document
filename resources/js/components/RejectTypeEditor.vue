<template>
    <section @mousedown="emit('close')" class="absolute-black-full p-8 flex justify-end rounded-sm shadow-sm z-50">
        <main @mousedown.stop class="h-full flex flex-col bg-white">
            <header class="flex justify-between bg-gray-100 relative z-[1001]">
                <span class="px-4 py-1.5 text-gray-500">
                    {{ reject_type.name }}
                </span>
                <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:text-red-500">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </header>

            <TextRedactor class="flex-grow" v-model="reject_type.html" :editable="true"></TextRedactor>

            <form @submit.prevent="editReject" class="p-4 text-right">
                <button class="px-5 py-1.5 rounded-sm shadow bg-pink-600 hover:bg-pink-500 text-white">
                    Saqlash
                </button>
            </form>
        </main>
    </section>
</template>

<script setup lang="ts">
import axios from '../modules/axios'
const { reject_type , gridapi } = defineProps(['reject_type', 'gridapi'])

const emit = defineEmits(['close'])

function editReject(){
    axios.post(`reject-type/updateHtml/${reject_type.id}`, {
        id:reject_type.id ,
        html: JSON.stringify(reject_type.html)
    }).then(() => {
        emit('close')
    })
}


</script>