<script setup>
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import CvPreview from '@/Components/CvPreview.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';
import { computed, ref, onMounted } from 'vue';

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

const isId = computed(() => props.cv.bahasa === 'id');
const labels = computed(() => isId.value ? {
    drafts: 'Drafts',
    edit: 'Edit'
} : {
    drafts: 'Drafts',
    edit: 'Edit'
});
const content = props.cv.content ?? {};

const initialSkills = (() => {
    const s = content.skills;
    if (!s) return [];
    if (typeof s === 'string') return [{ name: 'Skills', description: s }];
    if (Array.isArray(s)) {
        return s
            .filter(item => item !== null && item !== undefined)
            .map(item => typeof item === 'string' ? { name: '', description: item } : item)
            .filter(item => item && typeof item === 'object');
    }
    return [];
})();

const form = useForm({
    personal_info: {
        full_name:  content.personal_info?.full_name ?? '',
        profession: content.personal_info?.profession ?? '',
        email:      content.personal_info?.email ?? '',
        phone:      content.personal_info?.phone ?? '',
        location:   content.personal_info?.location ?? '',
        linkedin:   content.personal_info?.linkedin ?? '',
        github:     content.personal_info?.github ?? '',
        website:    content.personal_info?.website ?? '',
    },
    summary:         content.summary ?? '',
    education:       content.education ?? [],
    work_experience: content.work_experience ?? [],
    skills:          initialSkills,
    certifications:  content.certifications ?? [],
    languages:       content.languages ?? [],
    organizations:   content.organizations ?? [],
    portfolio:       content.portfolio ?? [],
    portfolio_title: content.portfolio_title ?? '',
});

const showFullPreview = ref(false);
const showSaveModal = ref(false);

const save = (status = 'draft') => {
    form.transform((data) => ({
        ...data,
        status: status
    })).put(route('cv.update', props.cv.id), {
        preserveScroll: true,
        onSuccess: () => {
            showSaveModal.value = false;
        }
    });
};

const showDeleteModal = ref(false);
const deleteAction = ref(null);

const confirmAction = (callback) => {
    deleteAction.value = callback;
    showDeleteModal.value = true;
};

const executeDelete = () => {
    if (deleteAction.value) {
        deleteAction.value();
    }
    showDeleteModal.value = false;
    deleteAction.value = null;
};

// Helpers
const addEducation = () => form.education.push({ institution:'', degree:'', field:'', start_year:'', end_year:'', gpa:'', relevant_courses:'', is_coursework_bulleted: true });
const removeEducation = (i) => {
    confirmAction(() => form.education.splice(i, 1));
};

const addWork = () => form.work_experience.push({ company:'', position:'', start_date:'', end_date:'', is_current:false, description:'' });
const removeWork = (i) => {
    confirmAction(() => form.work_experience.splice(i, 1));
};

const addOrg = () => form.organizations.push({ organization:'', role:'', start_date:'', end_date:'', is_current:false, description:'' });
const removeOrg = (i) => {
    confirmAction(() => form.organizations.splice(i, 1));
};


const addCert = () => form.certifications.push({ name:'', issuer:'', year:'', description:'' });
const removeCert = (i) => {
    confirmAction(() => form.certifications.splice(i, 1));
};

const addLang = () => form.languages.push({ language:'', proficiency:'' });
const removeLang = (i) => {
    confirmAction(() => form.languages.splice(i, 1));
};

const addSkill = () => form.skills.push({ name: '', description: '' });
const removeSkill = (i) => {
    confirmAction(() => form.skills.splice(i, 1));
};

const addPortfolio = () => form.portfolio.push({ title: '', link: '', description: '' });
const removePortfolio = (i) => {
    confirmAction(() => form.portfolio.splice(i, 1));
};
</script>

<template>
    <Head :title="`Edit — ${cv.nama_file}`" />
    <AppLayout :hideNav="true">
        <div class="min-h-screen bg-[#e2e2e2] text-[#1b1b1b] font-sans flex flex-col">
            <!-- Brutalist Title Bar -->
            <header class="sticky top-0 z-[100] bg-[#ffd1dc] border-b-4 border-black px-6 py-3 flex justify-between items-center shadow-[0_8px_0px_0px_rgba(0,0,0,1)]">
                <div class="flex items-center gap-6">
                    <h1 class="text-2xl md:text-3xl font-black italic uppercase tracking-tighter text-black leading-none">CV Editor</h1>
                    <span class="bg-white border-4 border-black px-3 py-1 font-bold text-xs rotate-[-2deg] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hidden md:inline-block">
                        {{ cv.bahasa === 'id' ? 'ID/EN' : 'EN/ID' }}
                    </span>
                </div>
                <div class="flex gap-3">
                    <Link :href="route('cv.index')" class="bg-white text-black border-4 border-black px-6 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        BACK
                    </Link>
                    <button @click="showSaveModal = true" class="bg-[#78555e] text-white border-4 border-black px-6 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-2 text-sm" :disabled="form.processing">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        SAVE
                    </button>
                </div>
            </header>

            <!-- Main Workspace -->
            <main class="flex-grow w-full max-w-[1800px] mx-auto grid grid-cols-1 xl:grid-cols-12 gap-8 p-6 lg:p-12">
                
                <!-- Left Column: Form Editor -->
                <div class="xl:col-span-5 flex flex-col gap-12 pb-24">
                    <!-- Error Alert -->
                    <div v-if="Object.keys(form.errors).length" class="bg-red-100 border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] reveal slide-up">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="material-symbols-outlined text-red-600 font-black">error</span>
                            <h4 class="font-black uppercase italic">SAVE FAILED!</h4>
                        </div>
                        <ul class="list-disc list-inside text-xs font-bold text-red-700">
                            <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
                        </ul>
                        <p class="text-[10px] mt-2 italic text-gray-600">Please fix the fields above and try saving again.</p>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-1 text-[12px] font-black uppercase tracking-widest text-black/40 mb-[-24px] reveal slide-up">
                        <Link :href="route('cv.index')" class="hover:text-black transition-colors">{{ labels.drafts }}</Link>
                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        <span class="text-black">{{ labels.edit }}</span>
                    </div>
                    
                    <!-- Section: Personal Info -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-[#e4e400] border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-3deg] z-10">
                            <span class="font-bold text-[12px] uppercase">01. Personal Info</span>
                        </div>
                        <div class="mt-4 flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Full Name</label>
                                <input v-model="form.personal_info.full_name" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all" type="text" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Profession / Job Title</label>
                                <input v-model="form.personal_info.profession" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all" type="text" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Email</label>
                                    <input v-model="form.personal_info.email" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="email" />
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Phone</label>
                                    <input v-model="form.personal_info.phone" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="tel" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Location</label>
                                <input v-model="form.personal_info.location" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="text" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">LinkedIn</label>
                                    <input v-model="form.personal_info.linkedin" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="text" placeholder="linkedin.com/in/username" />
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">GitHub</label>
                                    <input v-model="form.personal_info.github" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="text" placeholder="github.com/username" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Website / Portfolio</label>
                                <input v-model="form.personal_info.website" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="text" placeholder="portfolio.com" />
                            </div>
                        </div>
                    </section>

                    <!-- Section: Summary -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">02. Summary</span>
                        </div>
                        <div class="mt-4">
                            <RichTextEditor v-model="form.summary" />
                        </div>
                    </section>

                    <!-- Section: Work Experience -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[1deg] z-10">
                            <span class="font-bold text-[12px] uppercase">03. Work Experience</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(work, i) in form.work_experience" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeWork(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black w-7 h-7 flex items-center justify-center hover:scale-110 transition-transform font-black">
                                    ×
                                </button>
                                <div class="space-y-4">
                                    <input v-model="work.company" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Company" />
                                    <input v-model="work.position" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Position" />
                                    <div class="grid grid-cols-2 gap-4">
                                        <input v-model="work.start_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Start" />
                                        <input v-model="work.end_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="End" />
                                    </div>
                                    <RichTextEditor v-model="work.description" />
                                </div>
                            </div>
                            <button @click="addWork" class="bg-[#e1e1f5] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> ADD EXPERIENCE
                            </button>
                        </div>
                    </section>

                    <!-- Section: Organizations -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">04. Organizations</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(org, i) in form.organizations" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeOrg(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black w-7 h-7 flex items-center justify-center hover:scale-110 transition-transform font-black">
                                    ×
                                </button>
                                <div class="space-y-4">
                                    <input v-model="org.organization" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Organization" />
                                    <input v-model="org.role" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Role" />
                                    <div class="grid grid-cols-2 gap-4">
                                        <input v-model="org.start_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Start" />
                                        <input v-model="org.end_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="End" />
                                    </div>
                                    <RichTextEditor v-model="org.description" />
                                </div>
                            </div>
                            <button @click="addOrg" class="bg-[#ffd1dc] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> ADD ORGANIZATION
                            </button>
                        </div>
                    </section>

                    <!-- Section: Education -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-1deg] z-10">
                            <span class="font-bold text-[12px] uppercase">05. Education</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(edu, i) in form.education" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeEducation(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black w-7 h-7 flex items-center justify-center hover:scale-110 transition-transform font-black">
                                    ×
                                </button>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2 flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Institution</label>
                                        <input v-model="edu.institution" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Degree</label>
                                        <input v-model="edu.degree" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Field of Study</label>
                                        <input v-model="edu.field" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" placeholder="e.g. Computer Science" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Year</label>
                                        <input v-model="edu.start_year" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">IPK / GPA</label>
                                        <input v-model="edu.gpa" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" placeholder="3.80" />
                                    </div>
                                    <div class="col-span-2 flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Relevant Coursework / Extra Details</label>
                                        <RichTextEditor v-model="edu.relevant_courses" />
                                    </div>
                                </div>
                            </div>
                            <button @click="addEducation" class="bg-[#e4e400] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> ADD EDUCATION
                            </button>
                        </div>
                    </section>

                    <!-- Section: Certifications -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-[#e1e1f5] border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[3deg] z-10">
                            <span class="font-bold text-[12px] uppercase">06. Certifications</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(cert, i) in form.certifications" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeCert(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black w-7 h-7 flex items-center justify-center hover:scale-110 transition-transform font-black">
                                    ×
                                </button>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2 flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Certificate Name</label>
                                        <input v-model="cert.name" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Issuer</label>
                                        <input v-model="cert.issuer" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Year</label>
                                        <input v-model="cert.year" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="col-span-2 flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Description / What you learned</label>
                                        <RichTextEditor v-model="cert.description" />
                                    </div>
                                </div>
                            </div>
                            <button @click="addCert" class="bg-[#add8e6] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> ADD CERTIFICATE
                            </button>
                        </div>
                    </section>

                    <!-- Section: Portfolio -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-[#ffd1dc] border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">07. {{ form.portfolio_title || 'Portfolio' }}</span>
                        </div>
                        <div class="mt-4 flex flex-col gap-4">
                            <div class="flex flex-col gap-1 mb-4">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Section Title (Optional)</label>
                                <input v-model="form.portfolio_title" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="text" placeholder="e.g. Portfolio, Projects, Side Projects..." />
                            </div>
                            
                            <div class="space-y-6">
                            <div v-for="(item, i) in form.portfolio" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removePortfolio(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black w-7 h-7 flex items-center justify-center hover:scale-110 transition-transform font-black">
                                    ×
                                </button>
                                <div class="space-y-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Project Title</label>
                                        <input v-model="item.title" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="e.g. E-Commerce Website" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Project Link (Optional)</label>
                                        <input v-model="item.link" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="e.g. github.com/my-project" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Description</label>
                                        <RichTextEditor v-model="item.description" />
                                    </div>
                                </div>
                            </div>
                            <button @click="addPortfolio" class="bg-[#ffd1dc] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> ADD PORTFOLIO ITEM
                            </button>
                        </div>
                        </div>
                    </section>

                    <!-- Section: Skills -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4 reveal slide-up">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">08. Skills</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(skill, i) in form.skills" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeSkill(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black w-7 h-7 flex items-center justify-center hover:scale-110 transition-transform font-black">
                                    ×
                                </button>
                                <div class="space-y-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Skill Category / Title</label>
                                        <input v-model="skill.name" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="e.g. Programming Languages" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Skills List (Enter for dots)</label>
                                        <RichTextEditor v-model="skill.description" />
                                    </div>
                                </div>
                            </div>
                            <button @click="addSkill" class="bg-[#dadada] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> ADD SKILL GROUP
                            </button>
                        </div>
                    </section>

                </div>

                <!-- Right Column: Live Preview -->
                <div class="xl:col-span-7 sticky top-[100px] h-[calc(100vh-150px)] ml-[3cm] relative z-30 pointer-events-auto reveal slide-left">
                    <!-- Frame Wrapper: Auto-fit to paper -->
                    <div class="w-fit mx-auto flex flex-col h-full min-w-[400px]">
                        <!-- Preview Title Bar -->
                        <div class="border-4 border-black bg-black flex justify-between items-center px-4 py-2 relative z-40">
                            <h2 class="text-xl font-bold text-white flex items-center gap-2 uppercase italic tracking-wider leading-none">
                                <span class="material-symbols-outlined text-[#e4e400]">visibility</span> 
                                Live Preview
                            </h2>
                            <div class="flex items-center gap-2 relative z-50">
                                <button type="button" @click.stop="showFullPreview = true" class="flex items-center gap-1 bg-[#e4e400] text-black px-2 py-0.5 border-2 border-white hover:scale-105 active:scale-95 transition-all shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]">
                                    <span class="material-symbols-outlined text-[18px]">zoom_in</span>
                                    <span class="text-[10px] font-black uppercase">Preview</span>
                                </button>
                                <span class="text-[10px] text-[#e4e400] uppercase font-bold tracking-widest bg-black border-2 border-[#e4e400] px-2 py-0.5 ml-1">
                                    A4 View
                                </span>
                            </div>
                        </div>

                        <!-- A4 Preview Container -->
                        <div class="flex-grow bg-[#333333] border-x-4 border-b-4 border-black flex justify-center items-start overflow-auto p-12 scrollbar-retro" style="box-shadow: inset 0px 8px 32px rgba(0,0,0,0.3);">
                            <!-- The A4 Sheet Wrapper: Handles the multiple pages look -->
                            <div class="preview-sheet-wrapper relative origin-top scale-[0.60] lg:scale-[0.75] xl:scale-[0.85] transition-transform duration-300 mb-24">
                                <div class="w-[210mm] shadow-[20px_20px_0px_0px_rgba(0,0,0,0.5)] border-2 border-black bg-white min-h-[297mm]">
                                    <CvPreview :form="form" :bahasa="cv.bahasa" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

            <!-- Full Preview Modal (Brutalist Style) -->
            <Teleport to="body">
            <div v-show="showFullPreview" class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="showFullPreview = false"></div>
                
                <!-- Modal Content -->
                <div class="relative bg-[#eeeeee] border-8 border-black shadow-[20px_20px_0px_0px_rgba(0,0,0,1)] w-full max-w-5xl h-full flex flex-col overflow-hidden">
                    <!-- Modal Header -->
                    <div class="bg-black text-white p-4 flex justify-between items-center border-b-4 border-black relative z-[110]">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-[#e4e400] text-3xl">pageview</span>
                            <h3 class="text-2xl font-black italic uppercase tracking-tighter">Full Inspection Mode</h3>
                        </div>
                        <button type="button" @click.stop="showFullPreview = false" class="bg-red-600 border-4 border-black px-6 py-2 font-black hover:bg-red-500 active:translate-y-1 transition-all shadow-[4px_4px_0px_0px_rgba(255,255,255,0.3)] pointer-events-auto">
                            CLOSE [X]
                        </button>
                    </div>

                    <!-- Modal Body (Scrollable Preview) -->
                    <div class="flex-grow overflow-auto p-12 flex justify-center bg-[#333333] scrollbar-retro">
                        <div class="preview-sheet-wrapper relative origin-top scale-100 mb-12">
                            <div class="w-[210mm] min-h-[297mm] bg-white shadow-[24px_24px_0px_0px_rgba(0,0,0,0.5)] border-2 border-black">
                                <CvPreview :form="form" :bahasa="cv.bahasa" />
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </Teleport>
            
            <!-- Save Status Modal -->
            <Teleport to="body">
                <div v-if="showSaveModal" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showSaveModal = false"></div>
                    <div class="relative bg-white border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] p-8 max-w-md w-full text-center flex flex-col gap-8">
                        <div class="space-y-4">
                            <span class="material-symbols-outlined text-5xl text-[#e4e400]">save</span>
                            <h3 class="text-2xl font-black uppercase italic tracking-tighter">Choose Save Status</h3>
                            <p class="font-medium text-gray-600">Would you like to keep this as a draft or mark it as complete?</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <button @click="save('draft')" 
                                    :disabled="form.processing"
                                    class="bg-[#e1e1f5] text-black border-4 border-black px-6 py-3 font-black uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined" :class="{'animate-spin': form.processing}">{{ form.processing ? 'sync' : 'drafts' }}</span>
                                {{ form.processing ? 'Saving...' : 'Save as Draft' }}
                            </button>
                            <button @click="save('completed')" 
                                    :disabled="form.processing"
                                    class="bg-[#78555e] text-white border-4 border-black px-6 py-3 font-black uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined" :class="{'animate-spin': form.processing}">{{ form.processing ? 'sync' : 'check_circle' }}</span>
                                {{ form.processing ? 'Saving...' : 'Mark as Complete' }}
                            </button>
                        </div>
                        
                        <button @click="showSaveModal = false" :disabled="form.processing" class="text-xs font-bold uppercase underline hover:text-red-600 transition-colors disabled:opacity-50">Cancel</button>
                    </div>
                </div>
            </Teleport>

            <!-- Delete Confirmation Modal -->
            <Teleport to="body">
                <div v-if="showDeleteModal" class="fixed inset-0 z-[300] flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]" @click="showDeleteModal = false"></div>
                    <div class="relative bg-white border-8 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] p-8 max-w-sm w-full text-center flex flex-col gap-6 rotate-[1deg]">
                        <div class="space-y-2">
                            <span class="material-symbols-outlined text-6xl text-red-600 animate-bounce">warning</span>
                            <h3 class="text-2xl font-black uppercase italic tracking-tighter">Hapus Data?</h3>
                            <p class="font-bold text-gray-600">Apakah anda yakin ingin hapus? Tindakan ini tidak bisa dibatalkan.</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <button @click="showDeleteModal = false" class="bg-white text-black border-4 border-black px-4 py-2 font-black uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                                Batal
                            </button>
                            <button @click="executeDelete" class="bg-red-600 text-white border-4 border-black px-4 py-2 font-black uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </Teleport>
        </div>
    </AppLayout>
</template>

<style scoped>
.scrollbar-retro::-webkit-scrollbar {
    width: 12px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #000;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #ffd1dc;
    border: 3px solid #000;
}
.shadow-hard {
    box-shadow: 4px 4px 0px 0px rgba(0,0,0,1);
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
</style>
