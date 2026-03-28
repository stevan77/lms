<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    courseGrades: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head :title="t('Dashboard')" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl font-bold text-gray-900">{{ t('My Courses') }}</h1>
        </template>

        <div v-if="courseGrades.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <Link
                v-for="cg in courseGrades"
                :key="cg.id"
                :href="route('student.courses.show', cg.id)"
                class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:border-indigo-200 transition-all duration-300"
            >
                <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-500" />
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                        {{ cg.course?.name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ cg.grade?.name }}</p>

                    <!-- Progress -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-gray-500">{{ t('Progress') }}</span>
                            <span class="font-semibold text-gray-900">{{ cg.progress_percentage || 0 }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div
                                class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-500"
                                :style="{ width: (cg.progress_percentage || 0) + '%' }"
                            />
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400">
                            {{ cg.completed_lessons || 0 }} / {{ cg.total_lessons || 0 }} {{ t('Lessons') }}
                        </p>
                    </div>
                </div>
            </Link>
        </div>

        <div v-else class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center py-16 px-4">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            <p class="text-gray-400 font-medium">{{ t('No courses enrolled yet') }}</p>
        </div>
    </AuthenticatedLayout>
</template>
