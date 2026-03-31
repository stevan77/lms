<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LessonContent from '@/Components/LessonContent.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    course: Object,
    chapters: Array,
});

const allLessons = computed(() => {
    const lessons = [];
    (props.chapters || []).forEach(ch => {
        (ch.subchapters || []).forEach(sc => {
            (sc.lessons || []).forEach(l => lessons.push(l));
        });
    });
    return lessons;
});

// First lesson open by default
const firstLesson = computed(() => allLessons.value[0] || null);
const expandedLesson = ref(firstLesson.value?.id || null);

// All chapters/subchapters open by default
const collapsedChapters = ref({});
const collapsedSubchapters = ref({});

const toggleChapter = (id) => { collapsedChapters.value[id] = !collapsedChapters.value[id]; };
const toggleSubchapter = (id) => { collapsedSubchapters.value[id] = !collapsedSubchapters.value[id]; };
const toggleLesson = (id) => { expandedLesson.value = expandedLesson.value === id ? null : id; };

const subchapterLessonCount = (sc) => sc.lessons?.length || 0;
const chapterLessonCount = (ch) => (ch.subchapters || []).reduce((sum, sc) => sum + subchapterLessonCount(sc), 0);
</script>

<template>
    <Head :title="course.name + ' - ' + t('Preview')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ course.name }}</h1>
                    <p class="mt-0.5 text-sm text-emerald-600 font-medium">{{ t('Student View Preview') }} &mdash; {{ allLessons.length }} {{ t('lessons') }}</p>
                </div>
            </div>
        </template>

        <div class="max-w-4xl mx-auto">
            <!-- Chapters -->
            <div class="space-y-4">
                <div v-for="(chapter, ci) in chapters" :key="chapter.id" class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
                    <!-- Chapter header -->
                    <button @click="toggleChapter(chapter.id)" class="w-full px-5 py-4 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-bold shrink-0">
                            {{ ci + 1 }}
                        </div>
                        <div class="flex-1 text-left min-w-0">
                            <h2 class="text-base font-semibold text-gray-900">{{ chapter.title }}</h2>
                            <span class="text-xs text-gray-500">{{ chapterLessonCount(chapter) }} {{ t('lessons') }}</span>
                        </div>
                        <svg :class="['w-5 h-5 text-gray-400 transition-transform duration-200 shrink-0', collapsedChapters[chapter.id] ? '' : 'rotate-180']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Subchapters -->
                    <div v-show="!collapsedChapters[chapter.id]" class="border-t border-gray-100">
                        <div v-for="(sub, si) in chapter.subchapters" :key="sub.id">
                            <!-- Subchapter header -->
                            <button @click="toggleSubchapter(sub.id)" class="w-full px-5 py-3 bg-gray-50/50 flex items-center gap-3 hover:bg-gray-100/50 transition-colors border-b border-gray-100">
                                <span class="text-xs font-mono text-indigo-500 font-semibold w-8">{{ ci + 1 }}.{{ si + 1 }}</span>
                                <h3 class="text-sm font-semibold text-gray-700 flex-1 text-left">{{ sub.title }}</h3>
                                <span class="text-xs text-gray-400">{{ subchapterLessonCount(sub) }} {{ t('lessons') }}</span>
                                <svg :class="['w-4 h-4 text-gray-400 transition-transform duration-200', collapsedSubchapters[sub.id] ? '' : 'rotate-180']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <!-- Lessons -->
                            <div v-show="!collapsedSubchapters[sub.id]">
                                <div v-for="lesson in sub.lessons" :key="lesson.id" class="border-b border-gray-50 last:border-b-0">
                                    <!-- Lesson row -->
                                    <button @click="toggleLesson(lesson.id)" class="w-full px-5 py-3 flex items-center gap-3 hover:bg-gray-50/30 transition-colors text-left">
                                        <div class="w-5 h-5 rounded-full border-2 bg-white border-gray-300 shrink-0"></div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-sm font-medium text-gray-900">{{ lesson.title }}</h4>
                                                <span v-if="lesson.is_assignment" class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold text-amber-700 bg-amber-50 border border-amber-200">{{ t('Assignment') }}</span>
                                            </div>
                                        </div>
                                        <svg :class="['w-4 h-4 text-gray-400 transition-transform duration-200', expandedLesson === lesson.id ? 'rotate-180' : '']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>

                                    <!-- Expanded content -->
                                    <div v-show="expandedLesson === lesson.id" class="px-5 pb-4 border-t border-gray-100">
                                        <div class="mt-4">
                                            <LessonContent :content="lesson.content" :key="lesson.id" />
                                        </div>

                                        <!-- Assignment indicator -->
                                        <div v-if="lesson.is_assignment" class="mt-5 pt-4 border-t border-gray-100">
                                            <div class="rounded-xl border-2 border-dashed border-amber-300 bg-amber-50/50 p-4 text-center">
                                                <span class="text-sm text-amber-700 font-medium">{{ t('Assignment - Submit your work') }}</span>
                                                <p class="text-xs text-amber-600 mt-1">{{ t('Students will see a submission form here') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty -->
            <div v-if="!chapters?.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
                <p class="text-sm text-gray-500">{{ t('No lessons available') }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
