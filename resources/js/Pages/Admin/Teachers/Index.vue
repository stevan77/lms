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
    teachers: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const teacherToDelete = ref(null);

const confirmDelete = (teacher) => {
    teacherToDelete.value = teacher;
    showDeleteModal.value = true;
};

const impersonate = (userId) => {
    router.post(route('impersonate.start', userId));
};

const deleteTeacher = () => {
    router.delete(route('admin.teachers.destroy', teacherToDelete.value.id), {
        onFinish: () => {
            showDeleteModal.value = false;
            teacherToDelete.value = null;
        },
    });
};
</script>

<template>
    <Head :title="t('Teachers')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Teachers') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ t('Manage your school teachers') }}</p>
                </div>
                <Link :href="route('admin.teachers.create')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ t('Add Teacher') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </template>

        <!-- Teachers Grid -->
        <div v-if="teachers.data.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                v-for="teacher in teachers.data"
                :key="teacher.id"
                class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-5 hover:shadow-md transition-shadow"
            >
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-semibold shrink-0">
                        {{ teacher.name?.charAt(0)?.toUpperCase() }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ teacher.name }}</h3>
                        <p class="text-xs text-gray-500 truncate">{{ teacher.email }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                {{ teacher.teaching_assignments_count ?? 0 }} {{ t('courses') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                    <Link :href="route('admin.teachers.edit', teacher.id)" class="flex-1">
                        <ButtonSecondary class="w-full">{{ t('Edit') }}</ButtonSecondary>
                    </Link>
                    <button
                        @click="impersonate(teacher.id)"
                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-colors"
                        :title="t('Impersonate')"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                    </button>
                    <ButtonDanger @click="confirmDelete(teacher)">{{ t('Delete') }}</ButtonDanger>
                </div>
            </div>
        </div>

        <div v-else class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
            <p class="text-sm text-gray-500">{{ t('No teachers found.') }}</p>
        </div>

        <!-- Pagination -->
        <div v-if="teachers.links && teachers.last_page > 1" class="mt-6 flex items-center justify-between">
            <p class="text-sm text-gray-500">
                {{ t('Showing') }} {{ teachers.from }} {{ t('to') }} {{ teachers.to }} {{ t('of') }} {{ teachers.total }}
            </p>
            <div class="flex gap-1">
                <Link
                    v-for="link in teachers.links"
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

        <!-- Delete Confirm Modal -->
        <DeleteConfirmModal
            :show="showDeleteModal"
            :title="t('Delete Teacher')"
            :message="t('Are you sure you want to delete this teacher? All associated data will be removed. This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteTeacher"
        />
    </AuthenticatedLayout>
</template>
