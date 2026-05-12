<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { onMounted, ref } from 'vue';

defineProps({ 
    cvs: Array,
    title: { type: String, default: 'Drafts' }
});

const showDeleteModal = ref(false);
const itemToDelete = ref(null);

const confirmDelete = (id) => {
    itemToDelete.value = id;
    showDeleteModal.value = true;
};

const executeDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('cv.destroy', itemToDelete.value));
    }
    showDeleteModal.value = false;
    itemToDelete.value = null;
};

const formatDate = (dateStr) => {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
};

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
</script>

<template>
    <Head :title="`My CV ${title}`" />
    <AppLayout>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-6 reveal slide-up">
                <div>
                    <h1 class="text-5xl font-black uppercase tracking-tight mb-2">My CV</h1>
                    <p class="font-medium text-gray-600">All your professional documents in one place.</p>
                </div>
                <Link :href="route('cv.create')" class="btn-primary">
                    <span class="material-symbols-outlined">add</span>
                    Create New CV
                </Link>
            </div>

            <!-- Sub-navigation Tabs -->
            <div class="flex gap-4 mb-12 reveal slide-up delay-100">
                <Link :href="route('cv.index')" 
                      class="px-8 py-3 font-black uppercase tracking-tighter text-sm border-4 border-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-1"
                      :class="route().current('cv.index') ? 'bg-[#e1e1f5] translate-y-0' : 'bg-white hover:bg-gray-50 opacity-60'">
                    Drafts
                </Link>
                <Link :href="route('cv.completed')" 
                      class="px-8 py-3 font-black uppercase tracking-tighter text-sm border-4 border-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-1"
                      :class="route().current('cv.completed') ? 'bg-[#add8e6] translate-y-0' : 'bg-white hover:bg-gray-50 opacity-60'">
                    Completed
                </Link>
            </div>

            <!-- Empty State -->
            <div v-if="!cvs || cvs.length === 0" class="text-center py-24 bg-white border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] reveal slide-up">
                <span class="material-symbols-outlined text-8xl mb-6">drafts</span>
                <h2 class="text-3xl font-black uppercase mb-2">It's Empty</h2>
                <p class="font-bold text-gray-500 mb-10">You don't have any CV {{ title.toLowerCase() }} yet.</p>
                <Link :href="route('cv.create')" class="btn-primary text-xl px-12">Start Now</Link>
            </div>

            <!-- Grid of Drafts -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(cv, index) in cvs" :key="cv.id" 
                     :style="{ transitionDelay: `${(index % 3) * 100}ms` }"
                     class="bg-white border-[4px] border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex flex-col gap-4 hover:translate-y-[-4px] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all reveal slide-up">
                    
                    <div class="flex justify-between items-start">
                        <span class="material-symbols-outlined text-[48px] text-gray-900">description</span>
                        <span v-if="cv.status === 'completed'" 
                              class="bg-[#cdcd00] px-4 py-1 rounded-full border-2 border-black text-black font-bold text-sm rotate-[1deg] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] uppercase">
                            Completed
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
                            {{ cv.bahasa === 'id' ? 'Indonesian' : 'English' }}
                        </p>
                        <p class="text-[13px] font-bold text-gray-400 mt-1 uppercase tracking-wider">
                            Modified: {{ formatDate(cv.updated_at) }}
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
                                title="Delete"
                                class="w-10 h-10 border-2 border-black rounded-full flex items-center justify-center hover:bg-red-100 text-red-600 transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-y-[2px]">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <Teleport to="body">
            <div v-if="showDeleteModal" class="fixed inset-0 z-[300] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]" @click="showDeleteModal = false"></div>
                <div class="relative bg-white border-8 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] p-8 max-w-sm w-full text-center flex flex-col gap-6 rotate-[-1deg]">
                    <div class="space-y-2">
                        <span class="material-symbols-outlined text-6xl text-red-600 animate-bounce">warning</span>
                        <h3 class="text-2xl font-black uppercase italic tracking-tighter">Hapus CV?</h3>
                        <p class="font-bold text-gray-600">Apakah anda yakin ingin hapus? Seluruh data CV ini akan hilang selamanya.</p>
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
    </AppLayout>
</template>

<style scoped>
.reveal {
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.17, 0.55, 0.55, 1);
}

.reveal.slide-up {
    transform: translateY(30px);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}
</style>
