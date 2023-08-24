<template>
    <aside class="flex justify-between mb-1">
        <section v-for="(patuser, index) in pattern.positions" :key="index" class="flex justify-center">
            <footer class="inline-flex items-center flex-col w-28 text-stone-500">
                <p class="text-center leading-none text-[13px] ">
                    {{ patuser.position.name }} 
                </p>
                <div v-if="patuser.check" class="text-[10px]">
                    {{ patuser.user?.name }}
                </div>
                <main class="flex items-center text-xs">
                    <span class="mr-3">
                        {{ moment(patuser.updated_at).format('YYYY.MM.DD HH:mm') }}
                    </span>
                </main>
            </footer>
        </section>
    </aside>
</template>

<script setup lang="ts">
import moment from 'moment'
const { pattern } = defineProps(['pattern'])
</script>