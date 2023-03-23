<template>
    <Transition name="fade">
        <SelectedDocument
            v-if="pageData.selected"
            @deleted="deleted"
            :grid="grid"
            :id="pageData.selected.id"
            @close="pageData.selected = null"
        />
    </Transition>
    <section class="h-full flex flex-col">
        <main class="flex justify-between items-center pb-2">
            <h3 class="text-xl text-gray-700">Rad etilgan hujjatlar</h3>
        </main>
        <main class="flex-grow">
            <agGrid 
                class="h-full ag-theme-alpine" 
                :rowSelection="'single'"
                :rowClass="['!bg-yellow-50']"
                :getRowId="(params) => params.data.id"
                :rowData="pageData.documents"
                :columnDefs="pageData.columnDefs"
                @rowClicked="onSelectionChanged"
                @grid-ready="(params) => grid.api = params.api"
                :animateRows="true"
            >
            </agGrid>
        </main>
    </section>
</template>

<script setup lang="ts">
import SelectedDocument from '../../components/Document/SelectedDocument.vue'
import { reactive } from 'vue'
import axios from '../../modules/axios';
import column from './column';
import { useStore } from 'vuex'

const store = useStore()

const pageData: any = reactive({
    addDocument: false,
    documents: null,
    selected: null,
    columnDefs: column
})

const grid:any = reactive({api: null})
axios.get('documentsbackup').then(({data}) => pageData.documents = data)

function deleted(selected){
    grid.api.applyTransaction({remove: [selected]})
}

function onSelectionChanged(){
    pageData.selected = false
    setTimeout(() => pageData.selected = grid.api.getSelectedRows()[0] )
}
</script>
<style src="./../../modules/ag-grid.css"></style>