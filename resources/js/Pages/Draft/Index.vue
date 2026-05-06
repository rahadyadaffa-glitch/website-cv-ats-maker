<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ cvs: Array });

const confirmDelete = (id) => {
    if (confirm('Yakin ingin menghapus CV ini? Tindakan ini tidak bisa dibatalkan.')) {
        router.delete(route('cv.destroy', id));
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
};
</script>

<template>
    <Head title="Draft CV Saya" />
    <AppLayout>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
                <div>
                    <h1 class="text-5xl font-black uppercase tracking-tight mb-2">Draft CV Saya</h1>
                    <p class="font-medium text-gray-600">Semua CV yang pernah kamu buat tersimpan di sini.</p>
                </div>
                <Link :href="route('cv.create')" class="btn-primary">
                    <span class="material-symbols-outlined">add</span>
                    Buat CV Baru
                </Link>
            </div>

            <!-- Empty State -->
            <div v-if="!cvs || cvs.length === 0" class="text-center py-24 bg-white border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <span class="material-symbols-outlined text-8xl mb-6">drafts</span>
                <h2 class="text-3xl font-black uppercase mb-2">Masih Kosong</h2>
                <p class="font-bold text-gray-500 mb-10">Kamu belum memiliki draft CV sama sekali.</p>
                <Link :href="route('cv.create')" class="btn-primary text-xl px-12">Mulai Sekarang</Link>
            </div>

            <!-- Grid of Drafts -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(cv, index) in cvs" :key="cv.id" 
                     class="bg-white border-[4px] border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex flex-col gap-4 hover:translate-y-[-4px] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all">
                    
                    <div class="flex justify-between items-start">
                        <span class="material-symbols-outlined text-[48px] text-gray-900">description</span>
                        <span v-if="cv.status === 'completed'" 
                              class="bg-[#cdcd00] px-4 py-1 rounded-full border-2 border-black text-black font-bold text-sm rotate-[1deg] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] uppercase">
                            Selesai
                        </span>
                        <span v-else 
                              :class="index % 2 === 0 ? 'rotate-[2deg]' : 'rotate-[-2deg]'"
                              class="bg-[#ADD8E6] px-4 py-1 rounded-full border-2 border-black text-black font-bold text-sm shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] uppercase">
                            Draft
                        </span>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-2xl font-black truncate uppercase tracking-tighter" :title="cv.nama_file">{{ cv.nama_file }}</h3>
                        <p class="text-sm font-bold text-gray-600 flex items-center gap-2 mt-2 uppercase">
                            <span class="material-symbols-outlined text-[18px]">language</span> 
                            {{ cv.bahasa === 'id' ? 'Bahasa Indonesia' : 'English' }}
                        </p>
                        <p class="text-[13px] font-bold text-gray-400 mt-1 uppercase tracking-wider">
                            Diubah: {{ formatDate(cv.updated_at) }}
                        </p>
                    </div>

                    <div class="flex gap-2 mt-4 justify-between pt-4 border-t-2 border-black border-dashed">
                        <div class="flex gap-2">
                            <Link :href="route('cv.edit', cv.id)" 
                                  title="Edit"
                                  class="w-10 h-10 border-2 border-black rounded-full flex items-center justify-center hover:bg-[#e1e1f5] transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-[2px]">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </Link>
                            <Link :href="route('cv.preview', cv.id)" 
                                  title="Preview"
                                  class="w-10 h-10 border-2 border-black rounded-full flex items-center justify-center hover:bg-[#eaea00] transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-[2px]">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </Link>
                            <a :href="route('cv.download', cv.id)" 
                               title="Download PDF"
                               class="w-10 h-10 border-2 border-black rounded-full flex items-center justify-center hover:bg-[#ADD8E6] transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-[2px]">
                                <span class="material-symbols-outlined text-xl">download</span>
                            </a>
                        </div>
                        <button @click="confirmDelete(cv.id)" 
                                title="Hapus"
                                class="w-10 h-10 border-2 border-black rounded-full flex items-center justify-center hover:bg-red-100 text-red-600 transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-[2px]">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
