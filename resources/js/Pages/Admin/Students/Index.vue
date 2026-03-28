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
    students: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const studentToDelete = ref(null);

const confirmDelete = (student) => {
    studentToDelete.value = student;
    showDeleteModal.value = true;
};

const impersonate = (userId) => {
    router.post(route('impersonate.start', userId));
};

const deleteStudent = () => {
    router.delete(route('admin.students.destroy', studentToDelete.value.id), {
        onFinish: () => {
            showDeleteModal.value = false;
            studentToDelete.value = null;
        },
    });
};
</script>

<template>
    <Head :title="t('Students')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Students') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ t('Manage your school students') }}</p>
                </div>
                <Link :href="route('admin.students.create')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ t('Add Student') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </template>

        <!-- Students Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Student') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Email') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Grades') }}</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-xs font-semibold shrink-0">
                                        {{ student.name?.charAt(0)?.toUpperCase() }}
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ student.name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ student.email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div v-if="student.grades && student.grades.length" class="flex flex-wrap gap-1.5">
                                    <span
                                        v-for="grade in student.grades"
                                        :key="grade.id"
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700"
                                    >
                                        {{ grade.name }}
                                    </span>
                                </div>
                                <span v-else class="text-sm text-gray-400">{{ t('No grade assigned') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        @click="impersonate(student.id)"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-colors"
                                        :title="t('Impersonate')"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                        </svg>
                                    </button>
                                    <Link :href="route('admin.students.edit', student.id)">
                                        <ButtonSecondary>{{ t('Edit') }}</ButtonSecondary>
                                    </Link>
                                    <ButtonDanger @click="confirmDelete(student)">{{ t('Delete') }}</ButtonDanger>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="students.data.length === 0">
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500">{{ t('No students found.') }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="students.links && students.last_page > 1" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    {{ t('Showing') }} {{ students.from }} {{ t('to') }} {{ students.to }} {{ t('of') }} {{ students.total }}
                </p>
                <div class="flex gap-1">
                    <Link
                        v-for="link in students.links"
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
            :title="t('Delete Student')"
            :message="t('Are you sure you want to delete this student? All associated data will be removed. This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteStudent"
        />
    </AuthenticatedLayout>
</template>
