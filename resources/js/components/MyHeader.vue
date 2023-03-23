<template>
    <header class="flex items-center h-[56px] justify-between mb-2 border-b">
        <SelectedUser 
            v-if="access"
            @close="access = false"
            :user="store.state.user"
            :access="false"
        />
        <main>
            <button @click="access = true" class="px-3 py-1 hover:bg-gray-100 bg-white shadow-sm text-gray-600 rounded">
                <i class="fa-solid fa-users-viewfinder text-pink-500 mr-2"></i>
                Huquqlar
            </button>
        </main>
        <main class="flex items-center">
            <div class="mr-10">
                <i class="fa-duotone fa-bell text-pink-600 text-xl"></i>
            </div>
            <div class="leading-none mr-10">
                <aside class="font-semibold">
                    {{ store.state.user.name }} 
                    <i class="fa-duotone fa-user-tie text-pink-600 ml-2"></i>
                </aside>
                <aside class="text-right text-xs text-gray-400">
                    {{ store.state.user.login }} 
                </aside>
            </div>
            <button @click="exit" class="px-5 py-1.5 text-white bg-pink-500 rounded-sm hover:bg-pink-600 active:bg-pink-400">
                <i class="fa-duotone fa-right-from-bracket"></i>
            </button>
        </main>
    </header>
</template>

<script setup lang="ts">
import SelectedUser from './User/SelectedUser.vue'
import swal from '../modules/swal'
import { ref } from 'vue'
import { useStore } from 'vuex'
const store = useStore()
const access = ref(false)


function exit(){
    swal.fire({
        title: "Tizimdan chiqmoqchimisiz?",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            store.dispatch('logout')
        }
    })
}
</script>