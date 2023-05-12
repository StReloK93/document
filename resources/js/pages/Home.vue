<template>
    <section class="h-full overflow-y-auto overflow-hidden relative mt-2">
        <nav class="absolute top-0 left-0 w-full">
            <main class="flex mb-4 -mx-1.5">
                <aside class="w-2/5 px-2">
                    <div class="h-40 bg-white bg-opacity-40 p-4 pt-2 shadow-sm text-gray-500 text-sm">
                        <h3 class="mb-1.5 text-gray-600 text-xl">
                            <i class="fa-regular fa-circle-exclamation text-pink-500 fa-shake"></i> Tizim haqida
                        </h3>
                        Uchbu tizim Shimoliy kon boshqarmasida ish jarayonida tayyorlangan hujjatlarni
                        tasdiqlash bosqichidan oldin ekspertlar tekshiruvidan o'tkazish uchun mo'ljallangan.
                        Tayyor hujjatlar tizimga ro'yxatga olinadi, ekspertlar tanlanadi va ekspertlar hujjatlarni tekshiradi,
                        tekshiruvdan o'tgan hujjatlar chop etilib, imzo orqali tasdiqlanadi. 
                    </div>
                </aside>
                <aside class="w-1/5 px-2">
                    <div class="h-40 bg-white p-4 flex flex-col justify-between border-b rounded-sm shadow-sm">
                        <h3 class="text-gray-400 font-semibold flex justify-between">
                            <span>
                                Umumiy kiritilgan
                            </span>
                            <i class="fa-regular fa-sigma text-blue-500 text-4xl"></i>
                        </h3>
                        <div class="mt-4 text-5xl text-right text-gray-500">
                            {{ pageData.all }}
                        </div>
                    </div>
                </aside>
                <aside class="w-1/5 px-2">
                    <div class="h-40 bg-white p-4 flex flex-col justify-between border-b rounded-sm shadow-sm">
                        <h3 class="text-gray-400 font-semibold flex justify-between">
                            <span>
                                Tasdiqlash jarayonidagi
                            </span>
                            <i class="fa-sharp fa-solid fa-down-long text-teal-500 text-4xl"></i>
                        </h3>
                        <div class="mt-4 text-5xl text-right text-gray-500">
                            {{ pageData.active }}
                        </div>
                    </div>
                </aside>
                <aside class="w-1/5 px-2">
                    <div class="h-40 bg-white p-4 flex flex-col justify-between border-b rounded-sm shadow-sm">
                        <h3 class="text-gray-400 font-semibold flex justify-between">
                            <span>
                                Tasdiqdan o'tgan
                            </span>
                            <i class="fa-regular fa-check text-pink-500 text-4xl"></i>
                        </h3>
                        <div class="mt-4 text-5xl text-right text-gray-500">
                            {{ pageData.succes }}
                        </div>
                    </div>
                </aside>
            </main>
            <main class="flex flex-wrap">
                <aside class="w-full flex mb-4">
                    <div id="chartContainer1" class="pr-4 w-2/3"></div>
                    <div id="chartContainer2" class="w-1/3"></div>
                </aside>
                <aside class="w-full flex">
                    <div id="chartContainer3" class="pr-4 w-1/3"></div>
                    <div id="chartContainer4" class="w-2/3"></div>
                </aside>
            </main>
        </nav>
    </section>
</template>

<script setup lang="ts">
import { onMounted, reactive } from 'vue'
import axios from '../modules/axios';
import { mainChartInit } from '../modules/PerMonthChart'
import { organizationChart } from '../modules/PerOrganizationsChart'
import { useStore } from 'vuex';
const store = useStore()


const pageData:any = reactive({
    all: null,
    active: null,
    succes: null,
})

function getPerMonth(){
    axios.get('document/permonth').then(({data}) => {
        const documents:any = []

        const MainObj:any = { name: 'Umumiy', data: [] }
        for (let index = 1; index < 13; index++) {
            if(data[index]) MainObj.data.push(data[index].length)
            else MainObj.data.push(0)
        }
        documents.push(MainObj)

        store.getters.userOrganizations.forEach( org => {
            const object:any = { name: org.organization.shortname, data: [], visible: false }
            
            for (let index = 1; index < 13; index++) {
                if(data[index]) {
                    const mapps = data[index].filter(document => document.organization_id == org.organization_id)
                    object.data.push(mapps.length)
                }
                else object.data.push(0)
            }

            if(object.data.every(item => item == 0) == false) documents.push(object)
        });

        mainChartInit('chartContainer1',documents, "Bo'linmalar bo'yicha hujjatlar soni")
    })
}

function getPerOrganizations(){
    axios.get('document/perorganizations').then(({data}) => {
        const organizations:any = []
        for (const key in data) {
            organizations.push({name: key, y: data[key].length})
        }
        organizationChart('chartContainer2',organizations, "Bo'linmalar")
    })
}


function getPerTypes(){
    axios.get('document/pertypes').then(({data}) => {
        const organizations:any = []
        for (const key in data) {
            organizations.push({name: key, y: data[key].length})
        }
        organizationChart('chartContainer3', organizations , 'Hujjat turlari')
    })
}

function getTypesMonth(reject_types){
    axios.get('document/pertypesmonth').then(({data}) => {
        const documents:any = []
        
        reject_types.forEach( (type, index) => {
            const object:any = { name: type.name, data: [], visible: index == 0 ? true: false }
            
            for (let index = 1; index < 13; index++) {
                if(data[index]) {
                    const mapps = data[index].filter(document => document.reject_type_id == type.id)
                    object.data.push(mapps.length)
                }
                else object.data.push(0)
            }

            if(object.data.every(item => item == 0) == false) documents.push(object)
        });

        mainChartInit('chartContainer4',documents, "Hujjat turlari bo'yicha hujjatlar soni")
    })
}

axios.get('documents').then(({ data:documents }) => {
    pageData.all = documents.length

    pageData.succes = documents.filter( (doc) => doc.positions.every(item => item.check == true) ).length
    pageData.active = documents.filter( (doc) => doc.positions.every(item => item.check == true) == false ).length
    
})

onMounted(() => {
    getPerMonth()
    getPerOrganizations()
    getPerTypes()

    axios.get('reject-type').then(({ data: reject_types }) => getTypesMonth(reject_types))
})
</script>
<style>
.highcharts-credits{
    display: none;
}

.highcharts-axis-title{
    display: none;
}
</style>