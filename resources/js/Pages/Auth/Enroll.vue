<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    grade: Object,
    school: Object,
    token: String,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('enroll.store', props.token), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const inputClass = 'mt-1 block w-full rounded-lg border-0 bg-white/10 text-white placeholder-slate-400 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-500 sm:text-sm px-4 py-2.5';
</script>

<template>
    <GuestLayout>
        <Head :title="t('Enrollment') + ' - ' + grade.name" />

        <!-- Enrollment info banner -->
        <div class="mb-6 p-4 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-500/20 shrink-0">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ school.name }}</p>
                    <p class="text-xs text-slate-400">{{ t('Enrollment') }} <span class="text-indigo-400 font-semibold">{{ grade.name }}</span></p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-300">{{ t('Full Name') }}</label>
                <input id="name" type="text" :class="inputClass" v-model="form.name" required autofocus autocomplete="name" placeholder="Petar Petrović" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-5">
                <label for="email" class="block text-sm font-medium text-slate-300">{{ t('Email') }}</label>
                <input id="email" type="email" :class="inputClass" v-model="form.email" required autocomplete="username" placeholder="email@example.com" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-5">
                <label for="password" class="block text-sm font-medium text-slate-300">{{ t('Password') }}</label>
                <input id="password" type="password" :class="inputClass" v-model="form.password" required autocomplete="new-password" placeholder="••••••••" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-5">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-300">{{ t('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" :class="inputClass" v-model="form.password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 disabled:opacity-50"
                >
                    <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ t('Create account and enroll') }}
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
