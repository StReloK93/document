<template>
    <TransitionGroup name="fade">
        <AddDocument
            class="z-50" 
            v-if="pageData.addDocument"
            @close="pageData.addDocument = false"
            @created="created"
        />
        <EditDocument
            class="z-50"
            :grid="grid" 
            v-if="pageData.editDocument" 
            :id="pageData.editDocument"
            @close="pageData.editDocument = null"
        />
        <SelectedDocument
            v-if="pageData.selected"
            @deleted="deleted"
            @edit="openEdit"
            :grid="grid"
            :id="pageData.selected.id"
            @close="pageData.selected = null; grid.api.deselectAll()"
        />
    </TransitionGroup>
    <section class="h-full flex flex-col">
        <main class="flex justify-between items-center pb-2">
            <h3 class="text-xl text-gray-700">Tasdiqlash jarayonidagi hujjatlar</h3>
            <button v-if="store.getters.userRolls.includes(1)" @click="pageData.addDocument = true">
                <i class="fa-sharp fa-regular fa-plus text-pink-500 text-xl px-3 py-1 bg-gray-50 hover:bg-pink-200 active:bg-gray-200 shadow-sm border border-pink-200"></i>
            </button>
        </main>
        <main class="flex-grow">
            <agGrid 
                class="h-full ag-theme-alpine" 
                :rowSelection="'single'"
                :rowClassRules="pageData.rowClassRules"
                :getRowId="(params) => params.data.id"
                :rowData="pageData.documents"
                :columnDefs="pageData.columnDefs"
                @rowClicked="onSelectionChanged"
                :doesExternalFilterPass="doesExternalFilterPass"
                :isExternalFilterPresent="() => filter != 'all'"
                @grid-ready="(params) => grid.api = params.api"
                :animateRows="true"
            >
            </agGrid>
        </main>
    </section>
</template>

<script setup lang="ts">
import AddDocument from '../../components/Document/AddDocument.vue'
import EditDocument from '../../components/Document/EditDocument.vue'
import SelectedDocument from '../../components/Document/SelectedDocument.vue'
import { reactive , ref } from 'vue'
import axios from '../../modules/axios'
import moment from 'moment'
import column from './column'
import { useStore } from 'vuex'

const store = useStore()
const filter = ref('contain')

function doesExternalFilterPass(node){
    return node.data.positions.every((position) => position.check == true) == false
}

const pageData: any = reactive({
    addDocument: false,
    editDocument: null,
    documents: null,
    selected: null,
    rowClassRules: {
        '!bg-pink-50': function(params) { return params.data.term != null; },
    },
    columnDefs: [...column, {

        field: "term", headerName: 'Muddat' , width: 100, cellClass: ['font-semibold'],
        cellRenderer: (cell) => {
            const current = moment()
            if(cell.value) {
                return moment(cell.value).diff( current, 'days') + 1 + ' Kun'
            }
            else return '<i class="fa-sharp fa-regular fa-infinity text-pink-600"></i>'
        }
    },]
})

const grid:any = reactive({api: null})


axios.get('documents').then(({data}) => pageData.documents = data)

function created(element){
    grid.api.applyTransaction({add: [element],index: 0})
}

function openEdit(id){
    pageData.selected = null
    pageData.editDocument = id
}

function deleted(selected){
    grid.api.applyTransaction({remove: [selected]})
}

function onSelectionChanged(){
    pageData.selected = false
    setTimeout(() => pageData.selected = grid.api.getSelectedRows()[0] )
}
</script>
<style src="./../../modules/ag-grid.css"></style>