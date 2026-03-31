<script setup>
import { ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    courses: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const courseToDelete = ref(null);
const showImportModal = ref(false);
const importCourseId = ref(null);
const importFile = ref(null);
const importing = ref(false);
const importStep = ref(1);
const importData = ref(null);
const existingStructure = ref([]);
const mergeDecisions = ref({ chapters: {}, subchapters: {} });
const analyzing = ref(false);

const confirmDelete = (course) => {
    courseToDelete.value = course;
    showDeleteModal.value = true;
};

const deleteCourse = () => {
    router.delete(route('admin.courses.destroy', courseToDelete.value.id), {
        onFinish: () => {
            showDeleteModal.value = false;
            courseToDelete.value = null;
        },
    });
};

const openImport = (course) => {
    importCourseId.value = course.id;
    importFile.value = null;
    importStep.value = 1;
    importData.value = null;
    existingStructure.value = [];
    mergeDecisions.value = { chapters: {}, subchapters: {} };
    showImportModal.value = true;
};

const handleFileChange = (e) => {
    importFile.value = e.target.files[0];
};

const findMatches = (importChapters, existing) => {
    const decisions = { chapters: {}, subchapters: {} };
    let hasConflicts = false;

    importChapters.forEach((ch, ci) => {
        const match = existing.find(e => e.title.toLowerCase().trim() === ch.title.toLowerCase().trim());
        if (match) {
            decisions.chapters[ci] = match.id;
            hasConflicts = true;

            (ch.subchapters || []).forEach((sub, si) => {
                const subMatch = (match.subchapters || []).find(
                    es => es.title.toLowerCase().trim() === sub.title.toLowerCase().trim()
                );
                if (subMatch) {
                    decisions.subchapters[ci + '_' + si] = subMatch.id;
                }
            });
        }
    });

    return { decisions, hasConflicts };
};

const analyzeFile = async () => {
    if (!importFile.value) return;
    analyzing.value = true;

    try {
        const text = await importFile.value.text();
        const parsed = JSON.parse(text);

        if (!parsed || !parsed.lms_export_version || !parsed.chapters) {
            alert(t('Invalid export file format.'));
            analyzing.value = false;
            return;
        }

        importData.value = parsed;

        const response = await axios.get(route('admin.courses.structure', importCourseId.value));
        existingStructure.value = response.data;

        const { decisions, hasConflicts } = findMatches(parsed.chapters, response.data);

        if (hasConflicts) {
            mergeDecisions.value = decisions;
            importStep.value = 2;
        } else {
            submitImport();
        }
    } catch (e) {
        alert(t('Error reading file.'));
    }

    analyzing.value = false;
};

const toggleChapterMerge = (ci, existingId) => {
    if (mergeDecisions.value.chapters[ci]) {
        delete mergeDecisions.value.chapters[ci];
        // Also remove subchapter merges for this chapter
        Object.keys(mergeDecisions.value.subchapters).forEach(key => {
            if (key.startsWith(ci + '_')) {
                delete mergeDecisions.value.subchapters[key];
            }
        });
    } else {
        mergeDecisions.value.chapters[ci] = existingId;
        // Re-check subchapter matches
        const chapter = importData.value.chapters[ci];
        const existing = existingStructure.value.find(e => e.id === existingId);
        if (chapter && existing) {
            (chapter.subchapters || []).forEach((sub, si) => {
                const subMatch = (existing.subchapters || []).find(
                    es => es.title.toLowerCase().trim() === sub.title.toLowerCase().trim()
                );
                if (subMatch) {
                    mergeDecisions.value.subchapters[ci + '_' + si] = subMatch.id;
                }
            });
        }
    }
};

const toggleSubchapterMerge = (key, existingId) => {
    if (mergeDecisions.value.subchapters[key]) {
        delete mergeDecisions.value.subchapters[key];
    } else {
        mergeDecisions.value.subchapters[key] = existingId;
    }
};

const getExistingChapterMatch = (ci) => {
    const ch = importData.value.chapters[ci];
    return existingStructure.value.find(e => e.title.toLowerCase().trim() === ch.title.toLowerCase().trim());
};

const getExistingSubMatch = (ci, si) => {
    const existingChapter = existingStructure.value.find(e => e.id === mergeDecisions.value.chapters[ci]);
    if (!existingChapter) return null;
    const sub = importData.value.chapters[ci].subchapters[si];
    return (existingChapter.subchapters || []).find(
        es => es.title.toLowerCase().trim() === sub.title.toLowerCase().trim()
    );
};

const submitImport = () => {
    if (!importFile.value) return;
    importing.value = true;

    const formData = new FormData();
    formData.append('file', importFile.value);
    formData.append('merge_map', JSON.stringify(mergeDecisions.value));

    router.post(route('admin.courses.import', importCourseId.value), formData, {
        forceFormData: true,
        onFinish: () => {
            importing.value = false;
            showImportModal.value = false;
            importFile.value = null;
            importStep.value = 1;
        },
    });
};
</script>

<template>
    <Head :title="t('Courses')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Courses') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ t('Manage your school courses') }}</p>
                </div>
                <Link :href="route('admin.courses.create')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ t('Add Course') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </template>

        <!-- Courses Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Name') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Description') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Assignments') }}</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="course in courses.data" :key="course.id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ course.name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 line-clamp-2">{{ course.description || '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div v-if="course.course_grades && course.course_grades.length" class="flex flex-wrap gap-1.5">
                                    <span
                                        v-for="cg in course.course_grades"
                                        :key="cg.id"
                                        :class="[
                                            'inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border',
                                            cg.student_id
                                                ? 'bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 border-emerald-100'
                                                : 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border-indigo-100'
                                        ]"
                                    >
                                        {{ cg.student_id ? cg.student?.name : cg.grade?.name }} &mdash; {{ cg.teacher?.name }}
                                    </span>
                                </div>
                                <span v-else class="text-sm text-gray-400">{{ t('No assignments') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a :href="route('admin.courses.export', course.id)">
                                        <ButtonSecondary>{{ t('Export') }}</ButtonSecondary>
                                    </a>
                                    <ButtonSecondary @click="openImport(course)">{{ t('Import') }}</ButtonSecondary>
                                    <Link :href="route('admin.courses.edit', course.id)">
                                        <ButtonSecondary>{{ t('Edit') }}</ButtonSecondary>
                                    </Link>
                                    <ButtonDanger @click="confirmDelete(course)">{{ t('Delete') }}</ButtonDanger>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="courses.data.length === 0">
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500">{{ t('No courses found.') }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="courses.links && courses.last_page > 1" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    {{ t('Showing') }} {{ courses.from }} {{ t('to') }} {{ courses.to }} {{ t('of') }} {{ courses.total }}
                </p>
                <div class="flex gap-1">
                    <Link
                        v-for="link in courses.links"
                        :key="link.label"
                        :href="link.url || '#'"
                        :class="[
                            'px-3 py-1.5 text-sm rounded-lg transition-colors',
                            link.active
                                ? 'bg-indigo-600 text-white'
                                : link.url
                                    ? 'text-gray-600 hover:bg-gray-100'
                                    : 'text-gray-300 cursor-not-allowed'
                        ]"
                        v-html="link.label"
                        preserve-scroll
                    />
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div v-if="showImportModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full" :class="importStep === 1 ? 'max-w-md' : 'max-w-2xl'">

                <!-- Step 1: File Select -->
                <div v-if="importStep === 1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ t('Import Course Content') }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ t('Select a JSON export file. Content will be added to the existing course.') }}</p>
                    <input
                        type="file"
                        accept=".json"
                        @change="handleFileChange"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mb-4"
                    />
                    <div class="flex justify-end gap-2">
                        <ButtonSecondary @click="showImportModal = false">{{ t('Cancel') }}</ButtonSecondary>
                        <ButtonPrimary @click="analyzeFile" :disabled="!importFile || analyzing">
                            {{ analyzing ? t('Analyzing...') : t('Continue') }}
                        </ButtonPrimary>
                    </div>
                </div>

                <!-- Step 2: Conflict Resolution -->
                <div v-if="importStep === 2 && importData">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ t('Matching content found') }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ t('Some chapters/subchapters already exist in this course. Choose whether to add lessons to existing ones or create new.') }}</p>

                    <div class="max-h-96 overflow-y-auto space-y-3 mb-4">
                        <div v-for="(chapter, ci) in importData.chapters" :key="ci" class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="px-4 py-3 bg-gray-50 flex items-center justify-between">
                                <div>
                                    <span class="text-sm font-semibold text-gray-900">{{ chapter.title }}</span>
                                    <span class="text-xs text-gray-500 ml-2">({{ (chapter.subchapters || []).length }} {{ t('subchapters') }})</span>
                                </div>
                                <div v-if="getExistingChapterMatch(ci)">
                                    <button
                                        @click="toggleChapterMerge(ci, getExistingChapterMatch(ci).id)"
                                        :class="[
                                            'px-3 py-1 text-xs font-medium rounded-lg border transition-colors',
                                            mergeDecisions.chapters[ci]
                                                ? 'bg-amber-50 text-amber-700 border-amber-200'
                                                : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                        ]"
                                    >
                                        {{ mergeDecisions.chapters[ci] ? t('Merge into existing') : t('Create new') }}
                                    </button>
                                </div>
                                <span v-else class="text-xs text-emerald-600 font-medium">{{ t('New') }}</span>
                            </div>

                            <!-- Subchapters (only show when chapter is set to merge) -->
                            <div v-if="mergeDecisions.chapters[ci] && chapter.subchapters" class="divide-y divide-gray-100">
                                <div v-for="(sub, si) in chapter.subchapters" :key="si" class="px-4 py-2 pl-8 flex items-center justify-between">
                                    <div>
                                        <span class="text-sm text-gray-700">{{ sub.title }}</span>
                                        <span class="text-xs text-gray-400 ml-2">({{ (sub.lessons || []).length }} {{ t('lessons') }})</span>
                                    </div>
                                    <div v-if="getExistingSubMatch(ci, si)">
                                        <button
                                            @click="toggleSubchapterMerge(ci + '_' + si, getExistingSubMatch(ci, si).id)"
                                            :class="[
                                                'px-3 py-1 text-xs font-medium rounded-lg border transition-colors',
                                                mergeDecisions.subchapters[ci + '_' + si]
                                                    ? 'bg-amber-50 text-amber-700 border-amber-200'
                                                    : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                            ]"
                                        >
                                            {{ mergeDecisions.subchapters[ci + '_' + si] ? t('Merge into existing') : t('Create new') }}
                                        </button>
                                    </div>
                                    <span v-else class="text-xs text-emerald-600 font-medium">{{ t('New') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <ButtonSecondary @click="importStep = 1">{{ t('Back') }}</ButtonSecondary>
                        <div class="flex gap-2">
                            <ButtonSecondary @click="showImportModal = false">{{ t('Cancel') }}</ButtonSecondary>
                            <ButtonPrimary @click="submitImport" :disabled="importing">
                                {{ importing ? t('Importing...') : t('Import') }}
                            </ButtonPrimary>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Delete Confirm Modal -->
        <DeleteConfirmModal
            :show="showDeleteModal"
            :title="t('Delete Course')"
            :message="t('Are you sure you want to delete this course? All associated data will be removed. This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteCourse"
        />
    </AuthenticatedLayout>
</template>
