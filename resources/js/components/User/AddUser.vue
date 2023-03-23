<template>
    <section @mousedown="emit('close')" class="absolute-black-full z-50 p-8 flex justify-end">
        <form @submit.prevent="addUser" @mousedown.stop class="w-[1080px] bg-white h-full flex flex-col">
            <div class="bg-gray-100 flex justify-between">
                <aside>
                </aside>
                <button type="button" @click="emit('close')" class="px-4 py-1.5 hover:bg-gray-200  hover:text-red-500">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </div>
            <aside v-if="pageData.onloaded" class="flex-grow p-4 pt-6 flex">
                <main class="w-1/2 pr-4 border-r">
                    <div class="relative z-0 mb-6 w-full group">
                        <span class="text-red-500 absolute -top-4 right-0 text-xs" v-if="pageData.errors && pageData.errors.login">{{ pageData.errors.login[0] }}</span>
                        <input @input="pageData.errors = null" id="input2" v-model="formData.login" class="material-input peer" placeholder=" " required />
                        <label for="input2" class="material-label">Login</label>
                    </div>
                    <div class="relative z-0 mb-2 w-full group flex">
                        <input id="input1" v-model="formData.name" class="material-input peer" placeholder=" " required/>
                        <label for="input1" class="material-label">F.I.SH</label>
                    </div>
                    <RollsUser :rolls="pageData.rolls" :formdata="formData" :added="true"/>
                    <PositionsUser :positions="pageData.positions" :formdata="formData" :added="true"/>
                </main>
                <main class="w-1/2 pl-4 flex flex-col">
                    <main class="flex-grow">
                        <OrganizationsUser :organizations="pageData.organizations" :formdata="formData" :added="true"/>
                    </main>
                    <button class="w-full py-1 bg-pink-600 text-white rounded-sm shadow hover:bg-pink-500">
                        Foydalanuvchi kiritish
                    </button>
                </main>
            </aside>
            <Loader v-else class="flex-grow"/>
        </form>
    </section>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import OrganizationsUser from './OrganizationsUser.vue'
import PositionsUser from './PositionsUser.vue'
import RollsUser from './RollsUser.vue'
import axios from '../../modules/axios'
const emit = defineEmits(['close'])
const { grid } = defineProps(['grid'])

const formData = reactive({
    login: null,
    name: null,
    rolls: [],
    organizations: [],
    positions: [],
})


const pageData: any = reactive({
    positions: null,
    rolls: null,
    organizations: null,
    onloaded: false,
    errors: null,
})

function addUser(){
    axios.post('adduser', formData).then(({data, status}) => {
        if(status == 200){
            emit('close')
            grid.api.applyTransaction({
                add: [data],
            });
        }
        else if(status == 299){
            pageData.errors = data
            setTimeout(() => pageData.errors = null, 3000);
        }
    })
}


axios.all([axios.get('positions'), axios.get('rolls'), axios.get('organization/all')]).then(axios.spread( ( {data: positions}, {data: rolls},{data: organizations} ) => {

    pageData.organizations = organizations

    pageData.positions = positions

    pageData.rolls = rolls

    pageData.onloaded = true
}))
</script>