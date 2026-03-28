<script setup>
import { ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import draggable from 'vuedraggable';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import LessonContent from '@/Components/LessonContent.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    course: Object,
    chapters: Array,
    grades: Array,
});

// Local mutable copy of chapters for drag & drop
const localChapters = ref(JSON.parse(JSON.stringify(props.chapters)));

const saveOrder = (type, ids) => {
    router.post(route('teacher.reorder'), { type, ids }, {
        preserveScroll: true,
        preserveState: true,
    });
};

const onChapterDragEnd = () => {
    saveOrder('chapters', localChapters.value.map(c => c.id));
};

const onSubchapterDragEnd = (chapter) => {
    saveOrder('subchapters', chapter.subchapters.map(s => s.id));
};

const onLessonDragEnd = (sub) => {
    saveOrder('lessons', sub.lessons.map(l => l.id));
};

// Chapter form
const newChapterTitle = ref('');
const addChapter = () => {
    if (!newChapterTitle.value.trim()) return;
    router.post(route('teacher.chapters.store', props.course.id), { title: newChapterTitle.value }, {
        preserveScroll: true,
        onSuccess: () => {
            newChapterTitle.value = '';
            localChapters.value = JSON.parse(JSON.stringify(props.chapters));
        },
    });
};

// Subchapter form
const newSubchapterTitle = ref({});
const addSubchapter = (chapterId) => {
    const title = newSubchapterTitle.value[chapterId];
    if (!title?.trim()) return;
    router.post(route('teacher.subchapters.store', chapterId), { title }, {
        preserveScroll: true,
        onSuccess: () => {
            newSubchapterTitle.value[chapterId] = '';
            localChapters.value = JSON.parse(JSON.stringify(props.chapters));
        },
    });
};

// Edit inline
const editingChapter = ref(null);
const editingSubchapter = ref(null);
const editTitle = ref('');

const startEditChapter = (ch) => { editingChapter.value = ch.id; editTitle.value = ch.title; };
const saveChapter = (ch) => {
    router.put(route('teacher.chapters.update', ch.id), { title: editTitle.value }, { preserveScroll: true });
    editingChapter.value = null;
};

const startEditSubchapter = (sc) => { editingSubchapter.value = sc.id; editTitle.value = sc.title; };
const saveSubchapter = (sc) => {
    router.put(route('teacher.subchapters.update', sc.id), { title: editTitle.value }, { preserveScroll: true });
    editingSubchapter.value = null;
};

// Delete
const deleteModal = ref(false);
const deleteTarget = ref(null);
const deleteType = ref('');

const confirmDelete = (type, item) => {
    deleteType.value = type;
    deleteTarget.value = item;
    deleteModal.value = true;
};

const executeDelete = () => {
    const routeMap = {
        chapter: 'teacher.chapters.destroy',
        subchapter: 'teacher.subchapters.destroy',
        lesson: 'teacher.lessons.destroy',
    };
    router.delete(route(routeMap[deleteType.value], deleteTarget.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModal.value = false;
            localChapters.value = JSON.parse(JSON.stringify(props.chapters));
        },
    });
};

// Preview
const expandedLesson = ref(null);
const togglePreview = (id) => { expandedLesson.value = expandedLesson.value === id ? null : id; };

const stripHtml = (html) => html?.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim().substring(0, 100) || '';
</script>

<template>
    <Head :title="course.name + ' - ' + t('Lessons')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ course.name }}</h1>
                    <div class="mt-1.5 flex items-center gap-2">
                        <span class="text-sm text-gray-500">{{ t('Grades') }}:</span>
                        <span v-for="g in grades" :key="g.id" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">{{ g.name }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Link v-for="g in grades" :key="g.course_grade_id" :href="route('teacher.progress.index', g.course_grade_id)"
                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg transition-colors"
                    >
                        {{ t('Progress') }} {{ g.name }}
                    </Link>
                </div>
            </div>
        </template>

        <!-- Chapters -->
        <draggable
            v-model="localChapters"
            item-key="id"
            handle=".chapter-drag-handle"
            ghost-class="opacity-30"
            animation="200"
            class="space-y-6"
            @end="onChapterDragEnd"
        >
            <template #item="{ element: chapter, index: ci }">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
                    <!-- Chapter header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-5 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <span class="chapter-drag-handle cursor-grab active:cursor-grabbing flex items-center justify-center w-7 h-7 rounded-lg bg-white/20 text-white text-xs font-bold hover:bg-white/30 transition-colors" :title="t('Drag to reorder')">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                </svg>
                            </span>
                            <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-white/20 text-white text-xs font-bold">{{ ci + 1 }}</span>
                            <template v-if="editingChapter === chapter.id">
                                <input v-model="editTitle" @keydown.enter="saveChapter(chapter)" @keydown.escape="editingChapter = null" class="flex-1 px-2 py-1 text-sm rounded bg-white/20 text-white placeholder-white/60 border-0 focus:ring-2 focus:ring-white/50" autofocus />
                                <button @click="saveChapter(chapter)" class="text-white/80 hover:text-white text-xs px-2">OK</button>
                            </template>
                            <template v-else>
                                <h2 class="text-base font-semibold text-white truncate">{{ chapter.title }}</h2>
                            </template>
                        </div>
                        <div class="flex items-center gap-1 ml-2">
                            <button @click="startEditChapter(chapter)" class="p-1.5 text-white/60 hover:text-white hover:bg-white/10 rounded transition-colors" :title="t('Edit')">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            </button>
                            <button @click="confirmDelete('chapter', chapter)" class="p-1.5 text-white/60 hover:text-red-300 hover:bg-white/10 rounded transition-colors" :title="t('Delete')">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Subchapters -->
                    <div class="divide-y divide-gray-100">
                        <draggable
                            v-model="chapter.subchapters"
                            item-key="id"
                            handle=".subchapter-drag-handle"
                            ghost-class="opacity-30"
                            animation="200"
                            @end="onSubchapterDragEnd(chapter)"
                        >
                            <template #item="{ element: sub, index: si }">
                                <div>
                                    <!-- Subchapter header -->
                                    <div class="bg-gray-50 px-5 py-2.5 flex items-center justify-between border-b border-gray-100">
                                        <div class="flex items-center gap-2 flex-1 min-w-0">
                                            <span class="subchapter-drag-handle cursor-grab active:cursor-grabbing p-0.5 text-gray-400 hover:text-gray-600 transition-colors" :title="t('Drag to reorder')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                                </svg>
                                            </span>
                                            <span class="text-xs font-mono text-gray-400">{{ ci + 1 }}.{{ si + 1 }}</span>
                                            <template v-if="editingSubchapter === sub.id">
                                                <input v-model="editTitle" @keydown.enter="saveSubchapter(sub)" @keydown.escape="editingSubchapter = null" class="flex-1 px-2 py-1 text-sm rounded border border-gray-300 focus:ring-2 focus:ring-indigo-500" autofocus />
                                                <button @click="saveSubchapter(sub)" class="text-indigo-600 text-xs px-2">OK</button>
                                            </template>
                                            <template v-else>
                                                <h3 class="text-sm font-semibold text-gray-700 truncate">{{ sub.title }}</h3>
                                            </template>
                                        </div>
                                        <div class="flex items-center gap-1 ml-2">
                                            <Link :href="route('teacher.lessons.create', sub.id)" class="inline-flex items-center gap-1 px-2 py-1 text-[11px] font-medium text-indigo-600 hover:bg-indigo-50 rounded transition-colors">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                                {{ t('Lesson') }}
                                            </Link>
                                            <button @click="startEditSubchapter(sub)" class="p-1 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                            </button>
                                            <button @click="confirmDelete('subchapter', sub)" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Lessons -->
                                    <draggable
                                        v-model="sub.lessons"
                                        item-key="id"
                                        handle=".lesson-drag-handle"
                                        ghost-class="opacity-30"
                                        animation="200"
                                        @end="onLessonDragEnd(sub)"
                                    >
                                        <template #item="{ element: lesson }">
                                            <div class="hover:bg-gray-50/50 transition-colors">
                                                <div class="px-5 py-3 flex items-center gap-3">
                                                    <span class="lesson-drag-handle cursor-grab active:cursor-grabbing p-0.5 text-gray-300 hover:text-gray-500 transition-colors" :title="t('Drag to reorder')">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                                        </svg>
                                                    </span>
                                                    <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-[11px] font-bold shrink-0">
                                                        {{ lesson.order }}
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center gap-2">
                                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ lesson.title }}</h4>
                                                            <span v-if="lesson.is_assignment" class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold text-amber-700 bg-amber-50 border border-amber-200">{{ t('Assignment') }}</span>
                                                        </div>
                                                        <p v-if="expandedLesson !== lesson.id" class="text-xs text-gray-400 truncate">{{ stripHtml(lesson.content) }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 shrink-0">
                                                        <!-- Submissions links per grade (only for assignments) -->
                                                        <template v-if="lesson.is_assignment">
                                                            <Link
                                                                v-for="g in grades"
                                                                :key="'sub-' + g.course_grade_id"
                                                                :href="route('teacher.submissions.index', [lesson.id, g.course_grade_id])"
                                                                class="px-2 py-1 text-[11px] font-medium text-amber-700 bg-amber-50 border border-amber-200 rounded hover:bg-amber-100 transition-colors"
                                                            >
                                                                {{ t('Submissions') }} {{ g.name }}
                                                            </Link>
                                                        </template>
                                                        <button @click="togglePreview(lesson.id)" :class="['px-2 py-1 text-[11px] font-medium rounded border transition-all', expandedLesson === lesson.id ? 'text-indigo-700 bg-indigo-50 border-indigo-200' : 'text-gray-500 bg-white border-gray-200 hover:bg-gray-50']">
                                                            {{ expandedLesson === lesson.id ? t('Hide') : t('Preview') }}
                                                        </button>
                                                        <Link :href="route('teacher.lessons.edit', lesson.id)" class="px-2 py-1 text-[11px] font-medium text-gray-600 bg-white border border-gray-200 rounded hover:bg-gray-50 transition-colors">
                                                            {{ t('Edit') }}
                                                        </Link>
                                                        <button @click="confirmDelete('lesson', lesson)" class="px-2 py-1 text-[11px] font-medium text-red-600 bg-white border border-red-200 rounded hover:bg-red-50 transition-colors">
                                                            {{ t('Delete') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Preview -->
                                                <div v-if="expandedLesson === lesson.id" class="px-5 pb-4">
                                                    <div class="bg-gray-50/50 rounded-xl border border-gray-100 p-5">
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-50 border border-indigo-100 mb-3">{{ t('Student view') }}</span>
                                                        <LessonContent :content="lesson.content" :key="lesson.content" />
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </draggable>

                                    <!-- Empty subchapter -->
                                    <div v-if="!sub.lessons?.length" class="px-5 py-4 text-center text-xs text-gray-400">
                                        {{ t('No lessons yet') }} —
                                        <Link :href="route('teacher.lessons.create', sub.id)" class="text-indigo-600 hover:underline">{{ t('Create First Lesson') }}</Link>
                                    </div>
                                </div>
                            </template>
                        </draggable>

                        <!-- Add subchapter -->
                        <div class="px-5 py-3 flex items-center gap-2">
                            <input v-model="newSubchapterTitle[chapter.id]" @keydown.enter="addSubchapter(chapter.id)" :placeholder="t('New subchapter title...')" class="flex-1 px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            <button @click="addSubchapter(chapter.id)" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                {{ t('Add Subchapter') }}
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </draggable>

        <!-- Add chapter -->
        <div class="bg-white rounded-xl shadow-sm border border-dashed border-gray-300 p-5 flex items-center gap-3 mt-6">
            <input v-model="newChapterTitle" @keydown.enter="addChapter" :placeholder="t('New chapter title...')" class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
            <ButtonPrimary @click="addChapter">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                {{ t('Add Chapter') }}
            </ButtonPrimary>
        </div>

        <!-- Empty state -->
        <div v-if="!localChapters?.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center mt-6">
            <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-indigo-50 mb-4">
                <svg class="w-8 h-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ t('No chapters yet') }}</h3>
            <p class="text-sm text-gray-500">{{ t('Start by adding your first chapter above') }}</p>
        </div>

        <DeleteConfirmModal :show="deleteModal" :title="t('Delete')" :message="t('Are you sure? This action cannot be undone.')" @close="deleteModal = false" @confirm="executeDelete" />
    </AuthenticatedLayout>
</template>
