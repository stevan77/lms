<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    school: {
        type: Object,
        required: true,
    },
});

const admins = props.school.admins || [];

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const impersonate = (userId) => {
    router.post(route('impersonate.start', userId));
};

const submit = () => {
    form.post(route('superadmin.schools.store-admin', props.school.id), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head :title="t('Assign Admin')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Assign Admin') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ school.name }}</p>
            </div>
        </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Existing Admins -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">{{ t('Current Admins') }}</h2>
                    <p class="mt-0.5 text-sm text-gray-500">{{ t('Admins currently assigned to this school') }}</p>
                </div>

                <div v-if="admins.length > 0" class="divide-y divide-gray-100">
                    <div
                        v-for="admin in admins"
                        :key="admin.id"
                        class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-colors"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 text-white text-sm font-semibold">
                                {{ admin.name?.charAt(0)?.toUpperCase() }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ admin.name }}</p>
                                <p class="text-xs text-gray-500">{{ admin.email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                @click="impersonate(admin.id)"
                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-full transition-colors"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                {{ t('Impersonate') }}
                            </button>
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-purple-700 bg-purple-50 rounded-full">
                                {{ t('Admin') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div v-else class="flex flex-col items-center justify-center py-10 px-4">
                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                    <p class="text-sm text-gray-400 font-medium">{{ t('No admins assigned yet') }}</p>
                </div>
            </div>

            <!-- Create New Admin Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-purple-500 to-indigo-600" />
                <div class="p-6 sm:p-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ t('Create New Admin') }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ t('Create a new admin account for this school') }}</p>

                    <form @submit.prevent="submit" class="space-y-5">
                        <InputField
                            v-model="form.name"
                            :label="t('Full Name')"
                            :placeholder="t('Enter admin name')"
                            :error="form.errors.name"
                        />

                        <InputField
                            v-model="form.email"
                            type="email"
                            :label="t('Email')"
                            :placeholder="t('Enter admin email')"
                            :error="form.errors.email"
                        />

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <InputField
                                v-model="form.password"
                                type="password"
                                :label="t('Password')"
                                :placeholder="t('Enter password')"
                                :error="form.errors.password"
                            />

                            <InputField
                                v-model="form.password_confirmation"
                                type="password"
                                :label="t('Confirm Password')"
                                :placeholder="t('Confirm password')"
                                :error="form.errors.password_confirmation"
                            />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <Link :href="route('superadmin.schools.index')">
                                <ButtonSecondary>{{ t('Back to Schools') }}</ButtonSecondary>
                            </Link>
                            <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                                {{ t('Create Admin') }}
                            </ButtonPrimary>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
