<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const inputClass = 'mt-1 block w-full rounded-lg border-0 bg-white/10 text-white placeholder-slate-400 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-500 sm:text-sm px-4 py-2.5';
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-300">{{ t('Name') }}</label>
                <input id="name" type="text" :class="inputClass" v-model="form.name" required autofocus autocomplete="name" placeholder="Your name" />
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

            <div class="mt-6 flex items-center justify-between">
                <Link
                    :href="route('login')"
                    class="text-sm text-slate-400 hover:text-indigo-400 transition-colors"
                >
                    {{ t('Already registered?') }}
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 disabled:opacity-50"
                >
                    <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ t('Register') }}
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
