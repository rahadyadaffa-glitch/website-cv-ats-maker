<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
    nama_file: '',
    bahasa: 'id'
});

const submit = () => form.post(route('cv.store'));
const goBack = () => window.history.back();
</script>

<template>
    <Head title="Create New CV" />
    <AppLayout>
        <div class="max-w-2xl mx-auto px-4 py-16">
            <div class="retro-card">
                <div class="mb-8">
                    <h1 class="text-3xl font-black uppercase italic tracking-tight border-b-4 border-black inline-block mb-2">Create New CV</h1>
                    <p class="font-bold text-gray-600">The first step to your dream career.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-8">
                    <div>
                        <label class="label">CV Filename</label>
                        <input v-model="form.nama_file" type="text" class="input text-lg" placeholder="Example: Software Engineer CV 2026" required />
                        <p v-if="form.errors.nama_file" class="mt-2 text-red-600 font-bold text-sm italic">{{ form.errors.nama_file }}</p>
                    </div>

                    <div>
                        <label class="label">Choose CV Language</label>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <label class="cursor-pointer group">
                                <input type="radio" v-model="form.bahasa" value="id" class="hidden peer" />
                                <div class="p-6 border-4 border-black text-center font-black uppercase transition-all peer-checked:bg-[#FFFF00] peer-checked:shadow-hard group-hover:-translate-y-1">
                                    🇮🇩 Indonesia
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" v-model="form.bahasa" value="en" class="hidden peer" />
                                <div class="p-6 border-4 border-black text-center font-black uppercase transition-all peer-checked:bg-[#ADD8E6] peer-checked:shadow-hard group-hover:-translate-y-1">
                                    🇬🇧 English
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-between gap-4">
                        <button type="button" @click="goBack" class="btn-secondary flex-1 justify-center">Cancel</button>
                        <button type="submit" class="btn-primary flex-1 justify-center" :disabled="form.processing">
                            {{ form.processing ? 'Processing...' : 'Start Creating CV' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
