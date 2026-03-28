<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
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
