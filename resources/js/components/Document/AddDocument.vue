<template>
    <section @mousedown="emit('close')"
        class="absolute-black-full p-8 flex justify-end rounded-sm shadow-sm">
        <form @submit.prevent="addDocument" @mousedown.stop class="w-[1280px] bg-white flex flex-col relative">
            <Loader class="absolute top-0 left-0 w-full h-full bg-white bg-opacity-70 z-[1000]" v-if="pageData.loading"></Loader>
            <header class="flex justify-between bg-gray-100 relative z-[1001]">
                <span class="px-4 py-1.5 text-gray-500">
                    Hujjat qo'shish
                </span>
                <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:text-red-500">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </header>
            <footer class="flex-grow flex justify-between p-4 shadow-sm">
<!--  -->
                <div class="h-full">
                    <TextRedactor class="mr-4 h-full" v-if="pageData.editor" v-model="formData.html" :editable="true" ref="Myredactor"></TextRedactor>
                    <Loader class="absolute top-0 left-0 w-full h-full bg-white bg-opacity-70 z-[1000]" v-else></Loader>
                </div>
<!--  -->
                <section class="w-[402px] flex flex-col pl-4 border-l -my-3 py-3">
                    <main>
                        <div class="mb-3">
                            <input
                                type="text"
                                class="border-b p-2 outline-none w-full text-sm"
                                v-model="formData.name"
                                placeholder="Qisqacha mazmuni"
                                required
                            >
                        </div>
        
                        <div v-if="pageData.organizations.length > 1" class="mb-3">
                            <VueSelect
                                v-model="formData.organization"
                                :options="pageData.organizations"
                                label="shortname"
                                track-by="shortname"
                                placeholder="Bo'linma"
                                selectLabel="Tanlang"
                                deselectLabel="O'chirish"
                                selectedLabel="Tanlangan"
                            >
                            </VueSelect>
                        </div>
                        <div v-if="pageData.reject_types.length" class="mb-3">
                            <VueSelect 
                                v-model="formData.reject_type"
                                :options="pageData.reject_types"
                                @select="changeDocument"
                                @remove="removeDocument"
                                label="name"
                                track-by="name"
                                placeholder="Hujjat turlari"
                                selectLabel="Tanlang"
                                deselectLabel="O'chirish"
                                selectedLabel="Tanlangan"
                            >
                            </VueSelect>
                        </div>
                        <div v-if="pageData.patterns.length" class="mb-3">
                            <VueSelect 
                                v-model="formData.pattern"
                                :options="pageData.patterns"
                                label="name" track-by="name"
                                placeholder="Shablonlar"
                                selectLabel="Tanlang"
                                deselectLabel="O'chirish"
                                selectedLabel="Tanlangan"
                            >
                            </VueSelect>
                        </div>
                        <div v-if="pageData.positions.length" class="mb-3">
                            <VueSelect 
                                v-model="formData.positions"
                                :options="pageData.positions"
                                label="name" track-by="name"
                                placeholder="Tasdiqlovchilar"
                                selectLabel="Tanlang"
                                deselectLabel="O'chirish"
                                selectedLabel="Tanlangan"
                                :multiple="true"
                            >
                            </VueSelect>
                        </div>
                        <div class="mb-3">
                            <label class="text-gray-400">
                                Muddati
                            </label>
                            <input
                                type="date"
                                class="border-b p-2 outline-none w-full text-sm"
                                v-model="formData.term"
                                placeholder="Qisqacha mazmuni"
                            >
                        </div>
                    </main>
                    <section class="flex-grow relative">
                        <aside class="absolute top-0 left-0 h-full w-full overflow-y-auto">
                            <UploadImage :formData="formData"></UploadImage>
                        </aside>
                    </section>
                </section>
            </footer>
            <main class="p-4 flex justify-between items-center h-[68px]">
                <aside class="inline-flex">
                    <!-- <label for="file" :class="{'bg-pink-500 text-white': pageData.pdf}" class="px-5 py-1.5 text-pink-500 rounded-sm shadow-sm bg-gray-200 h-full block cursor-pointer">
                        <i class="fa-light fa-file-pdf  relative top-px"></i>
                    </label> -->
                    <label for="fileinp" class="px-5 py-1.5 rounded-sm shadow-sm bg-gray-200 h-full block cursor-pointer">
                        <i class="fa-sharp fa-solid fa-image-landscape text-pink-500 relative top-px"></i>
                    </label>
                </aside>
                <aside>
                    <button class="px-5 py-1.5 rounded-sm shadow-xl bg-pink-600 text-white font-semibold">
                        Kiritish <i class="fa-solid fa-right-long-to-line ml-3"></i>
                    </button>
                </aside>
            </main>
        </form>
    </section>
</template>

<script setup lang="ts">
// import VuePdfEmbed from 'vue-pdf-embed'
import { reactive, watch , ref } from 'vue'
import UploadImage from '../UploadImage.vue'
import axios from '../../modules/axios'

function closePdf(){
    pageData.pdf = null
}

const Myredactor = ref()

const formData: any = reactive({
    name: null,
    organization: null,
    reject_type: null,
    pattern: null,
    positions: null,
    pdf: null,
    images: [],
    term: null,
    html: [],
})

const emit = defineEmits(['close', 'created'])
const pageData: any = reactive({
    editor: true,
    organizations: [],
    reject_types: [],
    patterns: [],
    positions: [],
    pdf: null,
    loading: false
})


function changeDocument(select){
    if(JSON.parse(select.html) == null ) return
    
    pageData.editor = false
    formData.html = JSON.parse(select.html)
    setTimeout(() => pageData.editor = true, 250)
}

function removeDocument(select){
    if(JSON.parse(select.html) == null ) return
    
    pageData.editor = false
    formData.html = []
    setTimeout(() => pageData.editor = true, 250)
}


function fileChange(){
    const file:any = document.getElementById('file')
    formData.pdf = file.files[0]
    pageData.pdf = URL.createObjectURL(file.files[0])
}

function addDocument() {
    if(pageData.loading == true) return

    
    const Form = new FormData()
    Form.append('pdf', formData.pdf)
    Form.append('term', formData.term)
    Form.append('html', JSON.stringify(formData.html))
    Form.append('organization_id', formData.organization.id)
    Form.append('reject_type_id', formData.reject_type.id)
    Form.append('name', formData.name)
    Form.append('positions', JSON.stringify(formData.positions))

    formData.images.forEach(image => {
        Form.append('images[]', image)
    })

    pageData.loading = true
    axios.post('documents', Form).then(({ data }) => {
        pageData.loading = false
        emit('created', data)
        emit('close')
    }, (error)=>{
        console.log(error)
    })
}



axios.all([axios.get('organization/my'), axios.get('reject-type'), axios.get('positions')])
.then(axios.spread(({ data: organizations }, { data: reject_types }, {data: positions}) => {
    if (organizations.length == 1) formData.organization = organizations[0]
    pageData.organizations = organizations
    pageData.reject_types = reject_types
    pageData.positions = positions
}))


watch(() => formData.reject_type, ( value:any ) => {
    if(value == null) return pageData.patterns = []
    axios.get(`/pattern/${value.id}`).then(({data}) => pageData.patterns = data)
})


watch(() => formData.pattern, ( value:any ) => {
    if(value == null) return
    formData.positions = value.positions.map((position) => position.position)
})
</script>