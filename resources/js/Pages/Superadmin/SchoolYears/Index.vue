<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    schoolYears: Array,
});
</script>

<template>
    <Head :title="t('School Years')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">{{ t('School Years') }}</h1>
                <Link :href="route('superadmin.school-years.preview')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ t('Close Year') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </template>

        <div class="max-w-3xl mx-auto space-y-4">
            <div
                v-for="year in schoolYears"
                :key="year.id"
                :class="[
                    'bg-white rounded-xl shadow-sm border overflow-hidden',
                    year.is_active ? 'border-indigo-300 ring-2 ring-indigo-100' : 'border-gray-200/60'
                ]"
            >
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div :class="[
                            'flex items-center justify-center w-12 h-12 rounded-xl text-lg font-bold',
                            year.is_active ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white' : 'bg-gray-100 text-gray-500'
                        ]">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ year.name }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ year.grades_count }} {{ t('Grades').toLowerCase() }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span v-if="year.is_active" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
                            {{ t('Active') }}
                        </span>
                        <span v-else-if="year.is_locked" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold text-gray-500 bg-gray-100">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            {{ t('Locked') }}
                        </span>
                    </div>
                </div>
            </div>

            <div v-if="!schoolYears?.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
                <p class="text-sm text-gray-500">{{ t('No school years yet') }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
