<template>
    <agGrid 
        class="h-72 ag-theme-alpine"
        :getRowId="(params) => params.data.id"
        :rowData="positions"
        :columnDefs="columns"
        @grid-ready="onGridReady"
    >
    </agGrid>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import axios from '../../modules/axios'
import { useStore } from 'vuex'
const store = useStore()
const { positions, formdata , access , added } = defineProps(['positions', 'formdata', 'access', 'added'])

const grid:any = reactive({api: null})

const columns = reactive([
    { field: "name", headerName: 'Lavozimlar', flex: 1 , headerClass: ['font-semibold', 'text-gray-600']},
    {
        field: "isset",
        headerName: '', cellRenderer: (cell) => {
            return cell.value ? '<i class="fa-sharp fa-solid fa-toggle-on text-pink-600"></i>': '<i class="fa-sharp fa-solid fa-toggle-off text-gray-300"></i>'
        },
        width: 60,
        onCellClicked: cellClicked,
        cellClass: ['text-center', 'hover:bg-gray-200',  'active:bg-pink-100', 'cursor-pointer']
    },
])




function add(cell, rowNode){
    if(cell.value) {
        rowNode.setDataValue('isset', false)
        formdata.positions = formdata.positions.filter(position => position.id != cell.data.id)
    }
    else { 
        rowNode.setDataValue('isset', true)
        formdata.positions.push(cell.data)
    }
}


function edit(cell, rowNode){
    if(cell.value) axios.post('userpositions', {id: cell.data.id, user_id: formdata.id})
        .then(() => {
            rowNode.setDataValue('isset', false)
            formdata.positions = formdata.positions.filter(position => position.position_id != cell.data.id)

            if(formdata.id == store.state.user.id) store.state.user.positions = formdata.positions.filter(position => position.position_id != cell.data.id)
        })
    else axios.put('userpositions', {id: cell.data.id, user_id: formdata.id})
        .then(({ data }) => {
            rowNode.setDataValue('isset', true)
            formdata.positions.push(data)

            if(formdata.id == store.state.user.id) store.state.user.positions.push(data)
        })
}

function cellClicked(cell){
    const rowNode = grid.api.getRowNode(cell.data.id)

    if(access == false) return
    if(added) add(cell, rowNode)
    else edit(cell, rowNode)
    
}


function onGridReady(params){
    grid.api = params.api
}

</script>
