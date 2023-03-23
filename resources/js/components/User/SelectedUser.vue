<template>
    <section @mousedown="emit('close')" class="absolute-black-full z-50 p-8 flex justify-end">
        <main @mousedown.stop class="w-[1080px] bg-white h-full flex flex-col">
            <div class="bg-gray-100 flex justify-between">
                <main>
                    <button v-if="access == false" class="h-full">
                        <i class="fa-duotone fa-eye px-4 py-1.5 text-gray-500"></i>
                        <span class="text-xs text-gray-400">Faqat ko'rish uchun</span>
                    </button>
                </main>
                <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:bg-gray-200  hover:text-red-500">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </div>
            <aside v-if="pageData.onloaded" class="flex-grow p-4 pt-6 flex">
                <main class="w-1/2 pr-4 border-r">
                    <div class="relative z-0 mb-6 w-full group">
                        <div class="material-input peer">
                            {{ selected.login }}
                        </div>
                        <label for="input1" class="material-label">Login</label>
                    </div>
                    <form @submit.prevent="editName" class="relative z-0 mb-2 w-full group flex">
                        <main class="flex-grow">
                            <input id="input1" v-model="selected.name" class="material-input peer" :disabled="pageData.nameToggle == false" placeholder=" "/>
                            <label for="input1" class="material-label">F.I.SH</label>
                        </main>
                        <main v-if="access">
                            <button v-if="pageData.nameToggle" type="submit" class="border-b h-full px-3 bg-gray-100">
                                <i class="fa-duotone fa-floppy-disk text-pink-700"></i>
                            </button>
                            <button v-else @click="pageData.nameToggle = true" type="button" class="border-b h-full px-3 bg-gray-100">
                                <i class="fa-duotone fa-pen-nib text-pink-700"></i>
                            </button>
                        </main>
                    </form>
                    <RollsUser :rolls="pageData.rolls" :formdata="user" :access="access" />
                    <PositionsUser :positions="pageData.positions" :formdata="user" :access="access" />
                    <main v-if="access" class="text-right mt-4">
                        <div class="mb-1">
                            <span class="text-gray-500 text-xs">
                                Parolni standart holatiga keltirish
                            </span>
                        </div>
                        <button @click="clearPassword" class="px-3 bg-gray-100 py-0.5 shadow-sm rounded-sm hover:bg-gray-200">
                            <span class="text-gray-500 text-sm">
                                zzzz1111*
                            </span>
                            <i class="fa-duotone fa-key text-pink-600 ml-3 text-sm"></i>
                        </button>
                    </main>
                </main>
                <main class="w-1/2 pl-4">
                    <OrganizationsUser :organizations="pageData.organizations" :formdata="user" :access="access"/>
                </main>
            </aside>
            <Loader v-else class="flex-grow"/>
        </main>
    </section>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import OrganizationsUser from './OrganizationsUser.vue'
import PositionsUser from './PositionsUser.vue'
import RollsUser from './RollsUser.vue'
import axios from '../../modules/axios'
import { getIssets } from '../../modules/distance'
import { useStore } from 'vuex'
import Swal from 'sweetalert2'
const store = useStore()
const emit = defineEmits(['close'])

const { user , access, grid } = defineProps(['user', 'access', 'grid'])
const selected = {...user}
selected.oldName = selected.name



const pageData: any = reactive({
    positions: null,
    rolls: null,
    organizations: null,
    onloaded: false,
    nameToggle: false
})

function editName(){
    if(selected.oldName == selected.name) return pageData.nameToggle = false

    axios.post('userupdate', selected).then(() => {
        const rowNode = grid.api.getRowNode(selected.id)
        rowNode.setDataValue('name', selected.name)
        pageData.nameToggle = false
        selected.oldName = selected.name

        if(selected.id == store.state.user.id) store.state.user.name = selected.name
    })
}


function clearPassword(){
    axios.post('passwordclear', selected).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Parol o`zgartirildi',
            showConfirmButton: false,
            timer: 1500
        })
    })
}

axios.all([axios.get('positions'), axios.get('rolls'), axios.get('organization/all')]).then(axios.spread( ( {data: positions}, {data: rolls},{data: organizations} ) => {

    pageData.organizations = getIssets(organizations, selected.organizations, 'organization_id')

    pageData.positions = getIssets(positions, selected.positions, 'position_id')

    pageData.rolls = getIssets(rolls, selected.rolls, 'roll_id')

    pageData.onloaded = true
}))
</script>