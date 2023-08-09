<template>
    <TransitionGroup name="fade">
        <SelectedDocument
            v-if="pageData.selected"
            @deleted="deleted"
            :grid="grid"
            @edit="openEdit"
            :id="pageData.selected.id"
            @close="pageData.selected = null"
        />
        <EditDocument
            class="z-50"
            :grid="grid" 
            v-if="pageData.editDocument" 
            :id="pageData.editDocument"
            @close="pageData.editDocument = null"
        />
    </TransitionGroup>
    <section class="h-full flex flex-col">
        <main class="flex justify-between items-center pb-2">
            <h3 class="text-xl text-gray-700">Rad etilgan hujjatlar</h3>
            <label for="filtered">
                <span class="text-sm text-gray-500">
                    Mening  hujjatlarim
                </span>
                <main class="w-8 h-4 ml-4 bg-white inline-flex rounded-md shadow items-center px-0.5">
                    <div :class="{ '!bg-pink-500 ml-[16px]': pageData.onlyMy }"
                        class="w-3 h-3 rounded-full bg-gray-500 transition-all"></div>
                </main>
            </label>
            <input hidden id="filtered" type="checkbox" class="mx-4" v-model="pageData.onlyMy"
                @change="changeFilter">
        </main>
        <main class="flex-grow">
            <agGrid 
                class="h-full ag-theme-alpine" 
                :rowSelection="'single'"
                :rowClass="['!bg-red-50']"
                :getRowId="(params) => params.data.id"
                :rowData="pageData.documents"
                :columnDefs="pageData.columnDefs"
                @rowClicked="onSelectionChanged"
                @grid-ready="(params) => grid.api = params.api"
                :animateRows="true"
                :doesExternalFilterPass="doesExternalFilterPass"
                :isExternalFilterPresent="() => true"
            >
            </agGrid>
        </main>
    </section>
</template>

<script setup lang="ts">
import SelectedDocument from '../../components/Document/SelectedDocument.vue'
import EditDocument from '../../components/Document/EditDocument.vue'
import { reactive } from 'vue'
import axios from '../../modules/axios';
import column from './column';
import { useStore } from 'vuex'
const store = useStore()

function doesExternalFilterPass(node) {

    if (pageData.onlyMy == true) return node.data.user_id == store.state.user.id
    else return true

}

function changeFilter(){
    localStorage.setItem('filter', pageData.onlyMy)
    grid.api.onFilterChanged()
}

const pageData: any = reactive({
    editDocument: false,
    documents: null,
    selected: null,
    columnDefs: column(store.getters.userPositions),
    onlyMy: JSON.parse(localStorage.getItem('filter') as string) 
})

const grid:any = reactive({api: null})


axios.get('documentsnegations').then(({data}) => pageData.documents = data)

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