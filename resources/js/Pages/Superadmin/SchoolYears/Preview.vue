<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    activeYear: Object,
    nextYearName: String,
    schools: Array,
    totalSchools: Number,
    totalGraduating: Number,
    totalStudents: Number,
});

const confirmed = ref(false);
const processing = ref(false);

const closeYear = () => {
    processing.value = true;
    router.post(route('superadmin.school-years.close'), {}, {
        onFinish: () => { processing.value = false; },
    });
};
</script>

<template>
    <Head :title="t('Close Year')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link :href="route('superadmin.school-years.index')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </Link>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Close Year') }}: {{ activeYear.name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ t('Preview changes before closing the school year') }}</p>
                </div>
            </div>
        </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Summary cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ activeYear.name }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Current Year') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ nextYearName }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('New Year') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ totalStudents }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Total Students') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-amber-600">{{ totalGraduating }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Graduating') }}</p>
                </div>
            </div>

            <!-- Per school breakdown -->
            <div v-for="schoolData in schools" :key="schoolData.school.id" class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">{{ schoolData.school.name }}</h3>
                    <span class="text-xs text-gray-500">{{ schoolData.total_students }} {{ t('Students').toLowerCase() }}</span>
                </div>

                <div class="divide-y divide-gray-50">
                    <div v-for="tr in schoolData.transitions" :key="tr.from" class="px-5 py-3 flex items-center gap-4">
                        <!-- From -->
                        <div class="w-20 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-semibold bg-gray-100 text-gray-700">
                                {{ tr.from }}
                            </span>
                        </div>

                        <!-- Arrow -->
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>

                        <!-- To -->
                        <div class="w-20 text-center">
                            <span v-if="tr.action === 'promote'" class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-semibold bg-emerald-50 text-emerald-700">
                                {{ tr.to }}
                            </span>
                            <span v-else class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-semibold bg-amber-50 text-amber-700">
                                {{ t('Graduated') }}
                            </span>
                        </div>

                        <!-- Student count -->
                        <span class="text-sm text-gray-500 ml-auto">
                            {{ tr.students_count }} {{ t('Students').toLowerCase() }}
                        </span>
                    </div>
                </div>

                <div v-if="!schoolData.transitions.length" class="px-5 py-4 text-center text-sm text-gray-400">
                    {{ t('No grades in this school') }}
                </div>
            </div>

            <!-- Confirmation -->
            <div class="bg-white rounded-xl shadow-sm border-2 border-amber-200 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-gray-900 mb-1">{{ t('This action cannot be undone') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ t('Closing the year will') }}:
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0" />
                                {{ t('Create new school year') }} <strong>{{ nextYearName }}</strong>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shrink-0" />
                                {{ t('Promote students to next grade level') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0" />
                                {{ t('Mark 8th grade students as graduated') }} ({{ totalGraduating }})
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0" />
                                {{ t('Lock current year as read-only archive') }}
                            </li>
                        </ul>

                        <label class="flex items-center gap-2 cursor-pointer mb-4">
                            <input type="checkbox" v-model="confirmed" class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-500" />
                            <span class="text-sm font-medium text-gray-700">{{ t('I understand and want to proceed') }}</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <ButtonPrimary
                                @click="closeYear"
                                :disabled="!confirmed || processing"
                                :loading="processing"
                            >
                                {{ t('Close Year and Create') }} {{ nextYearName }}
                            </ButtonPrimary>
                            <Link :href="route('superadmin.school-years.index')">
                                <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
