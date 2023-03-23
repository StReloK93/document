<template>
    <section class="flex justify-between text-sm pt-3 pb-2 flex-wrap -mx-2">
        <div v-for="(roll, index) in rolls" :key="index" class="px-2 w-1/3 mb-4">
            <button type="button" @click="cellClicked(roll)"
                class="px-2 py-1 bg-gray-100 shadow w-full rounded-sm hover:shadow-md transition-all"
                :class="{'bg-pink-600 text-pink-100 shadow-md': roll.isset}"
            >
                <span class="pr-6">
                    {{ roll.name }}
                </span>
                <i class="fa-light text-pink-600" :class="[{'!text-pink-300': roll.isset}, icons[index]]"></i>
            </button>
        </div>
    </section>
</template>

<script setup lang="ts">
import axios from '../../modules/axios'
import { useStore } from 'vuex'
const store = useStore()
const { rolls, formdata, access , added } = defineProps(['rolls', 'formdata', 'access', 'added'])
const icons: any = ['fa-user-plus', 'fa-pen-nib', 'fa-trash', 'fa-screwdriver-wrench']



function edit(cell){
    if(cell.isset) axios.post('userrolls', {id: cell.id, user_id: formdata.id})
        .then(() => {
            formdata.rolls = formdata.rolls.filter(roll => roll.roll_id != cell.id)
            rolls.find(roll => roll.id == cell.id).isset = false

            if(formdata.id == store.state.user.id) store.state.user.rolls = formdata.rolls.filter(roll => roll.roll_id != cell.id)
        })
    else axios.put('userrolls',{id: cell.id, user_id: formdata.id})
        .then(({ data }) => {
            formdata.rolls.push(data)
            rolls.find(roll => roll.id == cell.id).isset = true

            if(formdata.id == store.state.user.id) store.state.user.rolls.push(data)
        })
}

function add(cell){
    if(formdata.rolls.includes(cell)){
        formdata.rolls = formdata.rolls.filter((roll => roll.id != cell.id))
        rolls.find(roll => roll.id == cell.id).isset = false
    }
    else {
        formdata.rolls.push(cell)
        rolls.find(roll => roll.id == cell.id).isset = true
    }
}
function cellClicked(cell){
    if(access == false) return

    if(added) add(cell)
    else edit(cell)
}


</script>