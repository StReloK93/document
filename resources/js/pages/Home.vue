<template>
    <section>
        Hello Moto <button @click="store.dispatch('logout')">Leave</button>
        <div id="container"></div>
        <!-- <form>
            <UploadImage :Result="Result" @change-file="changeFile"></UploadImage>
            <button>
                Add
            </button>
        </form> -->
    </section>
</template>

<script setup lang="ts">
import UploadImage from '../components/UploadImage.vue'
import { renderAsync } from 'docx-preview'
import { reactive } from 'vue'
import { useStore } from 'vuex'

// import moment from 'moment'
// import Swal from 'sweetalert2'
// import axios from 'axios'
const store = useStore()

function changeFile(){
    const container = document.getElementById('container') as HTMLDivElement
    console.log(Result.images[0]);
    
    renderAsync(Result.images[0], container)
        .then(x => console.log("docx: finished"));
}

const Result = reactive({
    images: []
})
</script>
