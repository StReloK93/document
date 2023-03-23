<template>
    <agGrid class="h-full ag-theme-alpine" :getRowId="(params) => params.data.id" :rowData="organizations"
        :columnDefs="columns" @grid-ready="onGridReady">
    </agGrid>
</template>

<script setup lang="ts">
import axios from '../../modules/axios'
import { useStore } from 'vuex'
import { reactive } from 'vue'
const { organizations, formdata, access, added } = defineProps(['organizations', 'formdata', 'access', 'added'])
const store = useStore()


const grid: any = reactive({
    api: null
})

const columns = reactive([
    { field: "fullname", headerName: 'Nomi', flex: 1, headerClass: ['font-semibold', 'text-gray-600'] },
    { field: "shortname", headerName: 'Qisqa nomi', headerClass: ['font-semibold', 'text-gray-600'] },
    {
        field: "isset",
        headerName: '', cellRenderer: (cell) => {
            const iconClass = cell.value ? 'fa-toggle-on text-pink-600' : 'fa-toggle-off text-gray-300'
            return `<i class="fa-sharp fa-solid ${iconClass}"></i>`
        },
        width: 60,
        onCellClicked: cellClicked,
        cellClass: ['text-center', 'hover:bg-gray-200', 'active:bg-pink-100', 'cursor-pointer']
    },
])

function add(cell, rowNode) {
    if (cell.value) {
        rowNode.setDataValue('isset', false)
        formdata.organizations = formdata.organizations.filter(organ => organ.id != cell.data.id)
    }
    else {
        rowNode.setDataValue('isset', true)
        formdata.organizations.push(cell.data)
    }
}

function edit(cell, rowNode) {
    if (cell.value) axios.post('userorganizations', { id: cell.data.id, user_id: formdata.id })
        .then(() => {
            rowNode.setDataValue('isset', false)
            formdata.organizations = formdata.organizations.filter(organ => organ.organization_id != cell.data.id)

            if (formdata.id == store.state.user.id) store.state.user.organizations = formdata.organizations.filter(organ => organ.organization_id != cell.data.id)


        })
    else axios.put('userorganizations', { id: cell.data.id, user_id: formdata.id })
        .then(({ data }) => {
            rowNode.setDataValue('isset', true)
            formdata.organizations.push(data)

            // Agar foydalanuvchi uziga teng bo'lsa
            if (formdata.id == store.state.user.id) store.state.user.organizations.push(data)

        })
}


function cellClicked(cell) {
    if (access == false) return
    const rowNode = grid.api.getRowNode(cell.data.id)
    if (added) add(cell, rowNode)
    else edit(cell, rowNode)
}


function onGridReady(params) {
    grid.api = params.api
}

</script>