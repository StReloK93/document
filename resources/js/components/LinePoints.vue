<template>
    <aside class="flex justify-between mb-1">
        <section v-for="(patuser, index) in pattern.positions" :key="index" class="flex justify-center">
            <footer class="inline-flex items-center flex-col w-28">
                <nav v-if="clickable" :class="{'!opacity-100': store.getters.userPositions.includes(patuser.position.id)}" class="text-pink-500 opacity-0">
                    <i class="fa-solid fa-circle text-[10px] mb-2"></i>
                </nav>
                <main
                    @click="subscribe(patuser.check && store.getters.userPositions.includes(patuser.position.id), patuser)"
                    :class="[
                        {'cursor-pointer hover:!border-gray-200 hover:!bg-white bg-indigo-900 !border-indigo-900 shadow': patuser.check && store.getters.userPositions.includes(patuser.position.id) },
                        {'bg-indigo-900 !border-indigo-900 shadow': patuser.check && !store.getters.userPositions.includes(patuser.position.id)},
                        {'!border-indigo-900 shadow': index != 0 && pattern.positions[redalert(index)].check},
                        getId(index)
                    ]"

                    :title="patuser.check ? 'Tasdiqlandi: ' + moment(patuser.updated_at).format('DD.MM.YYYY H:m'): ''"
                    class="w-7 h-7 shadow-indigo-400 border-4 border-gray-200 relative opacity-[0.99] rounded-full mb-2  text-center transition-all duration-500"
                >
                    <i v-if="patuser.check" class="fa-regular fa-check text-white relative -top-px"></i>
                    <div v-if="pattern.positions.length - 1 != index" :class="[{'!bg-indigo-900': patuser.check }, before]"
                        class="before bg-gray-200 transition-all duration-500"></div>
                </main>
                <p class="text-center leading-none text-[13px] text-stone-500">
                    {{ patuser.position.name }}
                </p>
            </footer>
        </section>
    </aside>
</template>

<script setup lang="ts">
import { getDistanceBetweenElements } from '../modules/distance'
import { ref, onMounted } from 'vue'
import moment from 'moment'
import { useStore } from 'vuex'
const emit = defineEmits(['subscribe'])
const store = useStore()

const { pattern, number , clickable } = defineProps(['pattern', 'number', 'clickable'])

const randomId:any = ref(`list${number}`)
const before:any = ref(`before${number}`)

function getId(index) {
    if (index == 0 || index == 1) return randomId.value
}

function redalert(index){
    return index - 1
}

function resizer() {
    const points: any = document.getElementsByClassName(randomId.value)
    if(points.length < 2) return
    const distance: any = getDistanceBetweenElements(points[0], points[1])

    const pointWidht: any = points[0].offsetWidth - 4
    const lines = document.getElementsByClassName(before.value)
    for (let index = 0; index < lines.length; index++) {
        const element = lines[index] as HTMLDivElement
        element.style.width = `${distance - pointWidht}px`
    }
}

function subscribe(bool, patuser){
    if(bool && clickable) emit('subscribe', patuser)
}

onMounted(() => {
    resizer()
    addEventListener('resize', resizer)
})
</script>