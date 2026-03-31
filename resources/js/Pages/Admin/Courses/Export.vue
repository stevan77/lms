<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
});

const selectedLessons = ref(new Set());

const allLessonIds = computed(() => {
    const ids = [];
    for (const chapter of props.course.chapters) {
        for (const sub of chapter.subchapters) {
            for (const lesson of sub.lessons) {
                ids.push(lesson.id);
            }
        }
    }
    return ids;
});

const allSelected = computed(() => allLessonIds.value.length > 0 && allLessonIds.value.every(id => selectedLessons.value.has(id)));

const toggleAll = () => {
    if (allSelected.value) {
        selectedLessons.value = new Set();
    } else {
        selectedLessons.value = new Set(allLessonIds.value);
    }
};

const chapterLessonIds = (chapter) => {
    const ids = [];
    for (const sub of chapter.subchapters) {
        for (const lesson of sub.lessons) {
            ids.push(lesson.id);
        }
    }
    return ids;
};

const isChapterSelected = (chapter) => {
    const ids = chapterLessonIds(chapter);
    return ids.length > 0 && ids.every(id => selectedLessons.value.has(id));
};

const isChapterIndeterminate = (chapter) => {
    const ids = chapterLessonIds(chapter);
    const some = ids.some(id => selectedLessons.value.has(id));
    const all = ids.every(id => selectedLessons.value.has(id));
    return some && !all;
};

const toggleChapter = (chapter) => {
    const ids = chapterLessonIds(chapter);
    if (isChapterSelected(chapter)) {
        ids.forEach(id => selectedLessons.value.delete(id));
    } else {
        ids.forEach(id => selectedLessons.value.add(id));
    }
    selectedLessons.value = new Set(selectedLessons.value);
};

const subLessonIds = (sub) => sub.lessons.map(l => l.id);

const isSubSelected = (sub) => {
    const ids = subLessonIds(sub);
    return ids.length > 0 && ids.every(id => selectedLessons.value.has(id));
};

const isSubIndeterminate = (sub) => {
    const ids = subLessonIds(sub);
    const some = ids.some(id => selectedLessons.value.has(id));
    const all = ids.every(id => selectedLessons.value.has(id));
    return some && !all;
};

const toggleSub = (sub) => {
    const ids = subLessonIds(sub);
    if (isSubSelected(sub)) {
        ids.forEach(id => selectedLessons.value.delete(id));
    } else {
        ids.forEach(id => selectedLessons.value.add(id));
    }
    selectedLessons.value = new Set(selectedLessons.value);
};

const toggleLesson = (id) => {
    if (selectedLessons.value.has(id)) {
        selectedLessons.value.delete(id);
    } else {
        selectedLessons.value.add(id);
    }
    selectedLessons.value = new Set(selectedLessons.value);
};

const exporting = ref(false);

const exportSelected = async () => {
    exporting.value = true;
    try {
        const response = await axios.post(
            route('admin.courses.export.download', props.course.id),
            { lesson_ids: Array.from(selectedLessons.value) },
            { responseType: 'blob' }
        );

        const url = window.URL.createObjectURL(response.data);
        const a = document.createElement('a');
        a.href = url;
        a.download = response.headers['content-disposition']?.match(/filename="?(.+?)"?$/)?.[1]
            || props.course.name.replace(/\s+/g, '_') + '_export.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    } finally {
        exporting.value = false;
    }
};
</script>

<template>
    <Head :title="t('Export Course')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Export Course') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ course.name }}</p>
                </div>
                <div class="flex gap-2">
                    <Link :href="route('admin.courses.index')">
                        <ButtonSecondary>{{ t('Back') }}</ButtonSecondary>
                    </Link>
                    <ButtonPrimary @click="exportSelected" :disabled="selectedLessons.size === 0 || exporting">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        {{ exporting ? t('Exporting...') : t('Export Selected') }} ({{ selectedLessons.size }})
                    </ButtonPrimary>
                </div>
            </div>
        </template>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        :checked="allSelected"
                        :indeterminate="!allSelected && selectedLessons.size > 0"
                        @change="toggleAll"
                        class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    <span class="text-sm font-semibold text-gray-900">{{ t('Select All') }}</span>
                    <span class="text-xs text-gray-400">({{ allLessonIds.length }} {{ t('lessons') }})</span>
                </label>
            </div>

            <div v-if="course.chapters.length === 0" class="px-6 py-12 text-center">
                <p class="text-sm text-gray-500">{{ t('This course has no content to export.') }}</p>
            </div>

            <div v-for="chapter in course.chapters" :key="chapter.id" class="border-b border-gray-100 last:border-0">
                <!-- Chapter -->
                <label class="flex items-center gap-3 px-6 py-3 bg-gray-50/50 cursor-pointer hover:bg-gray-50">
                    <input
                        type="checkbox"
                        :checked="isChapterSelected(chapter)"
                        :indeterminate="isChapterIndeterminate(chapter)"
                        @change="toggleChapter(chapter)"
                        class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-800">{{ chapter.title }}</span>
                </label>

                <!-- Subchapters -->
                <div v-for="sub in chapter.subchapters" :key="sub.id">
                    <label class="flex items-center gap-3 pl-12 pr-6 py-2.5 cursor-pointer hover:bg-gray-50/50">
                        <input
                            type="checkbox"
                            :checked="isSubSelected(sub)"
                            :indeterminate="isSubIndeterminate(sub)"
                            @change="toggleSub(sub)"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <svg class="w-3.5 h-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">{{ sub.title }}</span>
                    </label>

                    <!-- Lessons -->
                    <label
                        v-for="lesson in sub.lessons"
                        :key="lesson.id"
                        class="flex items-center gap-3 pl-20 pr-6 py-2 cursor-pointer hover:bg-gray-50/50"
                    >
                        <input
                            type="checkbox"
                            :checked="selectedLessons.has(lesson.id)"
                            @change="toggleLesson(lesson.id)"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-600">{{ lesson.title }}</span>
                        <span v-if="lesson.is_assignment" class="text-xs px-1.5 py-0.5 bg-amber-50 text-amber-700 rounded border border-amber-100 font-medium">{{ t('Assignment') }}</span>
                    </label>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
