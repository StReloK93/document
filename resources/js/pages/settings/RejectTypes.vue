<template>
    <section class="flex h-full relative">
        <aside class="h-full w-1/2 flex flex-col">
            <RejectTypeEditor 
                v-if="reject_type_selected"
                :gridapi="grid.api"
                :reject_type="reject_type_selected"
                @close="reject_type_selected = null"
            ></RejectTypeEditor>
            <main class="flex justify-between items-center mb-2">
                <h3 class="text-xl text-gray-700">
                    Hujjat turlari
                </h3>
                <button @click="storeType">
                    <i class="fa-sharp fa-regular fa-plus text-pink-500 text-xl px-3 py-1 bg-gray-50 hover:bg-pink-200 active:bg-gray-200 shadow-sm border border-pink-200"></i>
                </button>
            </main>
            <main class="flex-grow">
                <agGrid 
                    class="h-full ag-theme-alpine" 
                    @grid-ready="(params) => grid.api = params.api"
                    @cellValueChanged = cellEdit
                    :getRowId="(params) => params.data.id" 
                    :rowData="types" 
                    :columnDefs="columns"
                    :animateRows="true"
                >
                </agGrid>
            </main>
        </aside>
    </section>
</template>
<script setup lang="ts">
import axios from '../../modules/axios'
import { ref, reactive } from 'vue'
import swal from '../../modules/swal'
import RejectTypeEditor from '../../components/RejectTypeEditor.vue'
const grid: any = reactive({
    api: null
})

const types = ref([])
const reject_type_selected = ref(null)
const columns = reactive([
    { field: "id", headerName: 'ID', width: 60 },
    { field: "name", headerName: 'Nomi', flex: 1 , editable: true},
    { field: "html", headerName: 'html', hide: true },
    { 
        headerName: '',
        width: 60,
        cellClass: ['text-center', 'hover:bg-gray-200',  'active:bg-pink-100', 'cursor-pointer'],
        cellRenderer: () => '<i class="fa-sharp fa-light fa-keyboard text-sky-600"></i>',
        onCellClicked: (cell) => reject_type_selected.value = cell.data
    },
    { 
        headerName: '',
        width: 60,
        cellClass: ['text-center', 'hover:bg-gray-200',  'active:bg-pink-100', 'cursor-pointer'],
        cellRenderer: () => '<i class="fa-duotone fa-trash text-pink-600"></i>',
        onCellClicked: deleteType
    },
])

axios.get('reject-type').then(({ data }) => {
    data.forEach(element => {
        if(element.html == null) element.html = []
        else element.html = JSON.parse(element.html)
    })
    
    types.value = data
})



function storeType() {
    axios.post('reject-type', { name: 'nomlang' }).then(({ data }) => {
        data.html = []
        grid.api.applyTransaction({
            add: [data],
        });
    })
}

function cellEdit(cell) {
    const rowNode = grid.api.getRowNode(cell.data.id)
    axios.patch(`reject-type/${cell.data.id}`, { name: cell.value }).then(() => {
        rowNode.setDataValue('name', cell.value)
    })
}


function deleteType(cell){
    swal.fire({
        title: "Aniq o'chirmoqchimisiz?",
        text: "Malumotni qayta tiklab bo'lmaydi!",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`reject-type/${cell.data.id}`).then(() => {
                grid.api.applyTransaction({remove: [cell.data]})
            })
        }
    })
}
</script>
<style src="./../../modules/ag-grid.css"></style>