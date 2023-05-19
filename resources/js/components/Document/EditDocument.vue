<template>
    <section @mousedown="emit('close')"
        class="absolute-black-full p-8 flex justify-end rounded-sm shadow-sm">
        <form @submit.prevent="editDocument" @mousedown.stop class="w-[1280px] bg-white flex flex-col relative">
            <Loader class="absolute top-0 left-0 w-full h-full bg-white bg-opacity-70 z-[1000]" v-if="pageData.loading"></Loader>
            <header class="flex justify-between bg-gray-100 relative z-[1001]">
                <span class="px-4 py-1.5 text-gray-500">
                    Hujjatni tahrirlash
                </span>
                <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:text-red-500">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </header>
            <footer v-if="pageData.selected" class="flex-grow flex justify-between p-4 shadow-sm">
                <div class="h-full">
                    <TextRedactor v-if="formData.html && pageData.editor" class="mr-4 h-full" v-model="formData.html" :editable="true"></TextRedactor>
                    <Loader class="absolute top-0 left-0 w-full h-full bg-white bg-opacity-70 z-[1000]" v-else></Loader>
                </div>
                <!-- <main class="w-3/5 pr-4 overflow-y-auto">
                    <div class="h-1/2 relative" v-if="pageData.pdf">
                        <button type="button" class="absolute top-0 right-0 z-50" @click="pageData.pdf = null">
                            <i class="fa-light fa-xmark text-gray-600 py-1 px-2"></i>
                        </button>
                        <main class="relative h-full">
                            <div class="absolute top-0 left-0 w-full h-full overflow-x-auto">
                                <VuePdfEmbed class="h-full" :source="pageData.pdf"></VuePdfEmbed>
                            </div>
                        </main>
                    </div>
                    <div class="h-1/2 relative" v-else>
                        <input id="file" @change="fileChange" type="file" accept="application/pdf" placeholder="File pdf" required>
                        <label 
                            for="file"
                            class="h-full flex absolute top-0 left-0 w-full items-center justify-center border-2 border-dashed border-gray-200 text-gray-600 bg-gray-100 shadow-sm hover:bg-gray-50 cursor-pointer">
                            <i class="fa-light fa-file-pdf text-xl mr-4 text-pink-500"></i>  Hujjat matnini tanlang
                        </label>
                    </div>
                    <main class="h-1/2 relative">
                        <aside class="absolute pt-4 top-0 left-0 h-full w-full overflow-y-auto">
                            <UploadImage :formData="formData"></UploadImage>
                        </aside>
                    </main>
                </main> -->
                <section class="w-[402px] flex flex-col justify-between pl-4 border-l -my-3 py-3">
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
                                @select="changeDocument"
                                @remove="removeDocument"
                                v-model="formData.reject_type"
                                :options="pageData.reject_types"
                                label="name"
                                track-by="name"
                                placeholder="Buyruq turlari"
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
            <Loader v-else class="flex-grow absolute top-0 left-0 w-full h-full bg-white z-[1000]"></Loader>
            <main class="p-4 flex justify-between items-center h-[68px]">
                <aside class="inline-flex">
                    <label for="file" :class="{'bg-pink-500 text-white': pageData.pdf}" class="px-5 py-1.5 text-pink-500 rounded-sm shadow-sm bg-gray-200 h-full block cursor-pointer">
                        <i class="fa-light fa-file-pdf  relative top-px"></i>
                    </label>
                    <label for="fileinp" class="px-5 py-1.5 rounded-sm shadow-sm bg-gray-200 h-full block cursor-pointer ml-4">
                        <i class="fa-sharp fa-solid fa-image-landscape text-pink-500 relative top-px"></i>
                    </label>
                </aside>
                <aside>
                    <button class="px-5 py-1.5 rounded-sm shadow-xl bg-pink-600 hover:bg-pink-500 active:bg-pink-400 text-white font-semibold">
                        Tahrirlash
                        <i class="fa-duotone fa-pen-to-square ml-3"></i>
                    </button>
                </aside>
            </main>
        </form>
    </section>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'
import moment from 'moment'
import UploadImage from '../UploadImage.vue'
import axios from '../../modules/axios'
const emit = defineEmits(['close', 'created'])
const { id , grid } = defineProps(['id','grid'])


axios.get(`documents/${id}`).then(({data}) => {
    pageData.selected = data
    pageData.pdf = '/pdf/' + data.src
    formData.name = data.name
    formData.html = JSON.parse(data.html)
    formData.organization = data.organization
    formData.reject_type = data.reject_type
    formData.positions = data.positions.map(position => position.position)
    formData.images = data.images
    formData.term = data.term ? moment(data.term).format('YYYY-MM-DD') : null
})

const pageData: any = reactive({
    editor: true,
    organizations: [],
    reject_types: [],
    patterns: [],
    positions: [],
    pdf: null,
    loading: false,
    selected: null,
})

const formData: any = reactive({
    name: null,
    organization: null,
    reject_type: null,
    pattern: null,
    positions: null,
    pdf: null,
    term: null,
    images: []
})


function fileChange(){
    const file:any = document.getElementById('file')
    formData.pdf = file.files[0]
    pageData.pdf = URL.createObjectURL(file.files[0])
}

function editDocument() {
    if(pageData.loading == true) return
    pageData.loading = true

    const Form = new FormData()
    Form.append('pdf', formData.pdf)
    Form.append('term', formData.term)
    Form.append('html', JSON.stringify(formData.html))
    Form.append('organization_id', formData.organization.id)
    Form.append('reject_type_id', formData.reject_type.id)
    Form.append('name', formData.name)
    Form.append('positions', JSON.stringify(formData.positions))

    formData.images.forEach(image => {
        if(image.type) Form.append('imgs[]', image)
        else Form.append('images[]', image.id)
    })

    axios.post(`documents/${pageData.selected.id}`, Form).then(({ data }) => {
        grid.api.getRowNode(pageData.selected.id).setData(data)
        pageData.loading = false
        emit('close')
    },
    (error)=>{
        console.log(error)
    })
}


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