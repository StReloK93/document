import { createApp } from "vue"

import App from './App.vue'
import store from "./store/"
import router from "./router/"
import { AgGridVue } from "ag-grid-vue3"
import VueSelect from 'vue-multiselect'
import Loader from './components/Loader.vue'

import "ag-grid-community/styles/ag-grid.css"
import "ag-grid-community/styles/ag-theme-alpine.css"
import "vue-multiselect/dist/vue-multiselect.css"
import 'swiper/css/pagination'
import 'swiper/css'

store.dispatch('getUser').then(() =>{
    createApp(App)
    .component('AgGrid', AgGridVue)
    .component('VueSelect', VueSelect)
    .component('Loader', Loader)
    .use(store)
    .use(router)
    .mount('#app')
})