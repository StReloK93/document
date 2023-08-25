<template>
    <main @click.stop class="ruzzifer-page-paddings noprint">
        <header class="ruzzifer-header noprint">
            <button type="button" @click.stop="page.opened = false" class="px-4 py-1.5 hover:text-red-500">
                <i class="fa-light fa-xmark"></i>
            </button>
        </header>
        <table>
            <tr>
                <td style="width: 40px"></td>
                <td>
                    <input @keydown.enter.prevent style="text-align: center;" type="text" v-model="page.settings.paddingTop">
                </td>
                <td style="width: 40px"></td>
            </tr>
            <tr>
                <td style="width: 40px">
                    <input @keydown.enter.prevent style="width: 40px;text-align: center;" type="text" v-model="page.settings.paddingLeft">
                </td>
                <td><div class="ruzzifer-mini-page"></div></td>
                <td style="width: 40px">
                    <input @keydown.enter.prevent style="width: 40px;text-align: center;" type="text" v-model="page.settings.paddingRight">
                </td>
            </tr>
            <tr>
                <td style="width: 40px"></td>
                <td>
                    <input @keydown.enter.prevent style="text-align: center;" type="text" v-model="page.settings.paddingBottom">
                </td>
                <td style="width: 40px;"></td>
            </tr>
        </table>
    </main>
</template>

<script setup lang="ts">
const { page } = defineProps(['page'])

</script>