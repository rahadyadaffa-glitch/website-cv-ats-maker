<script setup>
import { computed } from 'vue';

const props = defineProps({
    form: Object,
    bahasa: String
});

const isId = computed(() => props.bahasa === 'id');
const pi = computed(() => props.form.personal_info ?? {});

const labels = computed(() => isId.value ? {
    summary: 'RINGKASAN PROFESIONAL',
    education: 'PENDIDIKAN',
    work: 'PENGALAMAN KERJA',
    skills: 'KEAHLIAN',
    certs: 'SERTIFIKASI',
    languages: 'BAHASA',
    organizations: 'ORGANISASI',
    portfolio: 'PORTOFOLIO',
    present: 'Sekarang',
    location: 'Lokasi: ',
    phone: 'Nomor telepon: ',
    email: 'Email: ',
    linkedin: 'LinkedIn: ',
    github: 'GitHub: ',
    website: 'Website: ',
} : {
    summary: 'PROFESSIONAL SUMMARY',
    education: 'EDUCATION',
    work: 'EXPERIENCE',
    skills: 'SKILLS',
    certs: 'CERTIFICATIONS',
    languages: 'LANGUAGES',
    organizations: 'ORGANIZATIONS',
    portfolio: 'PORTFOLIO',
    present: 'Present',
    location: 'Location: ',
    phone: 'Phone: ',
    email: 'Email: ',
    linkedin: 'LinkedIn: ',
    github: 'GitHub: ',
    website: 'Website: ',
});

const normalizedSkills = computed(() => {
    const s = props.form.skills;
    if (!s) return [];
    if (typeof s === 'string') return [{ name: 'Skills', description: s }];
    if (Array.isArray(s)) {
        return s
            .filter(item => item !== null && item !== undefined)
            .map(item => typeof item === 'string' ? { name: '', description: item } : item)
            .filter(item => item && typeof item === 'object');
    }
    return [];
});
</script>

<template>
    <div class="cv-preview-container bg-white text-left relative min-h-[297mm] w-full" 
         style="font-family: Helvetica, Arial, sans-serif; font-size: 10pt; padding: 0.25in 0.4in; color: #000; line-height: 1.3;">
        
        <!-- Page Break Indicators (Browser Only) -->
        <div class="page-break-indicators no-print absolute inset-0 pointer-events-none overflow-hidden" style="z-index: 999;">
            <div v-for="i in 4" :key="i" class="absolute w-full flex flex-col items-center" :style="{ top: `calc(0.25in + ${i} * 284.3mm)` }">
                <!-- Physical Gap Illusion -->
                <div class="w-[calc(100%+100px)] h-[20px] bg-[#333333] border-y-[2px] border-black shadow-[inset_0_4px_8px_rgba(0,0,0,0.5)] flex items-center justify-center -translate-y-1/2">
                    <span class="text-white/40 text-[9px] font-bold tracking-[0.5em]">BATAS HALAMAN {{ i }} / {{ i + 1 }}</span>
                </div>
            </div>
        </div>

        <!-- CV Header -->
        <div class="text-center mb-[15pt] relative z-10">
            <h2 style="font-size: 22pt; font-weight: bold; color: #000; letter-spacing: -0.02em; margin-bottom: 2pt;">
                {{ pi.full_name || '(Nama Lengkap)' }}
            </h2>
            <p v-if="pi.profession" style="font-size: 10.5pt; font-weight: bold; color: #000; letter-spacing: 0.02em; margin-bottom: 4pt;">
                {{ pi.profession }}
            </p>
            <div style="font-size: 8.5pt; color: #000; font-weight: bold; margin-top: 5pt;" class="flex flex-wrap justify-center items-center">
                <span v-if="pi.location">{{ labels.location }}{{ pi.location }}</span>
                <span v-if="pi.location && (pi.email || pi.phone || pi.linkedin || pi.github || pi.website)" style="color: #ccc; margin: 0 6pt;">|</span>
                <span v-if="pi.email">{{ labels.email }}<a :href="`mailto:${pi.email}`" class="hover:underline">{{ pi.email }}</a></span>
                <span v-if="pi.email && (pi.phone || pi.linkedin || pi.github || pi.website)" style="color: #ccc; margin: 0 6pt;">|</span>
                <span v-if="pi.phone">{{ labels.phone }}{{ pi.phone }}</span>
                <span v-if="pi.phone && (pi.linkedin || pi.github || pi.website)" style="color: #ccc; margin: 0 6pt;">|</span>
                <span v-if="pi.linkedin">{{ labels.linkedin }}<a :href="pi.linkedin.startsWith('http') ? pi.linkedin : `https://${pi.linkedin}`" target="_blank" class="hover:underline">{{ pi.linkedin }}</a></span>
                <span v-if="pi.linkedin && (pi.github || pi.website)" style="color: #ccc; margin: 0 6pt;">|</span>
                <span v-if="pi.github">{{ labels.github }}<a :href="pi.github.startsWith('http') ? pi.github : `https://${pi.github}`" target="_blank" class="hover:underline">{{ pi.github }}</a></span>
                <span v-if="pi.github && pi.website" style="color: #ccc; margin: 0 6pt;">|</span>
                <span v-if="pi.website">{{ labels.website }}<a :href="pi.website.startsWith('http') ? pi.website : `https://${pi.website}`" target="_blank" class="hover:underline">{{ pi.website }}</a></span>
            </div>
        </div>

        <!-- Professional Summary -->
        <div v-if="form.summary" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ labels.summary }}
            </h3>
            <div class="rich-text-content" style="text-align: justify; font-size: 9.5pt; line-height: 1.35;" v-html="form.summary"></div>
        </div>

        <!-- Experience -->
        <div v-if="form.work_experience?.length" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ labels.work }}
            </h3>
            <div v-for="(work, index) in form.work_experience" :key="index" class="mb-[6pt] last:mb-0">
                <div class="flex justify-between items-baseline mb-[1pt]">
                    <h4 style="font-size: 10pt; font-weight: bold; color: #000;">{{ work.position || '(Posisi)' }}</h4>
                    <span style="font-size: 9pt; font-weight: bold; color: #000;">
                        {{ work.start_date }}{{ work.is_current ? ` – ${labels.present}` : (work.end_date ? ` – ${work.end_date}` : '') }}
                    </span>
                </div>
                <p style="font-weight: bold; color: #000; font-size: 9.5pt;">{{ work.company || '(Perusahaan)' }}</p>
                <div v-if="work.description" class="rich-text-content" style="margin-top: 3pt; font-size: 9.5pt; line-height: 1.35;" v-html="work.description"></div>
            </div>
        </div>

        <!-- Organizations -->
        <div v-if="form.organizations?.length" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ labels.organizations }}
            </h3>
            <div v-for="(org, index) in form.organizations" :key="index" class="mb-[6pt] last:mb-0">
                <div class="flex justify-between items-baseline mb-[1pt]">
                    <h4 style="font-size: 10pt; font-weight: bold; color: #000;">{{ org.organization || '(Organisasi)' }}</h4>
                    <span style="font-size: 9pt; font-weight: bold; color: #000;">
                        {{ org.start_date }}{{ org.is_current ? ` – ${labels.present}` : (org.end_date ? ` – ${org.end_date}` : '') }}
                    </span>
                </div>
                <p style="font-weight: bold; color: #000; font-size: 9.5pt;">{{ org.role || '(Peran)' }}</p>
                <div v-if="org.description" class="rich-text-content" style="margin-top: 3pt; font-size: 9.5pt; line-height: 1.35;" v-html="org.description"></div>
            </div>
        </div>

        <!-- Education -->
        <div v-if="form.education?.length" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ labels.education }}
            </h3>
            <div v-for="(edu, index) in form.education" :key="index" class="mb-[6pt] last:mb-0">
                <div class="flex justify-between items-baseline mb-[1pt]">
                    <h4 style="font-size: 10pt; font-weight: bold; color: #000;">{{ edu.degree }}{{ edu.field ? `, ${edu.field}` : '' }}</h4>
                    <span style="font-size: 9pt; font-weight: bold; color: #000;">{{ edu.start_year }}{{ edu.end_year ? ` – ${edu.end_year}` : '' }}</span>
                </div>
                <p style="font-weight: bold; color: #000; font-size: 9.5pt;">
                    {{ edu.institution || '(Institusi)' }}
                    <span v-if="edu.gpa" style="margin-left: 4pt;">· IPK: {{ edu.gpa }}</span>
                </p>
                <div v-if="edu.relevant_courses" style="margin-top: 4pt;">
                    <div style="font-weight: bold; font-style: normal; font-size: 8pt; text-transform: uppercase; color: #000; margin-bottom: 2pt;">
                        {{ isId ? 'Mata Kuliah Relevan:' : 'Relevant Coursework:' }}
                    </div>
                    <div class="rich-text-content" style="font-size: 9pt; color: #000; line-height: 1.3;" v-html="edu.relevant_courses"></div>
                </div>
            </div>
        </div>

        <!-- Certifications -->
        <div v-if="form.certifications?.length" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ labels.certs }}
            </h3>
            <div v-for="(cert, index) in form.certifications" :key="index" class="mb-[6pt] last:mb-0">
                <div class="flex justify-between items-baseline mb-[1pt]">
                    <h4 style="font-size: 10pt; font-weight: bold; color: #000;">{{ cert.name || '(Sertifikat)' }}</h4>
                    <span style="font-size: 9pt; font-weight: bold; color: #000;">{{ cert.year }}</span>
                </div>
                <p v-if="cert.issuer" style="font-weight: bold; color: #000; font-size: 9.5pt;">{{ cert.issuer }}</p>
                <div v-if="cert.description" class="rich-text-content" style="margin-top: 3pt; font-size: 9.5pt; line-height: 1.35;" v-html="cert.description"></div>
            </div>
        </div>

        <!-- Portfolio -->
        <div v-if="form.portfolio?.length" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ form.portfolio_title || labels.portfolio }}
            </h3>
            <div v-for="(item, index) in form.portfolio" :key="index" class="mb-[6pt] last:mb-0">
                <div class="flex justify-between items-baseline mb-[1pt]">
                    <h4 style="font-size: 10pt; font-weight: bold; color: #000;">{{ item.title || '(Project Title)' }}</h4>
                    <span v-if="item.link" style="font-size: 8.5pt; font-style: italic; color: #000; font-weight: bold;"><a :href="item.link.startsWith('http') ? item.link : `https://${item.link}`" target="_blank" class="hover:underline">{{ item.link }}</a></span>
                </div>
                <div v-if="item.description" class="rich-text-content" style="margin-top: 3pt; font-size: 9.5pt; line-height: 1.35;" v-html="item.description"></div>
            </div>
        </div>

        <!-- Skills -->
        <div v-if="normalizedSkills.length" class="mb-[8pt] relative z-10">
            <hr style="border: none; border-top: 2.5pt solid #000; margin: 8pt 0 5pt 0;">
            <h3 style="font-size: 10pt; font-weight: bold; color: #000; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5pt;">
                {{ labels.skills }}
            </h3>
            <div v-for="(group, index) in normalizedSkills" :key="index" class="mb-[6pt] last:mb-0">
                <h4 v-if="group.name" style="font-weight: bold; font-size: 9.5pt; margin-top: 5pt; margin-bottom: 2pt; text-transform: uppercase;">{{ group.name }}</h4>
                <div v-if="group.description" class="rich-text-content" style="margin-top: 2pt; font-size: 9.5pt; line-height: 1.35;" v-html="group.description"></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.cv-preview-container {
    box-sizing: border-box;
}

/* Hindari elemen terpotong di tengah baris jika memungkinkan */
.entry, .section, h3, h4, li {
    break-inside: avoid;
    page-break-inside: avoid;
}

@media screen {
    .cv-preview-container {
        /* Add a subtle gradient to indicate page ends and create a sheet effect */
        background-image: linear-gradient(
            to bottom,
            white 0,
            white calc(297mm - 1px),
            #f1f5f9 297mm,
            white calc(297mm + 1px)
        );
        background-size: 100% 297mm;
    }
}

/* Rich Text Styles */
.rich-text-content :deep(p) {
    margin: 0;
    padding: 0;
}
.rich-text-content :deep(ul) {
    list-style-type: disc;
    padding-left: 15pt;
    margin-top: 1pt;
    margin-bottom: 1pt;
}
.rich-text-content :deep(ol) {
    list-style-type: decimal;
    padding-left: 15pt;
    margin-top: 1pt;
    margin-bottom: 1pt;
}
</style>

