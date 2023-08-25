<template>
    <main class="ruzzifer-editor print:!w-[inherit]">
        <Buttons
            v-if="editable"
            @pageCreate="PageCreate"
            :editable="editable"
            :QrCodeIsset="QrCodeIsset"
        />
        <main class="ruzzifer-pages print:!p-0" @click="closeAllModals">
            <aside class="ruzzifer-absolute print:!static">
                <section v-for="(page) in modelValue" class="ruzzifer-page-container relative">
                    <PagePaddings  v-if="page.opened" :page="page" />
                    <div v-if="editable" class="ruzzifer-page-params noprint">
                        <button @click.stop="page.menuOpened = true" type="button">
                            <i class="fa-regular fa-ellipsis-vertical"></i>
                        </button>
                        <main v-if="page.menuOpened" class="ruzzifer-page-menu text-gray-500">
                            <button @click.stop="page.opened = true" type="button">
                                <i class="fa-duotone fa-gear"></i> Sozlamalar
                            </button>
                            <button @click="PageDelete(page)" type="button">
                                <i class="fa-duotone fa-trash"></i> O'chirish
                            </button>
                        </main>
                    </div>
                    <div
                        :class="{'editable': editable == false}"
                        class="ruzzifer-page"
                        :style="{
                            paddingLeft: page.settings.paddingLeft + 'mm',
                            paddingRight: page.settings.paddingRight + 'mm',
                            paddingTop: page.settings.paddingTop + 'mm',
                            paddingBottom: page.settings.paddingBottom + 'mm',
                        }"
                        :contenteditable="editable"
                        @input="(event: any) => PageEdit(event, page)">
                    </div>
                    <PrintPoints
                        v-if="editable == false" 
                        :pattern="selected" :number="Math.random()"
                        :clickable="selected.backup == null"
                        class="absolute bottom-3 w-full px-4"
                    />
                </section>
            </aside>
        </main>
    </main>
</template>

<script setup lang="ts">
import PagePaddings from './TextRedactor/PagePaddings.vue'
import Buttons from './TextRedactor/Buttons.vue'
import { computed, onMounted, ref } from 'vue'
import Swal from '../modules/swal'
import PrintPoints from './PrintPoints.vue'
const QRCode = require('qrcode')
const { modelValue, editable , selected, print } = defineProps(['modelValue', 'editable', 'selected', 'print'])
const emit = defineEmits(['update:modelValue'])


const defaultSet = {
    html: '', opened: false, menuOpened: false,
    settings: { paddingLeft: 15, paddingRight: 15, paddingTop: 15, paddingBottom: 15},
}

if(modelValue == null || modelValue.length == 0) modelValue[0] = structuredClone(defaultSet)



const QrCodeIsset = computed(() => {
    if(selected) return selected.positions.some((pos) => pos.position.priority == 1) && selected.positions.every((pos) => pos.check == true)
    else return false
})

function PageCreate(){
    modelValue.push(structuredClone(defaultSet))
}

function PageDelete(page){
    const index = modelValue.findIndex((element) => element == page)
    
    Swal.fire({
        title: "Aniq o'chirmoqchimisiz ?",
        text: "Sahifa malumotlari o'chib ketadi!",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            modelValue.splice(index, 1);
        }
    })
    
}

function PageEdit(event, page) {
    modelValue.forEach(element => {
        if(element == page){
            element.html = event.target.innerHTML
        }
    })
    emit('update:modelValue', modelValue)
}


function closeAllModals(){
    modelValue.forEach(page => {
        page.opened = false
        page.menuOpened = false
    })
}


onMounted(() => {
    var ruzziferPages: any = null
    if(print) ruzziferPages = document.querySelectorAll('#printpage .ruzzifer-page')
    else ruzziferPages = document.querySelectorAll('.ruzzifer-page')

    ruzziferPages.forEach((element, index) => {
        element.innerHTML = modelValue[index].html
    })

    
    if(QrCodeIsset.value){
        const director = selected.positions.find((pos) => pos.position.priority == 1)
        const qrcode = document.getElementById('qrcode')
        const canvas = document.createElement('canvas')
        canvas.classList.add('real-qrcode')
        qrcode?.parentNode?.replaceChild(canvas, qrcode)

        QRCode.toCanvas(canvas,`Hujjat: ${selected.id}, Imzoladi: ${director.user.name}` , {
            width: 135
        })
    }

})
</script>
