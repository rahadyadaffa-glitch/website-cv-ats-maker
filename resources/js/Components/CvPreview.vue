<script setup>
import { computed } from 'vue';

const props = defineProps({
    form: Object,
    bahasa: String
});

const isId = computed(() => props.bahasa === 'id');
const pi = computed(() => props.form.personal_info ?? {});

const labels = computed(() => isId.value ? {
    summary: 'PROFESSIONAL SUMMARY',
    education: 'EDUCATION',
    work: 'EXPERIENCE',
    skills: 'SKILLS',
    certs: 'CERTIFICATIONS',
    languages: 'LANGUAGES',
    present: 'Present',
} : {
    summary: 'PROFESSIONAL SUMMARY',
    education: 'EDUCATION',
    work: 'EXPERIENCE',
    skills: 'SKILLS',
    certs: 'CERTIFICATIONS',
    languages: 'LANGUAGES',
    present: 'Present',
});
</script>

<template>
    <div class="bg-white p-8 md:p-12 aspect-[1/1.414] w-full text-left overflow-hidden relative font-body-md border-black">
        <!-- CV Header -->
        <div class="text-center mb-8">
            <h2 class="font-headline-lg text-black text-[32px] mb-2 uppercase leading-tight font-black">
                {{ pi.full_name || '(Nama Lengkap)' }}
            </h2>
            <p v-if="pi.profession" class="font-bold text-[14px] text-gray-700 uppercase tracking-widest mb-2">
                {{ pi.profession }}
            </p>
            <p class="text-[12px] text-gray-600">
                <span v-if="pi.location">{{ pi.location }}</span>
                <span v-if="pi.location && (pi.email || pi.phone)"> | </span>
                <span v-if="pi.email">{{ pi.email }}</span>
                <span v-if="pi.email && pi.phone"> | </span>
                <span v-if="pi.phone">{{ pi.phone }}</span>
            </p>
        </div>

        <!-- Professional Summary -->
        <div v-if="form.summary" class="mb-8 relative pt-4">
            <div class="border-t-[3px] border-black mb-4"></div>
            <h3 class="font-bold text-[14px] text-black mb-4 uppercase tracking-widest">
                {{ labels.summary }}
            </h3>
            <p class="text-[12px] text-black text-justify leading-relaxed">
                {{ form.summary }}
            </p>
        </div>

        <!-- Experience -->
        <div v-if="form.work_experience?.length" class="mb-8 pt-4">
            <div class="border-t-[3px] border-black mb-4"></div>
            <h3 class="font-bold text-[14px] text-black mb-4 uppercase tracking-widest">
                {{ labels.work }}
            </h3>
            <div v-for="(work, index) in form.work_experience" :key="index" class="mb-6 last:mb-0">
                <div class="flex justify-between items-baseline mb-1">
                    <h4 class="font-black text-[14px] text-black">{{ work.position || '(Posisi)' }}</h4>
                    <span class="text-[12px] text-gray-600">
                        {{ work.start_date }}{{ work.is_current ? ` - ${labels.present}` : (work.end_date ? ` - ${work.end_date}` : '') }}
                    </span>
                </div>
                <p class="font-bold text-[12px] text-gray-700 mb-2">{{ work.company || '(Perusahaan)' }}</p>
                <ul class="list-disc list-inside text-[12px] text-black space-y-1">
                    <li v-for="(point, i) in (work.description?.split('\n') || [])" :key="i" v-show="point.trim()">
                        {{ point.trim() }}
                    </li>
                </ul>
            </div>
        </div>

        <!-- Education -->
        <div v-if="form.education?.length" class="mb-8 pt-4">
            <div class="border-t-[3px] border-black mb-4"></div>
            <h3 class="font-bold text-[14px] text-black mb-4 uppercase tracking-widest">
                {{ labels.education }}
            </h3>
            <div v-for="(edu, index) in form.education" :key="index" class="mb-4 last:mb-0">
                <div class="flex justify-between items-baseline mb-1">
                    <h4 class="font-black text-[14px] text-black">{{ edu.degree }}{{ edu.field ? `, ${edu.field}` : '' }}</h4>
                    <span class="text-[12px] text-gray-600">{{ edu.start_year }}{{ edu.end_year ? ` - ${edu.end_year}` : '' }}</span>
                </div>
                <p class="font-bold text-[12px] text-gray-700">{{ edu.institution || '(Institusi)' }}</p>
            </div>
        </div>
    </div>
</template>
