<template>
    <Transition name="fade">
        <SelectedDocument
            v-if="pageData.selected"
            @deleted="(selected) => grid.api.applyTransaction({remove: [selected]})"
            :grid="grid"
            :id="pageData.selected.id"
            @close="pageData.selected = null"
        />
    </Transition>
    <section class="h-full flex flex-col">
        <main class="flex justify-between items-center pb-2">
            <h3 class="text-xl text-gray-700">Tasdiqdan o'tgan hujjatlar</h3>
        </main>
        <main class="flex-grow">
            <agGrid 
                class="h-full ag-theme-alpine" 
                :rowSelection="'single'"
                :getRowId="(params) => params.data.id"
                :rowData="pageData.documents"
                :columnDefs="pageData.columnDefs"
                @rowClicked="onSelectionChanged"
                @grid-ready="(params) => grid.api = params.api"
                :animateRows="true"
                :doesExternalFilterPass="(node) => node.data.positions.every((pos) => pos.check == true)"
                :isExternalFilterPresent="() => filter != 'all'"
            >
            </agGrid>
        </main>
    </section>
</template>

<script setup lang="ts">
import SelectedDocument from '../../components/Document/SelectedDocument.vue'
import { reactive, ref } from 'vue'
import axios from '../../modules/axios';
import column from './column';
const filter = ref('contain')

const pageData: any = reactive({
    addDocument: false,
    documents: null,
    selected: null,
    columnDefs: column
})

const grid:any = reactive({api: null})


axios.get('documents').then(({data}) => pageData.documents = data)

function onSelectionChanged(){
    pageData.selected = false
    setTimeout(() => pageData.selected = grid.api.getSelectedRows()[0] )
}
</script>
<style src="./../../modules/ag-grid.css"></style>