<template>
    <section class="flex h-full">
        <aside class="h-full w-full flex flex-col">
            <main class="flex justify-between items-center mb-2">
                <h3 class="text-xl text-gray-700">
                    Bo'linmalar
                </h3>
                <div class="h-[30px]">

                </div>
            </main>
            <main class="flex-grow">
                <agGrid 
                    class="h-full ag-theme-alpine" 
                    :getRowId="(params) => params.data.id"
                    :rowData="organizations"
                    :columnDefs="columns"
                    @grid-ready="onGridReady"
                >
                </agGrid>
            </main>
        </aside>
    </section>
</template>

<script setup lang="ts">
import axios from '../../modules/axios'
import { ref, reactive } from 'vue'
const grid:any = reactive({
    api: null
})

const organizations = ref([])

const columns = reactive([
    { field: "id", headerName: 'ID', width: 60 },
    { field: "fullname", headerName: 'Nomi', flex: 1 },
    { field: "shortname", headerName: 'Qisqa nomi' },
    {
        field: "isset",
        headerName: '', cellRenderer: (cell) => {
            const iconClass = cell.value ? 'text-pink-500': 'text-gray-300'
            return `<i class="fa-solid fa-circle-check ${iconClass}"></i>`
        },
        width: 60,
        onCellClicked: cellClicked,
        cellClass: ['text-center', 'hover:bg-gray-200',  'active:bg-pink-100', 'cursor-pointer']
    },
])

axios.get('organization').then(({ data }) => {
    data.organizations.forEach((organization) => {
        organization.isset = data.issets.includes(+organization.id)
    })

    organizations.value = data.organizations
})


function cellClicked(cell){
    const rowNode = grid.api.getRowNode(cell.data.id)
    if(cell.value) axios.delete(`organization/${cell.data.id}`)
        .then(() => rowNode.setDataValue('isset', false))
    else axios.put(`organization/${cell.data.id}`)
        .then(() => rowNode.setDataValue('isset', true))
    
}


function onGridReady(params){
    grid.api = params.api
}

</script>
<style src="./../../modules/ag-grid.css">

</style>