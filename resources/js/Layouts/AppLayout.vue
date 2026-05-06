<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    hideNav: { type: Boolean, default: false }
});

const page = usePage();
const flash = computed(() => page.props.flash);
</script>

<template>
    <div class="min-h-screen flex flex-col bg-[#f9f9f9] text-[#1b1b1b] font-body-md">
        <!-- Navigation (TopNavBar) -->
        <nav v-if="!hideNav" class="bg-white w-full top-0 sticky border-b-[3px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-50">
            <div class="flex justify-between items-center px-6 py-2 max-w-full">
                <Link :href="route('home')" class="font-headline-lg text-[24px] text-primary tracking-tighter font-black">CV Builder</Link>
                <div class="hidden md:flex gap-8 font-button-text text-[14px]">
                    <Link :href="route('home')" class="text-on-surface-variant hover:text-black transition-all px-2 py-1" :class="route().current('home') ? 'border-b-[3px] border-tertiary-container' : ''">Home</Link>
                    <Link :href="route('cv.index')" class="text-on-surface-variant hover:text-black transition-all px-2 py-1" :class="route().current('cv.index') ? 'border-b-[3px] border-tertiary-container' : ''">Drafts</Link>
                    <a class="text-on-surface-variant hover:text-black transition-all px-2 py-1" href="#">Help</a>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-[#FFFF00] text-black border-[3px] border-black rounded-full px-6 py-1 font-bold text-[14px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] transition-all active:translate-x-[4px] active:translate-y-[4px] active:shadow-none hidden md:block">
                        Create New
                    </button>
                    <button class="text-primary hover:scale-105 transition-all">
                        <span class="material-symbols-outlined" style="font-size: 32px;">account_circle</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Flash Messages -->
            <div v-if="flash.success || flash.error" class="fixed top-24 left-1/2 -translate-x-1/2 z-40 w-full max-w-md px-4">
                <div v-if="flash.success" class="bg-green-100 border-2 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center justify-between">
                    <span class="font-bold text-green-800">{{ flash.success }}</span>
                    <button @click="flash.success = null" class="font-bold">×</button>
                </div>
                <div v-if="flash.error" class="bg-red-100 border-2 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center justify-between">
                    <span class="font-bold text-red-800">{{ flash.error }}</span>
                    <button @click="flash.error = null" class="font-bold">×</button>
                </div>
            </div>

            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-[#eeeeee] w-full mt-auto border-t-[3px] border-black">
            <div class="flex flex-col md:flex-row justify-between items-center px-6 py-8 gap-4 max-w-7xl mx-auto">
                <div class="font-headline-lg text-[24px] text-primary tracking-tighter font-black">CV Builder</div>
                <div class="flex gap-8 font-bold text-[12px] uppercase">
                    <a class="text-on-surface-variant hover:text-black transition-colors" href="#">Privacy Policy</a>
                    <a class="text-on-surface-variant hover:text-black transition-colors" href="#">Terms of Service</a>
                    <a class="text-on-surface-variant hover:text-black transition-colors" href="#">Cookies</a>
                </div>
                <div class="font-bold text-[12px] text-on-surface">© 2024 CV Builder. ALL RIGHTS RESERVED.</div>
            </div>
        </footer>
    </div>
</template>
