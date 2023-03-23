<template>
    <section class="w-72 bg-white shadow-md">
        <!-- Logo -->
        <main class="flex items-center py-2 px-5  mb-3">
            <div class="w-10 h-10 flex-center mr-3 rounded-full">
                <i class="fa-solid fa-pen-nib text-pink-500 text-xl"></i>
            </div>
            <div class="leading-none text-[16px] font-semibold text-gray-700">
                Hujjatlarni <br> tasdiqlash <br>
                <span class="leading-none">
                    tizimi
                </span> 
            </div>
        </main>
        <!--  -->

        <main class="mb-8">
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/">
                <i class="fa-duotone fa-house text-pink-500 mr-1"></i> Bosh sahifa
            </router-link>
        </main>

        <!-- User Info -->
        <main class="mb-8">
            <h4 class="text-sm text-gray-500 px-6 py-1.5 border-x-[3px] border-transparent">
                <i class="fa-duotone fa-books text-pink-500 mr-1"></i> Hujjatlar
            </h4>

            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/process">
                Tasdiqlash jarayonida
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/finished">
                Tasdiqdan o'tgan
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/rejected">
                Rad etilgan
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/backup">
                Bekor qilingan
            </router-link>
        </main>

        <!-- User Info -->
        <main class="mb-8" v-if="store.getters.userRolls.includes(4)">
            <h4 class="text-sm text-gray-500 px-6 py-1.5 border-x-[3px] border-transparent">
                <i class="fa-duotone fa-screwdriver-wrench text-pink-400 mr-1"></i>
                Admin
            </h4>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/users">
                Foydalanuvchilar
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/bans">
                Rad etish sabablari
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/positions">
                Tasdiqlovchilar
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/rejecttypes">
                Hujjat turlari
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/organizations">
                Bo'linmalar
            </router-link>
        </main>


         <!-- Settings -->
         <main>
            <h4 class="text-sm text-gray-500 px-6 py-1.5 border-x-[3px] border-transparent">
                <i class="fa-duotone fa-gears text-pink-400 mr-1"></i>
                Sozlamalar
            </h4>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/subscribes">
                Tasdiqlovchilar shablonlari
            </router-link>
            <router-link class="block border-x-[3px] border-transparent hover:bg-pink-50 px-6 py-2 leftmenu transition-all duration-700" to="/password">
                Parolni o'zgartirish
            </router-link>
        </main>
    </section>
</template>

<script setup lang="ts">
import { useStore } from 'vuex'
const store = useStore()
</script>