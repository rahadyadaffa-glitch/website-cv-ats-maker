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
        <nav v-if="!hideNav" class="bg-[#e1e1f5] w-full top-0 sticky border-b-4 border-black shadow-[0_8px_0px_0px_rgba(0,0,0,1)] z-50 flex items-center justify-between px-6 py-3 h-[72px]">
            <div class="flex items-center">
                <Link :href="route('home')" class="text-2xl md:text-3xl font-black italic uppercase tracking-tighter text-black leading-none">CV Builder</Link>
            </div>
            <div class="hidden md:flex justify-center gap-8 font-black uppercase tracking-tighter text-[16px]">
                <Link :href="route('home')" class="text-black hover:bg-[#e4e400] transition-all px-3 py-1 border-2 border-transparent hover:border-black active:shadow-none" :class="route().current('home') ? 'bg-[#e4e400] border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white/50 border-black/10'">Home</Link>
                <Link :href="route('cv.index')" class="text-black hover:bg-[#e1e1f5] transition-all px-3 py-1 border-2 border-transparent hover:border-black active:shadow-none" :class="route().current('cv.index') || route().current('cv.completed') ? 'bg-[#e1e1f5] border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white/50 border-black/10'">My CV</Link>
                <a class="text-black hover:bg-[#ffd1dc] transition-all px-3 py-1 border-2 border-transparent hover:border-black active:shadow-none bg-white/50 border-black/10" href="/#how-it-works">Help</a>
            </div>
            <div class="flex items-center"></div>
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
                <div class="font-bold text-[12px] text-on-surface">© 2026 CV Builder. ALL RIGHTS RESERVED.</div>
            </div>
        </footer>
    </div>
</template>
