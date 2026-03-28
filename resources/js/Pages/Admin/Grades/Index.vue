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
    grades: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const gradeToDelete = ref(null);
const copiedGradeId = ref(null);

const confirmDelete = (grade) => {
    gradeToDelete.value = grade;
    showDeleteModal.value = true;
};

const deleteGrade = () => {
    router.delete(route('admin.grades.destroy', gradeToDelete.value.id), {
        onFinish: () => {
            showDeleteModal.value = false;
            gradeToDelete.value = null;
        },
    });
};

const copyEnrollLink = (grade) => {
    const url = route('enroll.show', grade.enrollment_token);
    navigator.clipboard.writeText(url).then(() => {
        copiedGradeId.value = grade.id;
        setTimeout(() => { copiedGradeId.value = null; }, 2000);
    });
};
</script>

<template>
    <Head :title="t('Grades')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Grades') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ t('Manage your school grades') }}</p>
                </div>
                <Link :href="route('admin.grades.create')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ t('Add Grade') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </template>

        <!-- Grades Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Name') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Level') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Section') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Language') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Students') }}</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Enrollment Link') }}</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="grade in grades.data" :key="grade.id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ grade.name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ grade.level || '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ grade.section || '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="[
                                    'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium',
                                    grade.locale === 'sr' ? 'bg-blue-50 text-blue-700' :
                                    grade.locale === 'ro' ? 'bg-yellow-50 text-yellow-700' :
                                    'bg-gray-50 text-gray-700'
                                ]">
                                    {{ grade.locale === 'sr' ? 'Srpski' : grade.locale === 'ro' ? 'Română' : 'English' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                    {{ grade.students_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    @click="copyEnrollLink(grade)"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200"
                                    :class="copiedGradeId === grade.id
                                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                        : 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200 hover:bg-indigo-100'"
                                >
                                    <svg v-if="copiedGradeId === grade.id" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <svg v-else class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                    </svg>
                                    {{ copiedGradeId === grade.id ? t('Copied!') : t('Copy Link') }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="route('admin.grades.edit', grade.id)">
                                        <ButtonSecondary>{{ t('Edit') }}</ButtonSecondary>
                                    </Link>
                                    <ButtonDanger @click="confirmDelete(grade)">{{ t('Delete') }}</ButtonDanger>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="grades.data.length === 0">
                            <td colspan="7" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-500">{{ t('No grades found.') }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="grades.links && grades.last_page > 1" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    {{ t('Showing') }} {{ grades.from }} {{ t('to') }} {{ grades.to }} {{ t('of') }} {{ grades.total }}
                </p>
                <div class="flex gap-1">
                    <Link
                        v-for="link in grades.links"
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
            :title="t('Delete Grade')"
            :message="t('Are you sure you want to delete this grade? All associated data will be removed. This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteGrade"
        />
    </AuthenticatedLayout>
</template>
