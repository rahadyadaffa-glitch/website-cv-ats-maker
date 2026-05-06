<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <Head title="Retro CV Builder — Build Your Career with Edge" />
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative bg-[#ffd1dc] p-12 md:p-24 flex flex-col items-center justify-center border-b-4 border-black overflow-hidden min-h-[600px] text-center">
            <!-- Decorative Background Elements -->
            <div class="absolute top-10 left-10 w-32 h-32 rounded-full border-4 border-black border-dashed opacity-20 animate-spin-slow"></div>
            <div class="absolute bottom-20 right-10 w-48 h-48 bg-[#eaea00] rounded-full border-4 border-black blur-sm opacity-50"></div>
            
            <!-- Stickers / Badges -->
            <div class="absolute bottom-32 left-1/4 transform -rotate-6 bg-[#ADD8E6] border-4 border-black p-4 rounded-full font-bold shadow-hard z-10 text-center">
                <div class="text-[10px] uppercase tracking-widest">ATS</div>
                <div class="text-xl font-extrabold uppercase">FRIENDLY</div>
            </div>

            <!-- Hero Content -->
            <div class="w-full z-20 flex flex-col gap-8 max-w-2xl">
                <h1 class="text-5xl md:text-7xl font-extrabold flex flex-col gap-2">
                    <span class="text-[#FFFF00] italic drop-shadow-[4px_4px_0px_rgba(0,0,0,1)] font-serif" style="-webkit-text-stroke: 1px black;">Bring Back</span>
                    <span class="text-[#ADD8E6] tracking-tighter uppercase leading-none" style="-webkit-text-stroke: 2px black;">YOUR CAREER</span>
                </h1>
                
                <p class="text-lg md:text-xl font-medium bg-white p-6 border-4 border-black shadow-hard max-w-lg mx-auto">
                    Build a resume that stands out in the digital age. Stop using boring templates and start expressing your professional identity with a neo-brutalist edge.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-4">
                    <Link :href="route('cv.create')" class="btn-primary text-xl px-12 py-4 flex items-center gap-3">
                        Buat CV Sekarang
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="p-12 md:p-24 bg-[#f9f9f9] flex flex-col items-center gap-16">
            <h2 class="text-3xl md:text-5xl font-black text-center border-b-8 border-black inline-block pb-2 uppercase italic tracking-tight">
                How it works
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl">
                <!-- Step 1 -->
                <div class="flex flex-col items-center gap-6 text-center p-8 bg-[#e1e1f5] border-4 border-black shadow-hard hover:-translate-y-2 transition-transform">
                    <div class="w-20 h-20 bg-[#FFFF00] border-4 border-black rounded-full flex items-center justify-center shadow-hard mb-2">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                    </div>
                    <h3 class="font-black text-2xl uppercase">1. Fill Info</h3>
                    <p class="font-medium text-gray-700">Drop in your details. We keep the form simple so you can focus on your achievements.</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center gap-6 text-center p-8 bg-[#e4e400] border-4 border-black shadow-hard hover:-translate-y-2 transition-transform md:mt-12">
                    <div class="w-20 h-20 bg-[#ADD8E6] border-4 border-black rounded-full flex items-center justify-center shadow-hard mb-2">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </div>
                    <h3 class="font-black text-2xl uppercase">2. Preview</h3>
                    <p class="font-medium text-gray-700">See your resume come to life instantly with our real-time brutalist renderer.</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center gap-6 text-center p-8 bg-[#ffd1dc] border-4 border-black shadow-hard hover:-translate-y-2 transition-transform">
                    <div class="w-20 h-20 bg-[#ff5f56] border-4 border-black rounded-full flex items-center justify-center shadow-hard mb-2">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </div>
                    <h3 class="font-black text-2xl uppercase">3. Download</h3>
                    <p class="font-medium text-gray-700">Export as a crisp, ATS-friendly PDF ready to smash through corporate firewalls.</p>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style>
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin-slow {
    animation: spin-slow 20s linear infinite;
}
</style>
