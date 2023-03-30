<template>
    <section class="relative h-full flex flex-col">
        <AddSubscribes 
            v-if="pageData.form"
            @click="pageData.form = false"
            @close="pageData.form = false"
            @add-pattern="(pattern) => pageData.patterns.push(pattern)"
        ></AddSubscribes>
        <EditSubscribes 
            v-if="pageData.selected"
            :selected="pageData.selected"
            @click="pageData.selected = null"
            @close="pageData.selected = null"
            @edit-pattern="editPattern"
        ></EditSubscribes>
        <main class="flex justify-between items-center mb-2">
            <h3 class="text-xl text-gray-700">
                Tasdiqlovchilar shablonlari
            </h3>

            <button @click="pageData.form = true">
                <i class="fa-sharp fa-regular fa-plus text-pink-500 text-xl px-3 py-1 bg-gray-50 hover:bg-pink-200 active:bg-gray-200 shadow-sm border border-pink-200"></i>
            </button>
        </main>
        <main class="flex-grow  relative">
            <nav class="absolute top-0 left-0 overflow-x-auto w-full h-full">
                <transition-group name="list-complete">
                    <div v-for="(pattern, index) in pageData.patterns" :key="pattern" class="bg-white px-3 pb-1 mb-3 shadow shadow-gray-200 transition-all duration-500">
                        <section class="flex items-center justify-between  mb-4 pl-4 -mx-3">
                            <h3 class="text-gray-600 text-xl">{{ pattern.name }}</h3>
                            <main class="pl-3">
                                <span class="inline-block mr-3">
                                    <i class="fa-duotone fa-link-simple text-sky-300 mr-2"></i> {{ pattern.reject.name }}
                                </span>
                                <button @click="pageData.selected = pattern" class="px-4 py-1.5 hover:bg-gray-200">
                                    <i class="fa-solid fa-pen text-teal-500"></i>
                                </button>
                                <button @click="deleted(pattern)" class="px-4 py-1.5 hover:bg-gray-200">
                                    <i class="fa-duotone fa-trash text-pink-600"></i>
                                </button>
                            </main>
                        </section>
                        <LinePoints :pattern="pattern" :number="index"></LinePoints>
                    </div>
                </transition-group>
            </nav>
        </main>
    </section>
</template>
<script setup lang="ts">
import axios from '../modules/axios'
import swal from '../modules/swal'
import AddSubscribes from '../components/Subscribes/AddSubscribes.vue'
import EditSubscribes from '../components/Subscribes/EditSubscribes.vue'
import LinePoints from '../components/LinePoints.vue'
import { reactive } from 'vue'

const pageData: any = reactive({
    form: false,
    patterns: [],
    selected: null
})

function editPattern(edited){
    const selected = pageData.patterns.find(pattern => pattern.id == edited.id)
    selected.name = edited.name
    selected.reject = edited.reject
    selected.positions = edited.positions

    setTimeout(() =>  dispatchEvent(new Event('resize')))
}


function deleted(selected:any){
    swal.fire({
        title: "Aniq o'chirmoqchimisiz?",
        text: "Malumotni qayta tiklab bo'lmaydi!",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/pattern/${selected.id}`).then(() => {
                const index = pageData.patterns.findIndex(pattern => pattern.id == selected.id)
                pageData.patterns.splice(index, 1)
            })
        }
    })

}

axios.get('pattern').then(({data}) => {pageData.patterns = data; console.log(data) })
</script>