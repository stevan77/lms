<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    courseGrades: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head :title="t('My Courses')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('My Courses') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Continue learning where you left off') }}</p>
            </div>
        </template>

        <!-- Empty State -->
        <div v-if="courseGrades.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-indigo-50 mb-4">
                <svg class="w-8 h-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ t('No courses available') }}</h3>
            <p class="text-sm text-gray-500">{{ t('You have not been assigned to any courses yet.') }}</p>
        </div>

        <!-- Course Cards Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <Link
                v-for="cg in courseGrades"
                :key="cg.id"
                :href="route('student.courses.show', cg.id)"
                class="group bg-white rounded-xl shadow-sm border border-gray-200/60 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 overflow-hidden"
            >
                <!-- Card Header -->
                <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 p-5 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <circle cx="80" cy="20" r="40" fill="white" />
                            <circle cx="20" cy="80" r="30" fill="white" />
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                            {{ cg.grade?.name || t('Individual') }}
                        </span>
                        <h3 class="text-lg font-bold text-white mt-2 line-clamp-2 group-hover:translate-x-0.5 transition-transform duration-200">
                            {{ cg.course?.name }}
                        </h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5">
                    <p class="text-sm text-gray-500 line-clamp-2 mb-4 min-h-[2.5rem]">
                        {{ cg.course?.description || t('No description available') }}
                    </p>

                    <!-- Progress -->
                    <div class="space-y-2">
                        <ProgressBar :percentage="cg.progress_percentage" />
                        <p class="text-xs text-gray-500">
                            {{ cg.completed_lessons }} {{ t('of') }} {{ cg.total_lessons }} {{ t('lessons completed') }}
                        </p>
                    </div>
                </div>
            </Link>
        </div>
    </AuthenticatedLayout>
</template>
