<script setup>
import { ref, computed, nextTick, onMounted } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import LessonContent from '@/Components/LessonContent.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    courseGrade: Object,
    chapters: Array,
    progressMap: Object,
    submissionsMap: Object,
});

const getSubmission = (lessonId) => props.submissionsMap?.[lessonId] || null;

// Submission form
const submissionContent = ref({});
const submittingLesson = ref(null);

const submitAssignment = (lesson) => {
    const content = submissionContent.value[lesson.id];
    if (!content?.trim()) return;
    submittingLesson.value = lesson.id;
    router.post(route('student.submissions.store', [lesson.id, props.courseGrade.id]), { content }, {
        preserveScroll: true,
        onFinish: () => { submittingLesson.value = null; },
    });
};

const processingLesson = ref(null);
const askingLesson = ref({});
const askMessage = ref({});
const sendingQuestion = ref(null);
const sentLesson = ref({});

const openAskForm = (lesson) => {
    askingLesson.value[lesson.id] = true;
    askMessage.value[lesson.id] = '';
};

const closeAskForm = (lessonId) => {
    askingLesson.value[lessonId] = false;
};

const sendQuestion = (lesson) => {
    const msg = askMessage.value[lesson.id];
    if (!msg?.trim()) return;

    sendingQuestion.value = lesson.id;
    router.post(route('messages.store'), {
        subject: t('Question about lesson') + ': ' + lesson.title,
        body: msg,
        recipient_id: props.courseGrade.teacher?.id,
        is_broadcast: false,
        stay_on_page: true,
    }, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            askingLesson.value[lesson.id] = false;
            askMessage.value[lesson.id] = '';
            sentLesson.value[lesson.id] = true;
            setTimeout(() => { sentLesson.value[lesson.id] = false; }, 5000);
        },
        onFinish: () => { sendingQuestion.value = null; },
    });
};

const toggleLesson = (id) => {
    const opening = expandedLesson.value !== id;
    expandedLesson.value = opening ? id : null;

    // Scroll to top of lesson when opening
    if (opening) {
        scrollToLesson(id);
    }

    // Mark as in_progress when opening for the first time
    if (opening && getLessonStatus(id) === 'not_started') {
        router.post(route('student.progress.update', [id, props.courseGrade.id]), { status: 'in_progress' }, {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

const getLessonStatus = (id) => props.progressMap[id] || 'not_started';

// Count all lessons and completed
const allLessons = computed(() => {
    const lessons = [];
    (props.chapters || []).forEach(ch => {
        (ch.subchapters || []).forEach(sc => {
            (sc.lessons || []).forEach(l => lessons.push(l));
        });
    });
    return lessons;
});

const completedCount = computed(() => allLessons.value.filter(l => getLessonStatus(l.id) === 'completed').length);
const progressPercentage = computed(() => {
    if (!allLessons.value.length) return 0;
    return Math.round((completedCount.value / allLessons.value.length) * 100);
});

const scrollToLesson = (lessonId) => {
    nextTick(() => {
        setTimeout(() => {
            const el = document.getElementById('lesson-' + lessonId);
            if (el) {
                const y = el.getBoundingClientRect().top + window.scrollY - 80;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        }, 100);
    });
};

const undoComplete = (lesson) => {
    processingLesson.value = lesson.id;
    router.post(route('student.progress.update', [lesson.id, props.courseGrade.id]), { status: 'in_progress', force: true }, {
        preserveScroll: true,
        onFinish: () => { processingLesson.value = null; },
    });
};

const markAsComplete = (lesson) => {
    processingLesson.value = lesson.id;
    router.post(route('student.progress.update', [lesson.id, props.courseGrade.id]), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Find next lesson and open it
            const all = allLessons.value;
            const currentIndex = all.findIndex(l => l.id === lesson.id);
            if (currentIndex >= 0 && currentIndex < all.length - 1) {
                const nextLesson = all[currentIndex + 1];
                expandedLesson.value = nextLesson.id;

                // Make sure the chapter/subchapter of next lesson is open
                for (const ch of (props.chapters || [])) {
                    for (const sc of (ch.subchapters || [])) {
                        for (const l of (sc.lessons || [])) {
                            if (l.id === nextLesson.id) {
                                collapsedChapters.value[ch.id] = false;
                                collapsedSubchapters.value[sc.id] = false;
                            }
                        }
                    }
                }

                scrollToLesson(nextLesson.id);
            }
        },
        onFinish: () => { processingLesson.value = null; },
    });
};

// Find the active chapter/subchapter/lesson (first in_progress or first not_started)
const findActivePosition = () => {
    let activeChapterId = null;
    let activeSubchapterId = null;
    let activeLessonId = null;
    let firstNotStarted = null;

    for (const ch of (props.chapters || [])) {
        for (const sc of (ch.subchapters || [])) {
            for (const lesson of (sc.lessons || [])) {
                const status = getLessonStatus(lesson.id);
                if (status === 'in_progress') {
                    return { chapterId: ch.id, subchapterId: sc.id, lessonId: lesson.id };
                }
                if (status === 'not_started' && !firstNotStarted) {
                    firstNotStarted = { chapterId: ch.id, subchapterId: sc.id, lessonId: lesson.id };
                }
            }
        }
    }

    if (firstNotStarted) return firstNotStarted;

    // Everything completed — open last
    if (props.chapters?.length) {
        const lastCh = props.chapters[props.chapters.length - 1];
        activeChapterId = lastCh.id;
        const lastSc = lastCh.subchapters?.[lastCh.subchapters.length - 1];
        activeSubchapterId = lastSc?.id;
        const lastLesson = lastSc?.lessons?.[lastSc.lessons.length - 1];
        activeLessonId = lastLesson?.id;
    }

    return { chapterId: activeChapterId, subchapterId: activeSubchapterId, lessonId: activeLessonId };
};

const activePos = findActivePosition();

// Open the active lesson
const expandedLesson = ref(activePos.lessonId || null);

// All collapsed by default, except the active one
const collapsedChapters = ref({});
const collapsedSubchapters = ref({});

// Initialize: collapse everything except active
(props.chapters || []).forEach(ch => {
    collapsedChapters.value[ch.id] = ch.id !== activePos.chapterId;
    (ch.subchapters || []).forEach(sc => {
        collapsedSubchapters.value[sc.id] = sc.id !== activePos.subchapterId;
    });
});

const toggleChapter = (id) => { collapsedChapters.value[id] = !collapsedChapters.value[id]; };
const toggleSubchapter = (id) => { collapsedSubchapters.value[id] = !collapsedSubchapters.value[id]; };

// Scroll to active lesson on page load
onMounted(() => {
    if (activePos.lessonId) {
        scrollToLesson(activePos.lessonId);
    }
});

// Count completed lessons in a chapter or subchapter
const subchapterProgress = (sc) => {
    const total = sc.lessons?.length || 0;
    const done = (sc.lessons || []).filter(l => getLessonStatus(l.id) === 'completed').length;
    return { total, done, pct: total ? Math.round((done / total) * 100) : 0 };
};

const chapterProgress = (ch) => {
    let total = 0, done = 0;
    (ch.subchapters || []).forEach(sc => {
        const p = subchapterProgress(sc);
        total += p.total;
        done += p.done;
    });
    return { total, done, pct: total ? Math.round((done / total) * 100) : 0 };
};
</script>

<template>
    <Head :title="courseGrade.course?.name" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ courseGrade.course?.name }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ courseGrade.grade?.name || t('Individual assignment') }}</p>
            </div>
        </template>

        <div class="max-w-4xl mx-auto">
            <!-- Overall progress -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6 mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-900">{{ t('Course Progress') }}</h2>
                    <span class="text-sm font-semibold text-indigo-600">{{ completedCount }} / {{ allLessons.length }}</span>
                </div>
                <ProgressBar :percentage="progressPercentage" color="indigo" />
            </div>

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
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden max-w-[200px]">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500" :style="{ width: chapterProgress(chapter).pct + '%' }" />
                                </div>
                                <span class="text-xs text-gray-500">{{ chapterProgress(chapter).done }}/{{ chapterProgress(chapter).total }}</span>
                            </div>
                        </div>
                        <svg :class="['w-5 h-5 text-gray-400 transition-transform duration-200 shrink-0', collapsedChapters[chapter.id] ? '' : 'rotate-180']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Subchapters (collapsible) -->
                    <div v-show="!collapsedChapters[chapter.id]" class="border-t border-gray-100">
                        <div v-for="(sub, si) in chapter.subchapters" :key="sub.id">
                            <!-- Subchapter header -->
                            <button @click="toggleSubchapter(sub.id)" class="w-full px-5 py-3 bg-gray-50/50 flex items-center gap-3 hover:bg-gray-100/50 transition-colors border-b border-gray-100">
                                <span class="text-xs font-mono text-indigo-500 font-semibold w-8">{{ ci + 1 }}.{{ si + 1 }}</span>
                                <h3 class="text-sm font-semibold text-gray-700 flex-1 text-left">{{ sub.title }}</h3>
                                <span class="text-xs text-gray-400">{{ subchapterProgress(sub).done }}/{{ subchapterProgress(sub).total }}</span>
                                <svg :class="['w-4 h-4 text-gray-400 transition-transform duration-200', collapsedSubchapters[sub.id] ? '' : 'rotate-180']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <!-- Lessons -->
                            <div v-show="!collapsedSubchapters[sub.id]">
                                <div v-for="lesson in sub.lessons" :key="lesson.id" :id="'lesson-' + lesson.id" class="border-b border-gray-50 last:border-b-0">
                                    <!-- Lesson row -->
                                    <button @click="toggleLesson(lesson.id)" class="w-full px-5 py-3 flex items-center gap-3 hover:bg-gray-50/30 transition-colors text-left">
                                        <!-- Status dot -->
                                        <div :class="[
                                            'w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors',
                                            getLessonStatus(lesson.id) === 'completed' ? 'bg-emerald-500 border-emerald-500' :
                                            getLessonStatus(lesson.id) === 'in_progress' ? 'bg-amber-400 border-amber-400' :
                                            'bg-white border-gray-300'
                                        ]">
                                            <svg v-if="getLessonStatus(lesson.id) === 'completed'" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900">{{ lesson.title }}</h4>
                                            <span :class="['text-xs', getLessonStatus(lesson.id) === 'completed' ? 'text-emerald-600' : getLessonStatus(lesson.id) === 'in_progress' ? 'text-amber-600' : 'text-gray-400']">
                                                {{ getLessonStatus(lesson.id) === 'completed' ? t('Completed') : getLessonStatus(lesson.id) === 'in_progress' ? t('In Progress') : t('Not Started') }}
                                            </span>
                                        </div>

                                        <svg :class="['w-4 h-4 text-gray-400 transition-transform duration-200', expandedLesson === lesson.id ? 'rotate-180' : '']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>

                                    <!-- Expanded content -->
                                    <div v-show="expandedLesson === lesson.id" class="px-5 pb-4 border-t border-gray-100">
                                        <div class="mt-4">
                                            <LessonContent :content="lesson.content" />
                                        </div>

                                        <!-- Assignment submission section -->
                                        <div v-if="lesson.is_assignment" class="mt-5 pt-4 border-t border-gray-100">
                                            <!-- Already submitted -->
                                            <div v-if="getSubmission(lesson.id)" class="rounded-xl border-2 overflow-hidden" :class="{
                                                'border-amber-200': getSubmission(lesson.id).status === 'submitted',
                                                'border-emerald-200': getSubmission(lesson.id).status === 'graded',
                                                'border-blue-200': getSubmission(lesson.id).status === 'reviewed',
                                                'border-orange-200': getSubmission(lesson.id).status === 'returned',
                                            }">
                                                <div class="px-4 py-2.5 flex items-center justify-between" :class="{
                                                    'bg-amber-50': getSubmission(lesson.id).status === 'submitted',
                                                    'bg-emerald-50': getSubmission(lesson.id).status === 'graded',
                                                    'bg-blue-50': getSubmission(lesson.id).status === 'reviewed',
                                                    'bg-orange-50': getSubmission(lesson.id).status === 'returned',
                                                }">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-sm font-semibold" :class="{
                                                            'text-amber-700': getSubmission(lesson.id).status === 'submitted',
                                                            'text-emerald-700': getSubmission(lesson.id).status === 'graded',
                                                            'text-blue-700': getSubmission(lesson.id).status === 'reviewed',
                                                            'text-orange-700': getSubmission(lesson.id).status === 'returned',
                                                        }">
                                                            {{ getSubmission(lesson.id).status === 'submitted' ? t('Submitted - Awaiting review') :
                                                               getSubmission(lesson.id).status === 'graded' ? t('Graded') :
                                                               getSubmission(lesson.id).status === 'reviewed' ? t('Reviewed') :
                                                               t('Returned - Please resubmit') }}
                                                        </span>
                                                    </div>
                                                    <span v-if="getSubmission(lesson.id).grade" class="text-lg font-bold text-emerald-700">
                                                        {{ getSubmission(lesson.id).grade }}/5
                                                    </span>
                                                </div>

                                                <!-- Feedback -->
                                                <div v-if="getSubmission(lesson.id).feedback" class="px-4 py-3 border-t" :class="{
                                                    'border-amber-100': getSubmission(lesson.id).status === 'submitted',
                                                    'border-emerald-100': getSubmission(lesson.id).status === 'graded',
                                                    'border-blue-100': getSubmission(lesson.id).status === 'reviewed',
                                                    'border-orange-100': getSubmission(lesson.id).status === 'returned',
                                                }">
                                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ t('Teacher Feedback') }}</p>
                                                    <p class="text-sm text-gray-700">{{ getSubmission(lesson.id).feedback }}</p>
                                                </div>

                                                <!-- Your submission -->
                                                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ t('Your Submission') }}</p>
                                                    <pre class="text-sm text-gray-700 font-mono whitespace-pre-wrap bg-white p-3 rounded-lg border border-gray-200">{{ getSubmission(lesson.id).content }}</pre>
                                                </div>

                                                <!-- Resubmit if returned -->
                                                <div v-if="getSubmission(lesson.id).status === 'returned'" class="px-4 py-3 border-t border-orange-100">
                                                    <textarea
                                                        v-model="submissionContent[lesson.id]"
                                                        :placeholder="t('Update your submission...')"
                                                        class="w-full px-3 py-2 text-sm font-mono border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 resize-y"
                                                        rows="6"
                                                    />
                                                    <ButtonPrimary class="mt-2" @click.stop="submitAssignment(lesson)" :loading="submittingLesson === lesson.id" :disabled="submittingLesson === lesson.id">
                                                        {{ t('Resubmit') }}
                                                    </ButtonPrimary>
                                                </div>
                                            </div>

                                            <!-- Not yet submitted -->
                                            <div v-else class="rounded-xl border-2 border-dashed border-amber-300 bg-amber-50/50 p-5">
                                                <div class="flex items-center gap-2 mb-3">
                                                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                                    </svg>
                                                    <span class="text-sm font-semibold text-amber-700">{{ t('Assignment - Submit your work') }}</span>
                                                </div>
                                                <textarea
                                                    v-model="submissionContent[lesson.id]"
                                                    :placeholder="t('Paste your code or write your answer here...')"
                                                    class="w-full px-3 py-2 text-sm font-mono border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-y bg-white"
                                                    rows="8"
                                                />
                                                <ButtonPrimary class="mt-3" @click.stop="submitAssignment(lesson)" :loading="submittingLesson === lesson.id" :disabled="submittingLesson === lesson.id || !submissionContent[lesson.id]?.trim()">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    {{ t('Submit Assignment') }}
                                                </ButtonPrimary>
                                            </div>
                                        </div>

                                        <!-- Mark as complete + Undo (non-assignment only) -->
                                        <div v-if="!lesson.is_assignment" class="mt-5 pt-4 border-t border-gray-100 flex items-center gap-3 flex-wrap">
                                            <ButtonPrimary v-if="getLessonStatus(lesson.id) !== 'completed'" @click.stop="markAsComplete(lesson)" :loading="processingLesson === lesson.id" :disabled="processingLesson === lesson.id">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                {{ t('Mark as Complete') }}
                                            </ButtonPrimary>
                                            <button
                                                v-if="getLessonStatus(lesson.id) === 'completed'"
                                                @click.stop="undoComplete(lesson)"
                                                :disabled="processingLesson === lesson.id"
                                                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-colors disabled:opacity-50"
                                            >
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                                </svg>
                                                {{ t('Mark as In Progress') }}
                                            </button>
                                        </div>

                                        <!-- Ask teacher (always visible on ALL lessons) -->
                                        <div class="mt-3 flex items-center gap-3 flex-wrap">
                                            <button
                                                v-if="!askingLesson[lesson.id]"
                                                @click.stop="openAskForm(lesson)"
                                                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors"
                                            >
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                </svg>
                                                {{ t('Ask the teacher') }}
                                            </button>
                                            <span v-if="sentLesson[lesson.id]" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ t('Message sent!') }}
                                            </span>
                                        </div>
                                        <!-- Ask teacher inline form -->
                                        <div v-if="askingLesson[lesson.id]" class="mt-3 p-4 bg-indigo-50/50 border border-indigo-200 rounded-xl" @click.stop>
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                </svg>
                                                <span class="text-sm font-semibold text-indigo-700">{{ t('Ask the teacher about this lesson') }}</span>
                                            </div>
                                            <textarea
                                                v-model="askMessage[lesson.id]"
                                                :placeholder="t('Write your question here...')"
                                                class="w-full px-3 py-2 text-sm border border-indigo-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y bg-white"
                                                rows="3"
                                            />
                                            <div class="flex items-center gap-2 mt-2">
                                                <button
                                                    @click.stop="sendQuestion(lesson)"
                                                    :disabled="sendingQuestion === lesson.id || !askMessage[lesson.id]?.trim()"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all disabled:opacity-50"
                                                >
                                                    <svg v-if="sendingQuestion === lesson.id" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                                    </svg>
                                                    <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    {{ t('Send') }}
                                                </button>
                                                <button @click.stop="closeAskForm(lesson.id)" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                                                    {{ t('Cancel') }}
                                                </button>
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
