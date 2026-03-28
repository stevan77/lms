<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SelectField from '@/Components/SelectField.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    submissions: Array,
    courses: Array,
});

const filterCourseId = ref('');
const filterStatus = ref('');

const courseOptions = props.courses.map(c => ({ value: c.id, label: c.name }));
const statusOptions = [
    { value: 'submitted', label: t('Submitted') },
    { value: 'graded', label: t('Graded') },
    { value: 'returned', label: t('Returned') },
    { value: 'reviewed', label: t('Reviewed') },
];

const filteredSubmissions = computed(() => {
    let subs = props.submissions;

    if (filterCourseId.value) {
        subs = subs.filter(s => s.course_grade?.course?.id == filterCourseId.value);
    }

    if (filterStatus.value) {
        subs = subs.filter(s => s.status === filterStatus.value);
    }

    return subs;
});

const totalCount = computed(() => props.submissions.length);
const pendingCount = computed(() => props.submissions.filter(s => s.status === 'submitted').length);
const gradedCount = computed(() => props.submissions.filter(s => s.status === 'graded').length);
const returnedCount = computed(() => props.submissions.filter(s => s.status === 'returned').length);

const expandedSubmission = ref(null);
const toggle = (id) => {
    expandedSubmission.value = expandedSubmission.value === id ? null : id;
};

const statusConfig = {
    submitted: { bg: 'bg-amber-50', text: 'text-amber-700', icon: 'clock', label: 'Awaiting Review' },
    reviewed: { bg: 'bg-blue-50', text: 'text-blue-700', icon: 'eye', label: 'Reviewed' },
    graded: { bg: 'bg-emerald-50', text: 'text-emerald-700', icon: 'check', label: 'Graded' },
    returned: { bg: 'bg-orange-50', text: 'text-orange-700', icon: 'return', label: 'Returned' },
};
</script>

<template>
    <Head :title="t('My Submissions')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('My Submissions') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Track your assignment submissions and grades') }}</p>
            </div>
        </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ totalCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Total') }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-amber-600">{{ pendingCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Awaiting Review') }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ gradedCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Graded') }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-orange-600">{{ returnedCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Returned') }}</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="w-56">
                        <SelectField
                            v-model="filterCourseId"
                            :label="t('Course')"
                            :options="courseOptions"
                            :placeholder="t('All courses')"
                        />
                    </div>
                    <div class="w-48">
                        <SelectField
                            v-model="filterStatus"
                            :label="t('Status')"
                            :options="statusOptions"
                            :placeholder="t('All statuses')"
                        />
                    </div>
                </div>
            </div>

            <!-- Submissions list -->
            <div class="space-y-3">
                <div
                    v-for="sub in filteredSubmissions"
                    :key="sub.id"
                    class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden"
                >
                    <!-- Header row -->
                    <button @click="toggle(sub.id)" class="w-full px-5 py-3 flex items-center gap-4 hover:bg-gray-50/50 transition-colors text-left">
                        <!-- Status dot -->
                        <div :class="[
                            'w-9 h-9 rounded-full flex items-center justify-center shrink-0',
                            sub.status === 'graded' ? 'bg-emerald-100' :
                            sub.status === 'submitted' ? 'bg-amber-100' :
                            sub.status === 'returned' ? 'bg-orange-100' : 'bg-blue-100'
                        ]">
                            <!-- Check icon for graded -->
                            <svg v-if="sub.status === 'graded'" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <!-- Clock icon for submitted -->
                            <svg v-else-if="sub.status === 'submitted'" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <!-- Return icon for returned -->
                            <svg v-else-if="sub.status === 'returned'" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            <!-- Eye icon for reviewed -->
                            <svg v-else class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ sub.lesson?.title }}</p>
                            <p class="text-xs text-gray-500">{{ sub.course_grade?.course?.name }}</p>
                        </div>

                        <span v-if="sub.grade" class="text-lg font-bold text-emerald-600 mr-2">{{ sub.grade }}/5</span>

                        <span :class="['inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium', statusConfig[sub.status]?.bg, statusConfig[sub.status]?.text]">
                            {{ t(statusConfig[sub.status]?.label) }}
                        </span>

                        <svg :class="['w-4 h-4 text-gray-400 transition-transform', expandedSubmission === sub.id ? 'rotate-180' : '']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Expanded content -->
                    <div v-show="expandedSubmission === sub.id" class="border-t border-gray-100">
                        <!-- Submission content -->
                        <div class="px-5 py-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ t('Your Submission') }}</p>
                            <pre class="text-sm text-gray-800 font-mono whitespace-pre-wrap bg-gray-50 p-4 rounded-lg border border-gray-200 max-h-[300px] overflow-auto">{{ sub.content }}</pre>
                            <p class="text-xs text-gray-400 mt-2">{{ t('Submitted') }}: {{ new Date(sub.submitted_at).toLocaleString() }}</p>
                        </div>

                        <!-- Grade & feedback -->
                        <div v-if="sub.grade || sub.feedback" class="px-5 py-4 border-t border-gray-100" :class="sub.status === 'graded' ? 'bg-emerald-50/50' : sub.status === 'returned' ? 'bg-orange-50/50' : 'bg-blue-50/50'">
                            <div v-if="sub.grade" class="mb-3">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ t('Grade') }}</p>
                                <p class="text-2xl font-bold text-emerald-600">{{ sub.grade }}/5</p>
                            </div>
                            <div v-if="sub.feedback">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ t('Teacher Feedback') }}</p>
                                <p class="text-sm text-gray-700">{{ sub.feedback }}</p>
                            </div>
                            <p v-if="sub.reviewed_at" class="text-xs text-gray-400 mt-2">{{ t('Reviewed') }}: {{ new Date(sub.reviewed_at).toLocaleString() }}</p>
                        </div>

                        <!-- Returned message -->
                        <div v-if="sub.status === 'returned' && !sub.feedback" class="px-5 py-4 bg-orange-50/50 border-t border-gray-100">
                            <p class="text-sm text-orange-700 font-medium">{{ t('This assignment was returned for revision. Please resubmit from the course page.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty -->
            <div v-if="!filteredSubmissions.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-gray-50 mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">{{ t('No submissions found') }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
