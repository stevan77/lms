<script setup>
import { ref, computed, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    schools: {
        type: Object,
        required: true,
    },
    allSchools: {
        type: Array,
        default: () => [],
    },
});

const showDeleteModal = ref(false);
const schoolToDelete = ref(null);

const showCopyModal = ref(false);
const sourceSchoolId = ref(null);
const selectedCourseId = ref(null);
const targetSchoolId = ref(null);
const copying = ref(false);

const sourceCourses = computed(() => {
    const school = props.allSchools.find(s => s.id === sourceSchoolId.value);
    return school?.courses || [];
});

const targetSchools = computed(() => {
    return props.allSchools.filter(s => s.id !== sourceSchoolId.value);
});

watch(sourceSchoolId, () => {
    selectedCourseId.value = null;
    targetSchoolId.value = null;
});

const openCopyModal = () => {
    sourceSchoolId.value = null;
    selectedCourseId.value = null;
    targetSchoolId.value = null;
    showCopyModal.value = true;
};

const copyCourse = () => {
    if (!selectedCourseId.value || !targetSchoolId.value) return;
    copying.value = true;
    router.post(route('superadmin.schools.copy-course'), {
        course_id: selectedCourseId.value,
        target_school_id: targetSchoolId.value,
    }, {
        onFinish: () => {
            copying.value = false;
            showCopyModal.value = false;
        },
    });
};

const confirmDelete = (school) => {
    schoolToDelete.value = school;
    showDeleteModal.value = true;
};

const impersonate = (userId) => {
    router.post(route('impersonate.start', userId));
};

const deleteSchool = () => {
    if (schoolToDelete.value) {
        router.delete(route('superadmin.schools.destroy', schoolToDelete.value.id), {
            onFinish: () => {
                showDeleteModal.value = false;
                schoolToDelete.value = null;
            },
        });
    }
};
</script>

<template>
    <Head :title="t('Schools')" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl font-bold text-gray-900">{{ t('Schools') }}</h1>
        </template>

        <!-- Header actions -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-gray-500">
                {{ t('Manage all schools in the system') }}
            </p>
            <div class="flex items-center gap-3">
                <ButtonSecondary @click="openCopyModal">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                    </svg>
                    {{ t('Copy Course') }}
                </ButtonSecondary>
                <Link :href="route('superadmin.schools.create')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ t('Create School') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </div>

        <!-- Schools grid -->
        <div v-if="schools.data && schools.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="school in schools.data"
                :key="school.id"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300"
            >
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-600" />
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ school.name }}</h3>

                    <div class="space-y-2 mb-4">
                        <div v-if="school.address" class="flex items-start gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span>{{ school.address }}</span>
                        </div>
                        <div v-if="school.email" class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <span>{{ school.email }}</span>
                        </div>
                        <div v-if="school.phone" class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <span>{{ school.phone }}</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center gap-4 py-3 border-t border-gray-100 text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            {{ school.admins_count || 0 }} {{ t('Admins') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                            {{ school.teachers_count || 0 }} {{ t('Teachers') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772" />
                            </svg>
                            {{ school.students_count || 0 }} {{ t('Students') }}
                        </span>
                    </div>

                    <!-- Admins with impersonate -->
                    <div v-if="school.admins && school.admins.length" class="pt-3 border-t border-gray-100 space-y-2 mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ t('Admins') }}</p>
                        <div
                            v-for="admin in school.admins"
                            :key="admin.id"
                            class="flex items-center justify-between gap-2"
                        >
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="flex items-center justify-center w-6 h-6 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 text-white text-[10px] font-semibold shrink-0">
                                    {{ admin.name?.charAt(0)?.toUpperCase() }}
                                </div>
                                <span class="text-xs text-gray-700 truncate">{{ admin.name }}</span>
                            </div>
                            <button
                                @click="impersonate(admin.id)"
                                class="inline-flex items-center gap-1 px-2 py-1 text-[10px] font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-md transition-colors shrink-0"
                            >
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                {{ t('Impersonate') }}
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                        <Link
                            :href="route('superadmin.schools.edit', school.id)"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            {{ t('Edit') }}
                        </Link>
                        <Link
                            :href="route('superadmin.schools.assign-admin', school.id)"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                            {{ t('Assign Admin') }}
                        </Link>
                        <button
                            @click="confirmDelete(school)"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors ml-auto"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                            {{ t('Delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div v-else class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center py-16 px-4">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
            </svg>
            <p class="text-lg font-medium text-gray-400 mb-2">{{ t('No schools yet') }}</p>
            <p class="text-sm text-gray-400 mb-4">{{ t('Get started by creating your first school') }}</p>
            <Link :href="route('superadmin.schools.create')">
                <ButtonPrimary>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    {{ t('Create School') }}
                </ButtonPrimary>
            </Link>
        </div>

        <!-- Pagination -->
        <div v-if="schools.links && schools.data && schools.data.length > 0" class="mt-6 flex items-center justify-center gap-1">
            <template v-for="link in schools.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    :class="[
                        'px-3 py-2 text-sm rounded-lg transition-colors',
                        link.active
                            ? 'bg-indigo-600 text-white font-semibold'
                            : 'text-gray-600 hover:bg-gray-100'
                    ]"
                    v-html="link.label"
                    preserve-scroll
                />
                <span
                    v-else
                    class="px-3 py-2 text-sm text-gray-400"
                    v-html="link.label"
                />
            </template>
        </div>

        <!-- Delete Confirmation Modal -->
        <DeleteConfirmModal
            :show="showDeleteModal"
            :title="t('Delete School')"
            :message="t('Are you sure you want to delete this school? All associated data will be permanently removed. This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteSchool"
        />

        <!-- Copy Course Modal -->
        <Modal :show="showCopyModal" max-width="lg" @close="showCopyModal = false">
            <div class="p-6">
                <div class="flex items-center justify-center w-14 h-14 mx-auto rounded-full bg-indigo-100 mb-4">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 text-center mb-6">{{ t('Copy Course') }}</h3>

                <div class="space-y-4">
                    <!-- Source School -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ t('Source School') }}</label>
                        <select
                            v-model="sourceSchoolId"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        >
                            <option :value="null" disabled>{{ t('Select school') }}...</option>
                            <option v-for="school in allSchools" :key="school.id" :value="school.id">
                                {{ school.name }} ({{ school.courses?.length || 0 }} {{ t('courses') }})
                            </option>
                        </select>
                    </div>

                    <!-- Course -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ t('Course') }}</label>
                        <select
                            v-model="selectedCourseId"
                            :disabled="!sourceSchoolId"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-100 disabled:text-gray-400"
                        >
                            <option :value="null" disabled>{{ t('Select course') }}...</option>
                            <option v-for="course in sourceCourses" :key="course.id" :value="course.id">
                                {{ course.name }}
                            </option>
                        </select>
                        <p v-if="sourceSchoolId && sourceCourses.length === 0" class="text-xs text-amber-600 mt-1">
                            {{ t('This school has no courses') }}.
                        </p>
                    </div>

                    <!-- Target School -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ t('Target School') }}</label>
                        <select
                            v-model="targetSchoolId"
                            :disabled="!selectedCourseId"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-100 disabled:text-gray-400"
                        >
                            <option :value="null" disabled>{{ t('Select target school') }}...</option>
                            <option v-for="school in targetSchools" :key="school.id" :value="school.id">
                                {{ school.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <ButtonSecondary @click="showCopyModal = false">
                        {{ t('Cancel') }}
                    </ButtonSecondary>
                    <ButtonPrimary
                        :disabled="!selectedCourseId || !targetSchoolId"
                        :loading="copying"
                        @click="copyCourse"
                    >
                        {{ t('Copy') }}
                    </ButtonPrimary>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
