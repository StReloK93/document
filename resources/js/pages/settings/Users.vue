<template>
    <section class="h-full w-full flex flex-col">
        <SelectedUser
            v-if="pageData.selected"
            :user="pageData.selected"
            :grid="grid"
            :access="true"
            @close="pageData.selected = false"
        />
        <AddUser
            v-if="pageData.addUser"
            :grid="grid"
            @close="pageData.addUser = false"
        />
        <main class="flex justify-between items-center mb-2">
            <h3 class="text-xl text-gray-700">
                Foydalanuvchilar
            </h3>
            <button @click="pageData.addUser = true">
                <i class="fa-sharp fa-regular fa-plus text-pink-500 text-xl px-3 py-1 bg-gray-50 hover:bg-pink-200 active:bg-gray-200 shadow-sm border border-pink-200"></i>
            </button>
        </main>
        <main class="flex-grow">
            <agGrid 
                class="h-full ag-theme-alpine" 
                @grid-ready="(params) => grid.api = params.api"
                :getRowId="(params) => params.data.id" 
                :rowData="pageData.users" 
                :columnDefs="columns"
                :animateRows="true"
            />
        </main>
    </section>
</template>
<script setup lang="ts">
import axios from '../../modules/axios'
import swal from '../../modules/swal'
import SelectedUser from '../../components/User/SelectedUser.vue'
import { reactive } from 'vue'
import AddUser from '../../components/User/AddUser.vue'
const grid: any = reactive({
    api: null
})


const pageData: any = reactive({
    users: [],
    selected: null,
    addUser: false,
})

const columns = reactive([
    { field: "id", headerName: 'ID', width: 60 },
    { field: "login", headerName: 'Login', cellClass: ['text-gray-700', 'font-semibold'] },
    { field: "name", headerName: 'Nomi', flex: 1},
    { field: "created_at", headerName: ''},
    { 
        headerName: '',
        width: 60,
        cellClass: ['text-center', 'hover:bg-gray-200',  'active:bg-pink-100', 'cursor-pointer'],
        cellRenderer: () => '<i class="fa-regular fa-screwdriver-wrench text-pink-500""></i>',
        onCellClicked: (cell) => pageData.selected = cell.data
    },
])

axios.get('users').then(({ data }) => pageData.users = data)


function deleteType(cell){
    swal.fire({
        title: "Aniq o'chirmoqchimisiz?",
        text: "Malumotni qayta tiklab bo'lmaydi!",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`positions/${cell.data.id}`).then(() => {
                grid.api.applyTransaction({remove: [cell.data]})
            })
        }
    })
}
</script>
<style src="./../../modules/ag-grid.css"></style>