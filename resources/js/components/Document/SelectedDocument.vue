<template>
    <section @mousedown="emit('close')" class="absolute-black-full p-8 z-50  flex justify-end">
        <main @mousedown.stop class="bg-white shadow rounded-sm h-full w-[1280px] flex flex-col relative">
            <TransitionGroup name="fade">
                <Negative v-if="pageData.negativeToggle" :document="pageData.selected"
                    @close="pageData.negativeToggle = false" @negatived="negatived">
                </Negative>
                <Backup v-if="pageData.backupToggle" :document="pageData.selected"
                    @close="pageData.backupToggle = false" @negatived="negatived">
                </Backup>
                <Caruosel v-if="pageData.imagesToggle" :images="pageData.selected.images"
                    @close="pageData.imagesToggle = false"></Caruosel>
            </TransitionGroup>
            <div class="bg-gray-100 flex justify-between">
                <span class="px-4 py-1.5 text-gray-500">
                    Hujjat ma'lumotlari
                </span>
                <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:bg-gray-200  hover:text-red-500">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </div>
            <main v-if="pageData.selected" class="h-full flex flex-col">
                <section class="flex-grow flex relative">
                    <div class="flex-grow p-4 pt-3 border-b shadow-sm h-full">
                        <main class="mb-4 border-b border-gray-100 pb-3">
                            <p>
                                <i class="fa-duotone fa-user-tie text-pink-600 mr-3"></i> {{ pageData.selected.user.name }}
                            </p>
                        </main>
                        <main class="mb-3">
                            <label class="block text-gray-500 text-sm">
                                Qisqacha mazmuni
                            </label>
                            <p>
                                {{ pageData.selected.name }}
                            </p>
                        </main>
                        <main class="mb-3">
                            <label class="block text-gray-500 text-sm">
                                Hujjat turi
                            </label>
                            <p>
                                {{ pageData.selected.reject_type.name }}
                            </p>
                        </main>
                        <main class="mb-3">
                            <label class="block text-gray-500 text-sm">
                                Bo'linma nomi
                            </label>
                            <p>
                                {{ pageData.selected.organization.fullname }}
                            </p>
                        </main>
                        <main class="mb-3">
                            <label class="block text-gray-500 text-sm mb-2">
                                Yaratilgan vaqt
                            </label>
                            <div v-if="pageData.selected">
                                {{ moment(pageData.selected.created_at).format('DD.MM.YYYY HH:mm') }}
                            </div>
                        </main>
                        <main v-if="pageData.selected.term" class="mb-3">
                            <label class="block text-gray-500 text-sm mb-2">
                                Muddati
                            </label>
                            <div>
                                {{ moment(pageData.selected.term).format('DD.MM.YYYY') }}
                            </div>
                        </main>
                        <main class="mb-4 flex justify-between">
                            <button v-if="$route.name == 'finished'" @click="redactor.PrintElem()" class="px-4 py-3 bg-gray-100 shadow hover:bg-gray-200">
                                <i class="fa-solid fa-print text-pink-500"></i>
                            </button>
                            <button v-if="pageData.selected.images.length" @click="pageData.imagesToggle = true"
                                class="px-4 py-3 bg-gray-100 shadow hover:bg-gray-200">
                                <i class="fa-sharp fa-regular fa-images text-pink-500"></i>
                            </button>
                        </main>
                        <main v-if="pageData.selected.negation" class="-mx-4 p-4 bg-pink-50">
                            <label class="text-gray-500 text-sm mb-2 flex justify-between">
                                Rad etilishi sababi
                                <span>
                                    <i class="fa-solid fa-user-tie text-pink-500 mr-3"></i>
                                    {{ pageData.selected.negation.user.name }}
                                </span>
                            </label>
                            <main>
                                {{ pageData.selected.negation.description }}
                            </main>
                        </main>
                        <main v-if="pageData.selected.backup" class="-mx-4 p-4 bg-pink-50">
                            <label class="text-gray-500 text-sm mb-2 flex justify-between">
                                Bekor qilinishi sababi
                            </label>
                            <main>
                                {{ pageData.selected.backup.description }}
                            </main>
                        </main>
                    </div>
                    <TextRedactor ref="redactor" class="h-full" v-model="pageData.selected.html" :selected="pageData.selected" :editable="false"></TextRedactor>
                </section>
                <section class="h-52 p-4 flex flex-col justify-between">
                    <main class="pb-3">
                        <LinePoints @subscribe="(patuser) => confirm(patuser, null)" :pattern="pageData.selected"
                            :number="Math.random()" :clickable="pageData.selected.backup == null"></LinePoints>
                    </main>
                    <main class="flex justify-between">
                        <aside v-if="store.state.user.id == pageData.selected.user_id && $route.name == 'process'">
                            <!-- edit deleted -->
                            <button v-if="store.getters.userRolls.includes(3)" :disabled="thisIsChecked == false" :class="{ '!text-gray-300 hover:bg-gray-200': thisIsChecked == false }"
                                @click="deleted"
                                :title="thisIsChecked == false ? 'Tasdiqlangan hujjatni o`zartirib yoki o`chirib bo`lmaydi': ''"
                                class="px-5 py-1.5 rounded-sm shadow bg-gray-200 text-pink-500 hover:bg-gray-100">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button v-if="store.getters.userRolls.includes(2)" :disabled="thisIsChecked == false" :class="{ '!text-gray-300 hover:bg-gray-200': thisIsChecked == false }"
                                @click="emit('edit', pageData.selected.id)"
                                :title="thisIsChecked == false ? 'Tasdiqlangan hujjatni o`zartirib yoki o`chirib bo`lmaydi': ''"
                                class="px-5 py-1.5 rounded-sm shadow bg-gray-200 text-pink-500 hover:bg-gray-100 mx-4">
                                <i class="fa-solid fa-pen-nib "></i>
                            </button>
                            

                            <button v-if="thisIsChecked == false"
                                @click="pageData.backupToggle = true"
                                class="px-5 py-1.5 rounded-sm shadow bg-pink-600 text-white hover:bg-pink-500">
                                Hujjatni bekor qilish <i class="fa-duotone fa-triangle-exclamation ml-3"></i>
                            </button>
                        </aside>
                        <aside v-else></aside>
                        <aside v-if="pageData.selected.backup == null && issetPosition" class="flex">
                            <main v-if="$route.name != 'finished'">
                                <button v-if="pageData.selected.negation" @click="allow(pageData.selected.negation)"
                                    class="px-5 py-1.5 rounded-sm shadow bg-pink-600  hover:bg-pink-500 text-white">
                                    Rad etishni bekor qilish
                                    <i class="fa-thin fa-xmark ml-3"></i>
                                </button>
                                <button v-else @click="pageData.negativeToggle = true"
                                    class="px-5 py-1.5 rounded-sm shadow bg-gray-200 text-gray-700 hover:bg-gray-100">
                                    Rad etish <i class="fa-solid fa-ban ml-3"></i>
                                </button>
                            </main>
                            <main v-if="pageData.selected.negation == null">
                                <button v-if="Confirmtrue" @click="confirm(null, false)"
                                    class="px-5 py-1.5 rounded-sm shadow bg-indigo-900 hover:bg-indigo-700 text-white ml-4">
                                    Tasdiqlashni Bekor qilish <i class="fa-thin fa-xmark ml-3"></i>
                                </button>
                                <button v-else @click="confirm(null, true)"
                                    class="px-5 py-1.5 rounded-sm shadow bg-pink-600 hover:bg-pink-500 text-white ml-4">
                                    Tasdiqlash <i class="fa-solid fa-check ml-3"></i>
                                </button>
                            </main>
                        </aside>
                    </main>
                </section>
            </main>
            <Loader v-else class="flex-grow" />
        </main>
    </section>
</template>
<script setup lang="ts">
import Negative from './Negative.vue'
import Backup from './Backup.vue'
import VuePdfEmbed from 'vue-pdf-embed'
import TextRedactor from '../TextRedactor.vue'
import axios from '../../modules/axios'
import LinePoints from '../LinePoints.vue'
import Caruosel from '../Caruosel.vue'
import swal from '../../modules/swal'
import moment from 'moment'
import { ref, reactive, computed } from 'vue'
import { useStore } from 'vuex'
const emit = defineEmits(['close', 'deleted', 'subscribe', 'edit'])

const redactor = ref()
const pdfcanvas = ref()
const { id, grid } = defineProps(['id', 'grid'])
const store = useStore()

axios.get(`documents/${id}`).then(({ data }) => {
    pageData.selected = data
    
    pageData.selected.html = JSON.parse(pageData.selected.html)
    pageData.pdfFile = '/pdf/' + data.src
})


const pageData: any = reactive({
    imagesToggle: false,
    pdfFile: null,
    selected: null,
    negativeToggle: false,
    backupToggle: false,
    html: []
})

function allow(negation) {
    swal.fire({
        title: "Rad etishni bekor qilmoqchimisiz?",
        text: "Hujjat tasdiqlash jarayoniga yuboriladi!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`negation/${negation.id}`).then(() => {
                grid.api.applyTransaction({ remove: [pageData.selected] })
                emit('close')
            })
        }
    })

}

const thisIsChecked = computed(() => {
    return pageData.selected?.positions.every((pos) => pos.check == false)
})

const Confirmtrue = computed(() => {
    const subscribes = pageData.selected?.positions.map((pos) => pos.position_id)
    const userpos = store.getters.userPositions.filter(posid => subscribes.includes(posid))
    const allChecked = pageData.selected?.positions.map((pos) => {
        if (pos.check) return pos.position_id
        else return false
    }).filter((pos) => pos != false)

    return userpos.every(pos => allChecked.includes(pos))
})


const issetPosition = computed(() => {
    const filtered = pageData.selected?.positions.filter((position) => store.getters.userPositions.includes(position.position_id))
    if(filtered) return filtered.length
    else return [].length
})


function confirm(patuser, bool) {
    if (patuser == null) axios.put(`subscribe/${id}`, { positions: store.getters.userPositions, check: bool }).then(() => {
        pageData.selected.positions.forEach((position) => {
            if (store.getters.userPositions.includes(position.position_id)) position.check = bool
        })
        grid.api.getRowNode(pageData.selected.id).setData(pageData.selected)
        grid.api.onFilterChanged()
        setTimeout(() => emit('close'), 600)
    })
    else axios.get(`subscribe/${patuser.id}`).then(() => {
        pageData.selected.positions.find((position) => position.id == patuser.id).check = false
        grid.api.getRowNode(pageData.selected.id).setData(pageData.selected)
        grid.api.onFilterChanged()
    })
}


function negatived() {
    grid.api.applyTransaction({ remove: [pageData.selected] })
    emit('close')
}

function deleted() {
    swal.fire({
        title: "Aniq o'chirmoqchimisiz?",
        text: "Malumotni qayta tiklab bo'lmaydi!",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`documents/${pageData.selected.id}`).then(() => {
                emit('deleted', pageData.selected)
                emit('close')
            })
        }
    })
}
</script>