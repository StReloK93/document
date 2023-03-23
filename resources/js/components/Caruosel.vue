<template>
    <section @mousedown="emit('close')" class="absolute top-0 left-0 w-full h-full bg-gray-800 bg-opacity-40 p-8 flex justify-center z-50">
        <main @mousedown.stop class="h-full w-[700px]">
            <swiper :modules="[Pagination]" :pagination="{ clickable: false }" :slides-per-view="1" :space-between="50" class="h-full">
                <swiper-slide @click.stop v-for="image in images" :key="image" class="bg-gray-100 flex justify-center text-center p-4 overflow-scroll">
                    <img  :src="'/img/'+image.path" class="w-full object-contain rounded-sm h-full inline min-h-[900px]">
                </swiper-slide>
            </swiper>
        </main>
    </section>
</template>

<script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper'
const emit = defineEmits(['close'])
const { images } = defineProps(['images'])
</script>