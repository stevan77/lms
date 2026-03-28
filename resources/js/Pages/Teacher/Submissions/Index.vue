<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    lesson: Object,
    courseGrade: Object,
    submissions: Array,
    notSubmitted: Array,
});

const expandedSubmission = ref(null);
const gradeForm = ref({});
const saving = ref(null);

const toggle = (id) => {
    expandedSubmission.value = expandedSubmission.value === id ? null : id;
};

const initGradeForm = (sub) => {
    if (!gradeForm.value[sub.id]) {
        gradeForm.value[sub.id] = {
            grade: sub.grade || '',
            feedback: sub.feedback || '',
            status: 'graded',
        };
    }
};

const saveReview = (sub) => {
    saving.value = sub.id;
    router.put(route('teacher.submissions.update', sub.id), gradeForm.value[sub.id], {
        preserveScroll: true,
        onFinish: () => { saving.value = null; },
    });
};

const returnSubmission = (sub) => {
    saving.value = sub.id;
    router.put(route('teacher.submissions.update', sub.id), {
        grade: null,
        feedback: gradeForm.value[sub.id]?.feedback || '',
        status: 'returned',
    }, {
        preserveScroll: true,
        onFinish: () => { saving.value = null; },
    });
};

const statusColors = {
    submitted: { bg: 'bg-amber-50', text: 'text-amber-700', border: 'border-amber-200', label: 'Submitted' },
    reviewed: { bg: 'bg-blue-50', text: 'text-blue-700', border: 'border-blue-200', label: 'Reviewed' },
    graded: { bg: 'bg-emerald-50', text: 'text-emerald-700', border: 'border-emerald-200', label: 'Graded' },
    returned: { bg: 'bg-orange-50', text: 'text-orange-700', border: 'border-orange-200', label: 'Returned' },
};
</script>

<template>
    <Head :title="t('Submissions') + ' - ' + lesson.title" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Submissions') }}</h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{ courseGrade.course?.name }} → {{ courseGrade.grade?.name }} → {{ lesson.title }}
                </p>
            </div>
        </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ submissions.filter(s => s.status === 'graded').length }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Graded') }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-amber-600">{{ submissions.filter(s => s.status === 'submitted').length }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Awaiting Review') }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 p-4 text-center">
                    <p class="text-2xl font-bold text-gray-400">{{ notSubmitted.length }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ t('Not Submitted') }}</p>
                </div>
            </div>

            <!-- Submissions list -->
            <div class="space-y-3">
                <div
                    v-for="sub in submissions"
                    :key="sub.id"
                    class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden"
                >
                    <!-- Header row -->
                    <button @click="toggle(sub.id); initGradeForm(sub)" class="w-full px-5 py-3 flex items-center gap-4 hover:bg-gray-50/50 transition-colors text-left">
                        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-xs font-semibold shrink-0">
                            {{ sub.student?.name?.charAt(0)?.toUpperCase() }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ sub.student?.name }}</p>
                            <p class="text-xs text-gray-500">{{ sub.student?.email }}</p>
                        </div>
                        <span v-if="sub.grade" class="text-lg font-bold text-emerald-600 mr-2">{{ sub.grade }}/5</span>
                        <span :class="['inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium', statusColors[sub.status]?.bg, statusColors[sub.status]?.text]">
                            {{ t(statusColors[sub.status]?.label) }}
                        </span>
                        <svg :class="['w-4 h-4 text-gray-400 transition-transform', expandedSubmission === sub.id ? 'rotate-180' : '']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Expanded -->
                    <div v-show="expandedSubmission === sub.id" class="border-t border-gray-100">
                        <!-- Student's work -->
                        <div class="px-5 py-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ t('Student Work') }}</p>
                            <pre class="text-sm text-gray-800 font-mono whitespace-pre-wrap bg-gray-50 p-4 rounded-lg border border-gray-200 max-h-[400px] overflow-auto">{{ sub.content }}</pre>
                            <p class="text-xs text-gray-400 mt-2">{{ t('Submitted') }}: {{ new Date(sub.submitted_at).toLocaleString() }}</p>
                        </div>

                        <!-- Grade & feedback form -->
                        <div v-if="gradeForm[sub.id]" class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ t('Review') }}</p>
                            <div class="flex gap-4 mb-3">
                                <div class="w-32">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ t('Grade') }} (1-5)</label>
                                    <input
                                        v-model="gradeForm[sub.id].grade"
                                        type="number" min="1" max="5"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    />
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ t('Feedback') }}</label>
                                    <textarea
                                        v-model="gradeForm[sub.id].feedback"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 resize-y"
                                        rows="3"
                                        :placeholder="t('Write feedback for the student...')"
                                    />
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <ButtonPrimary @click="saveReview(sub)" :loading="saving === sub.id" :disabled="saving === sub.id">
                                    {{ t('Save Grade') }}
                                </ButtonPrimary>
                                <button
                                    @click="returnSubmission(sub)"
                                    :disabled="saving === sub.id"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-orange-700 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition-colors disabled:opacity-50"
                                >
                                    {{ t('Return for Revision') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Not submitted -->
            <div v-if="notSubmitted.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
                <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">{{ t('Not Submitted') }} ({{ notSubmitted.length }})</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    <div v-for="student in notSubmitted" :key="student.id" class="px-5 py-2.5 flex items-center gap-3">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-200 text-gray-500 text-xs font-semibold">
                            {{ student.name?.charAt(0)?.toUpperCase() }}
                        </div>
                        <span class="text-sm text-gray-600">{{ student.name }}</span>
                        <span class="text-xs text-gray-400">{{ student.email }}</span>
                    </div>
                </div>
            </div>

            <!-- Empty -->
            <div v-if="!submissions.length && !notSubmitted.length" class="bg-white rounded-xl p-12 text-center">
                <p class="text-sm text-gray-500">{{ t('No submissions yet') }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
