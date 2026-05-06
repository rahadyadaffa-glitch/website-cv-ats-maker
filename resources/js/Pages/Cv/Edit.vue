<script setup>
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import CvPreview from '@/Components/CvPreview.vue';
import { computed, ref } from 'vue';

const props = defineProps({ cv: Object });

const isId = computed(() => props.cv.bahasa === 'id');
const content = props.cv.content ?? {};

const form = useForm({
    personal_info: {
        full_name:  content.personal_info?.full_name ?? '',
        profession: content.personal_info?.profession ?? '',
        email:      content.personal_info?.email ?? '',
        phone:      content.personal_info?.phone ?? '',
        location:   content.personal_info?.location ?? '',
        linkedin:   content.personal_info?.linkedin ?? '',
        website:    content.personal_info?.website ?? '',
    },
    summary:         content.summary ?? '',
    education:       content.education ?? [],
    work_experience: content.work_experience ?? [],
    skills:          content.skills ?? [],
    certifications:  content.certifications ?? [],
    languages:       content.languages ?? [],
    organizations:   content.organizations ?? [],
});

const showFullPreview = ref(false);

const save = () => form.put(route('cv.update', props.cv.id), {
    preserveScroll: true
});

// Helpers
const addEducation = () => form.education.push({ institution:'', degree:'', field:'', start_year:'', end_year:'', gpa:'' });
const removeEducation = (i) => {
    if (confirm('Apakah Anda yakin ingin menghapus pendidikan ini?')) {
        form.education.splice(i, 1);
    }
};

const addWork = () => form.work_experience.push({ company:'', position:'', start_date:'', end_date:'', is_current:false, description:'' });
const removeWork = (i) => {
    if (confirm('Apakah Anda yakin ingin menghapus pengalaman kerja ini?')) {
        form.work_experience.splice(i, 1);
    }
};

const addOrg = () => form.organizations.push({ organization:'', role:'', start_date:'', end_date:'', is_current:false, description:'' });
const removeOrg = (i) => {
    if (confirm('Apakah Anda yakin ingin menghapus organisasi ini?')) {
        form.organizations.splice(i, 1);
    }
};

const addSkill = () => form.skills.push('');
const removeSkill = (i) => {
    if (confirm('Apakah Anda yakin ingin menghapus keahlian ini?')) {
        form.skills.splice(i, 1);
    }
};

const addCert = () => form.certifications.push({ name:'', issuer:'', year:'' });
const removeCert = (i) => {
    if (confirm('Apakah Anda yakin ingin menghapus sertifikasi ini?')) {
        form.certifications.splice(i, 1);
    }
};

const addLang = () => form.languages.push({ language:'', proficiency:'' });
const removeLang = (i) => {
    if (confirm('Apakah Anda yakin ingin menghapus bahasa ini?')) {
        form.languages.splice(i, 1);
    }
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
                        KEMBALI
                    </Link>
                    <button @click="save" class="bg-[#78555e] text-white border-4 border-black px-6 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-2 text-sm" :disabled="form.processing">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        {{ form.processing ? '...' : 'SIMPAN' }}
                    </button>
                </div>
            </header>

            <!-- Main Workspace -->
            <main class="flex-grow w-full max-w-[1800px] mx-auto grid grid-cols-1 xl:grid-cols-12 gap-8 p-6 lg:p-12">
                
                <!-- Left Column: Form Editor -->
                <div class="xl:col-span-5 flex flex-col gap-12 pb-24">
                    
                    <!-- Section: Personal Info -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4">
                        <div class="absolute -top-4 -left-4 bg-[#e4e400] border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-3deg] z-10">
                            <span class="font-bold text-[12px] uppercase">01. Data Pribadi</span>
                        </div>
                        <div class="mt-4 flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Nama Lengkap</label>
                                <input v-model="form.personal_info.full_name" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all" type="text" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Profesi / Jabatan</label>
                                <input v-model="form.personal_info.profession" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all" type="text" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Email</label>
                                    <input v-model="form.personal_info.email" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="email" />
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Telepon</label>
                                    <input v-model="form.personal_info.phone" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="tel" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Lokasi</label>
                                <input v-model="form.personal_info.location" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all text-sm" type="text" />
                            </div>
                        </div>
                    </section>

                    <!-- Section: Summary -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">02. Ringkasan</span>
                        </div>
                        <div class="mt-4">
                            <textarea v-model="form.summary" class="w-full border-4 border-black p-2 font-bold focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] outline-none transition-all min-h-[150px] text-sm" rows="5"></textarea>
                        </div>
                    </section>

                    <!-- Section: Education -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-1deg] z-10">
                            <span class="font-bold text-[12px] uppercase">03. Pendidikan</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(edu, i) in form.education" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeEducation(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black p-1 hover:scale-110 transition-transform leading-none">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                </button>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2 flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Institusi</label>
                                        <input v-model="edu.institution" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Gelar</label>
                                        <input v-model="edu.degree" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[10px] font-bold uppercase">Tahun</label>
                                        <input v-model="edu.start_year" class="w-full border-2 border-black p-2 font-bold text-sm" type="text" />
                                    </div>
                                </div>
                            </div>
                            <button @click="addEducation" class="bg-[#e4e400] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> TAMBAH PENDIDIKAN
                            </button>
                        </div>
                    </section>

                    <!-- Section: Work Experience -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[1deg] z-10">
                            <span class="font-bold text-[12px] uppercase">04. Pengalaman Kerja</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(work, i) in form.work_experience" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeWork(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black p-1 hover:scale-110 transition-transform leading-none">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                </button>
                                <div class="space-y-4">
                                    <input v-model="work.company" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Perusahaan" />
                                    <input v-model="work.position" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Posisi" />
                                    <div class="grid grid-cols-2 gap-4">
                                        <input v-model="work.start_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Mulai" />
                                        <input v-model="work.end_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Selesai" />
                                    </div>
                                    <textarea v-model="work.description" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Deskripsi..."></textarea>
                                </div>
                            </div>
                            <button @click="addWork" class="bg-[#e1e1f5] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> TAMBAH PENGALAMAN
                            </button>
                        </div>
                    </section>

                    <!-- Section: Organizations -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[-2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">05. Organisasi</span>
                        </div>
                        <div class="mt-4 space-y-6">
                            <div v-for="(org, i) in form.organizations" :key="i" class="bg-[#f3f3f3] border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                                <button @click="removeOrg(i)" class="absolute top-2 right-2 bg-red-600 text-white border-2 border-black p-1 hover:scale-110 transition-transform leading-none">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                </button>
                                <div class="space-y-4">
                                    <input v-model="org.organization" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Organisasi" />
                                    <input v-model="org.role" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Peran" />
                                    <div class="grid grid-cols-2 gap-4">
                                        <input v-model="org.start_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Mulai" />
                                        <input v-model="org.end_date" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Selesai" />
                                    </div>
                                    <textarea v-model="org.description" class="w-full border-2 border-black p-2 font-bold text-sm" placeholder="Deskripsi..."></textarea>
                                </div>
                            </div>
                            <button @click="addOrg" class="bg-[#ffd1dc] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> TAMBAH ORGANISASI
                            </button>
                        </div>
                    </section>

                    <!-- Section: Skills -->
                    <section class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative flex flex-col gap-4">
                        <div class="absolute -top-4 -left-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] px-3 py-1 rotate-[2deg] z-10">
                            <span class="font-bold text-[12px] uppercase">06. Keahlian</span>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div v-for="(skill, i) in form.skills" :key="i" class="flex gap-2">
                                    <input v-model="form.skills[i]" class="w-full border-4 border-black p-2 font-bold text-sm outline-none focus:bg-yellow-50" placeholder="Keahlian..." />
                                    <button @click="removeSkill(i)" class="bg-red-600 text-white border-2 border-black px-2 font-black">×</button>
                                </div>
                            </div>
                            <button @click="addSkill" class="bg-[#dadada] text-black border-4 border-black px-4 py-2 font-bold uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all flex items-center gap-2 text-sm self-start">
                                <span class="material-symbols-outlined text-[20px]">add</span> TAMBAH KEAHLIAN
                            </button>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Live Preview -->
                <div class="xl:col-span-7 sticky top-[100px] h-[calc(100vh-150px)] ml-[3cm] relative z-30 pointer-events-auto">
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
                        <div class="flex-grow bg-[#eeeeee] border-x-4 border-b-4 border-black flex justify-center items-center overflow-hidden" style="box-shadow: inset 0px 8px 16px rgba(0,0,0,0.1);">
                            <!-- The A4 Sheet: Micro-adjusted zoom -->
                            <div class="w-[816px] aspect-[1/1.414] shadow-[16px_16px_0px_0px_rgba(0,0,0,0.2)] border-2 border-black origin-center scale-[0.43] lg:scale-[0.53] xl:scale-[0.58] transition-transform duration-300 bg-white">
                                <CvPreview :form="form" :bahasa="cv.bahasa" />
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
                    <div class="flex-grow overflow-auto p-12 flex justify-center bg-[#dadada] scrollbar-retro">
                        <div class="bg-white shadow-[24px_24px_0px_0px_rgba(0,0,0,0.2)] border-2 border-black origin-top scale-100 mb-12">
                            <div class="w-[210mm] min-h-[297mm]">
                                <CvPreview :form="form" :bahasa="cv.bahasa" />
                            </div>
                        </div>
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
</style>
