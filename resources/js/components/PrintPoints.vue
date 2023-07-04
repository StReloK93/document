<template>
    <aside class="flex justify-between mb-1">
        <section v-for="(patuser, index) in pattern.positions" :key="index" class="flex justify-center">
            <footer class="inline-flex items-center flex-col w-28 text-stone-500">
                <p class="text-center leading-none text-[13px] ">
                    {{ patuser.position.name }}
                </p>
                <main class="flex items-center text-xs">
                    <span class="mr-3">
                        {{ moment(patuser.updated_at).format('MM.DD HH:mm') }}
                    </span>
                    <i v-if="patuser.check" class="fa-regular fa-check"></i>
                    <i v-else class="fa-light fa-xmark"></i>
                </main>
            </footer>
        </section>
    </aside>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import moment from 'moment'
import { useStore } from 'vuex'
const emit = defineEmits(['subscribe'])
const store = useStore()

const { pattern, number , clickable } = defineProps(['pattern', 'number', 'clickable'])

const randomId:any = ref(`list${number}`)

function getId(index) {
    if (index == 0 || index == 1) return randomId.value
}

function redalert(index){
    return index - 1
}


function subscribe(bool, patuser){
    if(bool && clickable) emit('subscribe', patuser)
}


</script>