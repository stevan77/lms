<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    courseGrade: Object,
    students: Array,
    lessons: Array,
});

const pageTitle = `${props.courseGrade.course?.name} - ${props.courseGrade.grade?.name}`;
const expandedStudent = ref(null);

const toggleStudent = (id) => {
    expandedStudent.value = expandedStudent.value === id ? null : id;
};

const getProgress = (student, lessonId) => {
    return (student.progress || []).find(p => p.lesson_id === lessonId);
};

const getStatus = (student, lessonId) => {
    const p = getProgress(student, lessonId);
    return p ? p.status : 'not_started';
};

const getCompletionPct = (student) => {
    if (!props.lessons.length) return 0;
    const done = (student.progress || []).filter(p => p.status === 'completed').length;
    return Math.round((done / props.lessons.length) * 100);
};

const getCompletedCount = (student) => {
    return (student.progress || []).filter(p => p.status === 'completed').length;
};

const getInProgressCount = (student) => {
    return (student.progress || []).filter(p => p.status === 'in_progress').length;
};

const averageCompletion = computed(() => {
    if (!props.students.length) return 0;
    return Math.round(props.students.reduce((s, st) => s + getCompletionPct(st), 0) / props.students.length);
});

const sendingReminder = ref(null);

const sendReminder = (student, lesson) => {
    const key = `${student.id}-${lesson.id}`;
    sendingReminder.value = key;

    const courseName = props.courseGrade.course?.name;
    const courseLink = route('student.courses.show', props.courseGrade.id);
    router.post(route('messages.store'), {
        subject: `${t('Send Reminder')}: ${lesson.title}`,
        body: `${t('Hello')} ${student.name},\n\n${t('This is a reminder to complete the lesson')} "${lesson.title}" ${t('from the course')} "${courseName}".\n\n${t('Open lesson')}: ${courseLink}\n\n${t('Regards')}`,
        recipient_id: student.id,
        is_broadcast: false,
    }, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => { sendingReminder.value = null; },
    });
};

const statusIcon = {
    completed: { bg: 'bg-emerald-500', ring: 'ring-emerald-200' },
    in_progress: { bg: 'bg-amber-400', ring: 'ring-amber-200' },
    not_started: { bg: 'bg-gray-300', ring: 'ring-gray-100' },
};
</script>

<template>
    <Head :title="`${pageTitle} - ${t('Progress')}`" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ pageTitle }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Student Progress') }}</p>
            </div>
        </template>

        <!-- Summary -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ students.length }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ t('Students') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                <p class="text-2xl font-bold text-indigo-600">{{ lessons.length }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ t('Lessons') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600">{{ averageCompletion }}%</p>
                <p class="text-xs text-gray-500 mt-1">{{ t('Average') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ students.filter(s => getCompletionPct(s) === 100).length }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ t('All Done') }}</p>
            </div>
        </div>

        <!-- Student cards -->
        <div class="space-y-3">
            <div
                v-for="student in students"
                :key="student.id"
                class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden"
            >
                <!-- Student row -->
                <button @click="toggleStudent(student.id)" class="w-full px-5 py-4 flex items-center gap-4 hover:bg-gray-50/30 transition-colors text-left">
                    <!-- Avatar -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-semibold shrink-0">
                        {{ student.name?.charAt(0)?.toUpperCase() }}
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-900">{{ student.name }}</p>
                            <span class="text-xs text-gray-400">{{ student.email }}</span>
                        </div>
                        <!-- Mini progress dots -->
                        <div class="flex flex-wrap items-center gap-1 mt-2">
                            <div
                                v-for="lesson in lessons"
                                :key="lesson.id"
                                :class="[
                                    'w-2.5 h-2.5 rounded-full ring-1 transition-colors',
                                    statusIcon[getStatus(student, lesson.id)]?.bg,
                                    statusIcon[getStatus(student, lesson.id)]?.ring,
                                ]"
                                :title="lesson.title + ': ' + getStatus(student, lesson.id)"
                            />
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center gap-4 shrink-0">
                        <div class="text-right hidden sm:block">
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500" />
                                    {{ getCompletedCount(student) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-amber-400" />
                                    {{ getInProgressCount(student) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-gray-300" />
                                    {{ lessons.length - getCompletedCount(student) - getInProgressCount(student) }}
                                </span>
                            </div>
                        </div>
                        <div class="w-24">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-500" :style="{ width: getCompletionPct(student) + '%' }" />
                                </div>
                                <span class="text-xs font-bold tabular-nums" :class="getCompletionPct(student) === 100 ? 'text-emerald-600' : 'text-gray-600'">
                                    {{ getCompletionPct(student) }}%
                                </span>
                            </div>
                        </div>
                        <svg :class="['w-4 h-4 text-gray-400 transition-transform', expandedStudent === student.id ? 'rotate-180' : '']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <!-- Expanded lesson detail -->
                <div v-show="expandedStudent === student.id" class="border-t border-gray-100 px-5 py-4 bg-gray-50/30">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        <div
                            v-for="lesson in lessons"
                            :key="lesson.id"
                            :class="[
                                'flex items-center gap-3 px-3 py-2 rounded-lg border transition-colors',
                                getStatus(student, lesson.id) === 'completed' ? 'bg-emerald-50 border-emerald-200' :
                                getStatus(student, lesson.id) === 'in_progress' ? 'bg-amber-50 border-amber-200' :
                                'bg-white border-gray-200'
                            ]"
                        >
                            <!-- Status icon -->
                            <div :class="[
                                'w-6 h-6 rounded-full flex items-center justify-center shrink-0',
                                getStatus(student, lesson.id) === 'completed' ? 'bg-emerald-500' :
                                getStatus(student, lesson.id) === 'in_progress' ? 'bg-amber-400' :
                                'bg-gray-300'
                            ]">
                                <svg v-if="getStatus(student, lesson.id) === 'completed'" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <svg v-else-if="getStatus(student, lesson.id) === 'in_progress'" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />
                                </svg>
                                <span v-else class="w-1.5 h-1.5 rounded-full bg-white" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium text-gray-900 truncate">{{ lesson.order }}. {{ lesson.title }}</p>
                                <p class="text-[10px]" :class="
                                    getStatus(student, lesson.id) === 'completed' ? 'text-emerald-600' :
                                    getStatus(student, lesson.id) === 'in_progress' ? 'text-amber-600' :
                                    'text-gray-400'
                                ">
                                    {{ getStatus(student, lesson.id) === 'completed' ? t('Completed') :
                                       getStatus(student, lesson.id) === 'in_progress' ? t('In Progress') :
                                       t('Not Started') }}
                                </p>
                            </div>

                            <!-- Reminder button for incomplete lessons -->
                            <button
                                v-if="getStatus(student, lesson.id) !== 'completed'"
                                @click.stop="sendReminder(student, lesson)"
                                :disabled="sendingReminder === `${student.id}-${lesson.id}`"
                                class="inline-flex items-center gap-1 px-2 py-1 text-[10px] font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-md transition-colors shrink-0 disabled:opacity-50"
                                :title="t('Send Reminder')"
                            >
                                <svg v-if="sendingReminder === `${student.id}-${lesson.id}`" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <svg v-else class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                {{ t('Remind') }}
                            </button>
                        </div>
                    </div>

                    <!-- Actions for student -->
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-200">
                        <Link
                            :href="route('messages.create', { recipient: student.id })"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            {{ t('Send Message') }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty -->
        <div v-if="!students.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
            <p class="text-sm text-gray-500">{{ t('No students in this grade') }}</p>
        </div>

        <!-- Legend -->
        <div class="mt-6 flex items-center justify-center gap-6 text-xs text-gray-500">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500" /> {{ t('Completed') }}</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-400" /> {{ t('In Progress') }}</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-gray-300" /> {{ t('Not Started') }}</span>
        </div>
    </AuthenticatedLayout>
</template>
