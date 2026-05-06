<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';

const props = defineProps({ cv: Object });

const goBack = () => {
    window.history.back();
};

const isId = computed(() => props.cv.bahasa === 'id');
const c = computed(() => props.cv.content ?? {});
const pi = computed(() => c.value.personal_info ?? {});

const labels = computed(() => isId.value ? {
    summary: 'PROFESSIONAL SUMMARY',
    education: 'EDUCATION',
    work: 'EXPERIENCE',
    skills: 'SKILLS',
    certs: 'CERTIFICATIONS',
    languages: 'LANGUAGES',
    present: 'Present',
    back: 'Kembali',
    download: 'Download PDF',
    actions: 'Aksi CV',
    drafts: 'Drafts',
    preview: 'Preview'
} : {
    summary: 'PROFESSIONAL SUMMARY',
    education: 'EDUCATION',
    work: 'EXPERIENCE',
    skills: 'SKILLS',
    certs: 'CERTIFICATIONS',
    languages: 'LANGUAGES',
    present: 'Present',
    back: 'Back',
    download: 'Download PDF',
    actions: 'CV Actions',
    drafts: 'Drafts',
    preview: 'Preview'
});
</script>

<template>
    <Head :title="`Preview — ${cv.nama_file}`" />
    <AppLayout>
        <div class="bg-[#fcd7e1] text-[#1b1b1b] min-h-screen flex flex-col pb-xl font-body-md pt-8">
            <!-- Header Section -->
            <header class="w-full px-md py-lg max-w-7xl mx-auto flex flex-row justify-between items-center mt-4">
                <div>
                    <div class="flex items-center gap-xs text-on-surface-variant font-bold text-[14px] mb-xs">
                        <Link :href="route('cv.index')" class="hover:text-primary transition-colors">{{ labels.drafts }}</Link>
                        <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                        <span class="text-on-surface">{{ labels.preview }}</span>
                    </div>
                    <h1 class="font-headline-xl text-[48px] text-on-surface uppercase leading-tight font-black">Preview CV</h1>
                </div>
                <div>
                    <button @click="goBack" 
                        class="bg-[#add8e6] text-black border-[3px] border-black rounded-full px-8 py-2 font-bold text-[16px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-xs">
                        <span class="material-symbols-outlined">arrow_back</span>
                        {{ labels.back }}
                    </button>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-grow w-full px-md max-w-full mx-auto flex flex-col lg:flex-row items-start overflow-x-auto pb-[100px] gap-[100px] justify-center">
                <!-- CV Preview Canvas Container -->
                <div class="flex-shrink-0 flex justify-center w-full lg:w-fit">
                    <!-- The "Window" Frame -->
                    <div class="bg-[#f9f9f9] border-[3px] border-black w-fit shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col mb-12">
                        <!-- Window Controls Bar -->
                        <div class="bg-[#eeeeee] border-b-[3px] border-black px-sm py-xs flex items-center gap-xs">
                            <div class="w-[12px] h-[12px] rounded-full bg-[#ff5f56] border-[2px] border-black"></div>
                            <div class="w-[12px] h-[12px] rounded-full bg-[#ffbd2e] border-[2px] border-black"></div>
                            <div class="w-[12px] h-[12px] rounded-full bg-[#27c93f] border-[2px] border-black"></div>
                        </div>
                        <!-- The A4 Paper Content (1:1 Size) -->
                        <div class="bg-white p-[20mm] w-[210mm] min-h-[297mm] shadow-inner custom-scrollbar overflow-y-auto">
                            <!-- CV Header -->
                            <div class="text-center mb-8">
                                <h2 class="font-headline-lg text-black text-[40px] mb-2 uppercase leading-tight font-black">
                                    {{ pi.full_name || 'JANE DOE' }}
                                </h2>
                                <p class="font-bold text-[18px] text-gray-700 uppercase tracking-widest mb-2">
                                    {{ pi.profession || c.work_experience?.[0]?.position || 'Senior Marketing Strategist' }}
                                </p>
                                <p class="text-[14px] text-gray-600">
                                    {{ pi.location || 'jakarta, indonesia' }} | {{ pi.email || 'jane.doe@email.com' }} | {{ pi.phone || '+62 812 3456 7890' }}
                                </p>
                            </div>

                            <!-- Professional Summary -->
                            <div class="mb-8 relative pt-4">
                                <div class="border-t-[3px] border-black mb-4"></div>
                                <h3 class="font-bold text-[16px] text-black mb-4 uppercase tracking-widest">
                                    {{ labels.summary }}
                                </h3>
                                <p class="text-[14px] text-gray-800 text-justify leading-relaxed">
                                    {{ c.summary || 'Results-driven Senior Marketing Strategist with over 10 years of experience in developing and executing high-impact marketing campaigns. Proven track record of increasing brand awareness, driving customer acquisition, and maximizing ROI in competitive markets. Adept at leveraging data analytics to optimize strategies and lead cross-functional teams to achieve business objectives.' }}
                                </p>
                            </div>

                            <!-- Experience -->
                            <div class="mb-8 pt-4">
                                <div class="border-t-[3px] border-black mb-4"></div>
                                <h3 class="font-bold text-[16px] text-black mb-6 uppercase tracking-widest">
                                    {{ labels.work }}
                                </h3>
                                <div v-if="c.work_experience?.length">
                                    <div v-for="(work, index) in c.work_experience" :key="index" class="mb-8 last:mb-0">
                                        <div class="flex justify-between items-baseline mb-1">
                                            <h4 class="font-black text-[16px] text-black">{{ work.position }}</h4>
                                            <span class="text-[14px] text-gray-600">
                                                {{ work.start_date }}{{ work.is_current ? ` - ${labels.present}` : (work.end_date ? ` - ${work.end_date}` : '') }}
                                            </span>
                                        </div>
                                        <p class="font-bold text-[14px] text-gray-700 mb-2">{{ work.company }}</p>
                                        <ul class="list-disc list-inside text-[14px] text-gray-800 space-y-1">
                                            <li v-for="(point, i) in (work.description?.split('\n') || [])" :key="i" v-show="point.trim()">
                                                {{ point.trim() }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div v-else class="space-y-8">
                                    <div>
                                        <div class="flex justify-between items-baseline mb-1">
                                            <h4 class="font-black text-[16px] text-black">Marketing Director</h4>
                                            <span class="text-[14px] text-gray-600">2020 - Present</span>
                                        </div>
                                        <p class="font-bold text-[14px] text-gray-700 mb-2">TechNova Solutions, Jakarta</p>
                                        <ul class="list-disc list-inside text-[14px] text-gray-800 space-y-1">
                                            <li>Spearheaded a comprehensive rebranding initiative, resulting in a 45% increase in market share.</li>
                                            <li>Managed a marketing budget of $2M, consistently achieving a 150% ROI across digital channels.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="mb-8 pt-4">
                                <div class="border-t-[3px] border-black mb-4"></div>
                                <h3 class="font-bold text-[16px] text-black mb-6 uppercase tracking-widest">
                                    {{ labels.education }}
                                </h3>
                                <div v-if="c.education?.length">
                                    <div v-for="(edu, index) in c.education" :key="index" class="mb-4 last:mb-0">
                                        <div class="flex justify-between items-baseline mb-1">
                                            <h4 class="font-black text-[16px] text-black">{{ edu.degree }}{{ edu.field ? `, ${edu.field}` : '' }}</h4>
                                            <span class="text-[14px] text-gray-600">{{ edu.start_year }}{{ edu.end_year ? ` - ${edu.end_year}` : '' }}</span>
                                        </div>
                                        <p class="font-bold text-[14px] text-gray-700">{{ edu.institution }}</p>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="flex justify-between items-baseline mb-1">
                                        <h4 class="font-black text-[16px] text-black">Master of Business Administration (MBA)</h4>
                                        <span class="text-[14px] text-gray-600">2015</span>
                                    </div>
                                    <p class="font-bold text-[14px] text-gray-700">University of Indonesia, Jakarta</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Side Actions Panel -->
                <aside class="w-full lg:w-[300px] flex-shrink-0 flex flex-col gap-md lg:mt-0 mt-8">
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
</style>
