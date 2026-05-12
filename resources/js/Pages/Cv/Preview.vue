<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import CvPreview from '@/Components/CvPreview.vue';
import { computed, onMounted } from 'vue';

const props = defineProps({ cv: Object });

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
});

const goBack = () => {
    window.history.back();
};

const isId = computed(() => props.cv.bahasa === 'id');
const labels = computed(() => isId.value ? {
    actions: 'CV Actions',
    drafts: 'Drafts',
    preview: 'Preview',
    download: 'Download PDF',
} : {
    actions: 'CV Actions',
    drafts: 'Drafts',
    preview: 'Preview',
    download: 'Download PDF',
});
</script>

<template>
    <Head :title="`Preview — ${cv.nama_file}`" />
    <AppLayout :hideNav="true">
        <div class="bg-[#e2e2e2] text-[#1b1b1b] min-h-screen flex flex-col font-body-md">
            <!-- Brutalist Title Bar -->
            <header class="sticky top-0 z-[100] bg-[#add8e6] border-b-4 border-black px-6 py-3 flex justify-between items-center shadow-[0_8px_0px_0px_rgba(0,0,0,1)]">
                <div class="flex items-center gap-6">
                    <h1 class="text-2xl md:text-3xl font-black italic uppercase tracking-tighter text-black leading-none">CV Preview</h1>
                    <span class="bg-white border-4 border-black px-3 py-1 font-bold text-xs rotate-[-2deg] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hidden md:inline-block">
                        {{ cv.bahasa === 'id' ? 'ID/EN' : 'EN/ID' }}
                    </span>
                </div>
                <div class="flex gap-3">
                    <button @click="goBack" class="bg-white text-black border-4 border-black px-6 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        BACK
                    </button>
                </div>
            </header>

            <!-- Breadcrumb Area -->
            <div class="w-full px-6 py-4 max-w-7xl mx-auto flex items-center gap-2 text-[12px] font-black uppercase tracking-widest text-black/40 mt-4 reveal slide-up">
                <Link :href="route('cv.index')" class="hover:text-black transition-colors">{{ labels.drafts }}</Link>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-black">{{ labels.preview }}</span>
            </div>

            <!-- Main Content Area -->
            <main class="flex-grow w-full px-md max-w-full mx-auto flex flex-col lg:flex-row items-start overflow-x-auto pb-[100px] gap-[100px] justify-center">
                <!-- CV Preview Canvas Container -->
                <div class="flex-shrink-0 flex justify-center w-full lg:w-fit reveal slide-up delay-100">
                    <!-- The "Window" Frame -->
                    <div class="bg-[#f9f9f9] border-[3px] border-black w-fit shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col mb-12">
                        <!-- Window Controls Bar -->
                        <div class="bg-[#eeeeee] border-b-[3px] border-black px-sm py-xs flex items-center gap-xs">
                            <div class="w-[12px] h-[12px] rounded-full bg-[#ff5f56] border-[2px] border-black"></div>
                            <div class="w-[12px] h-[12px] rounded-full bg-[#ffbd2e] border-[2px] border-black"></div>
                            <div class="w-[12px] h-[12px] rounded-full bg-[#27c93f] border-[2px] border-black"></div>
                        </div>
                        <!-- The A4 Paper Content (1:1 Size) -->
                        <div class="bg-white shadow-inner w-[210mm] min-h-[297mm]">
                             <CvPreview :form="cv.content" :bahasa="cv.bahasa" />
                        </div>
                    </div>
                </div>

                <!-- Side Actions Panel -->
                <aside class="w-full lg:w-[300px] flex-shrink-0 flex flex-col gap-md lg:mt-0 mt-8 reveal slide-left delay-200">
                    <!-- Main Action Box -->
                    <div class="bg-[#eeeeee] border-[3px] border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <h3 class="font-bold text-[14px] text-black mb-6 uppercase tracking-widest">{{ labels.actions }}</h3>
                        <div class="flex flex-col gap-4">
                            <a :href="route('cv.download', cv.id)"
                                class="w-full bg-[#ffff00] text-black border-[3px] border-black rounded-full px-6 py-2 font-bold text-[16px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex justify-center items-center gap-xs text-center">
                                <span class="material-symbols-outlined">download</span>
                                {{ labels.download }}
                            </a>
                        </div>
                    </div>
                </aside>
            </main>
        </div>
    </AppLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 12px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #eeeeee;
    border-left: 2px solid black;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #ffff00;
    border: 2px solid black;
}

/* Scroll Reveal Animations */
.reveal {
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.17, 0.55, 0.55, 1);
}

.reveal.slide-up {
    transform: translateY(30px);
}

.reveal.slide-left {
    transform: translateX(30px);
}

.reveal.active {
    opacity: 1;
    transform: translate(0, 0);
}

.delay-100 { transition-delay: 100ms; }
.delay-200 { transition-delay: 200ms; }
</style>
