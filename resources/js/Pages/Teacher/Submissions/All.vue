<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SelectField from '@/Components/SelectField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    submissions: Array,
    grades: Array,
});

const filterGradeId = ref('');
const filterStudentSearch = ref('');
const showGraded = ref(false);
const expandedSubmission = ref(null);
const gradeForm = ref({});
const saving = ref(null);

const gradeOptions = props.grades.map(g => ({ value: g.id, label: g.name }));

const filteredSubmissions = computed(() => {
    let subs = props.submissions;

    // Filter by status
    if (!showGraded.value) {
        subs = subs.filter(s => s.status !== 'graded');
    }

    // Filter by grade
    if (filterGradeId.value) {
        subs = subs.filter(s => s.course_grade?.grade?.id == filterGradeId.value);
    }

    // Filter by student name
    if (filterStudentSearch.value.trim()) {
        const search = filterStudentSearch.value.toLowerCase().trim();
        subs = subs.filter(s => s.student?.name?.toLowerCase().includes(search));
    }

    return subs;
});

const pendingCount = computed(() => props.submissions.filter(s => s.status === 'submitted').length);
const gradedCount = computed(() => props.submissions.filter(s => s.status === 'graded').length);
const returnedCount = computed(() => props.submissions.filter(s => s.status === 'returned').length);

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
    <Head :title="t('Submissions')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Submissions') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('All assignment submissions from your students') }}</p>
            </div>
        </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4">
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
                    <div class="w-48">
                        <SelectField
                            v-model="filterGradeId"
                            :label="t('Grade')"
                            :options="gradeOptions"
                            :placeholder="t('All grades')"
                        />
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('Student') }}</label>
                        <input
                            v-model="filterStudentSearch"
                            type="text"
                            :placeholder="t('Search by name...')"
                            class="block w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 outline-none focus:ring-2 focus:ring-offset-0 focus:border-indigo-400 focus:ring-indigo-200 bg-white"
                        />
                    </div>
                    <div>
                        <button
                            @click="showGraded = !showGraded"
                            :class="[
                                'px-4 py-2.5 text-sm font-medium rounded-xl border transition-colors',
                                showGraded
                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100'
                                    : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100'
                            ]"
                        >
                            {{ showGraded ? t('Hide graded') : t('Show graded') }}
                        </button>
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
                    <button @click="toggle(sub.id); initGradeForm(sub)" class="w-full px-5 py-3 flex items-center gap-4 hover:bg-gray-50/50 transition-colors text-left">
                        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-xs font-semibold shrink-0">
                            {{ sub.student?.name?.charAt(0)?.toUpperCase() }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ sub.student?.name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ sub.course_grade?.course?.name }} &rarr;
                                <span v-if="sub.course_grade?.grade">{{ sub.course_grade.grade.name }}</span>
                                <span v-else-if="sub.course_grade?.student">{{ sub.course_grade.student.name }}</span>
                                &rarr; {{ sub.lesson?.title }}
                            </p>
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

            <!-- Empty -->
            <div v-if="!filteredSubmissions.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-gray-50 mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">{{ showGraded ? t('No submissions found') : t('No pending submissions') }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
