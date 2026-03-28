<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import SelectField from '@/Components/SelectField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    grades: {
        type: Array,
        required: true,
    },
    teachers: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    description: '',
    assignments: [],
});

const gradeOptions = props.grades.map((g) => ({ value: g.id, label: g.name }));
const teacherOptions = props.teachers.map((t) => ({ value: t.id, label: t.name }));

const addAssignment = () => {
    form.assignments.push({ grade_id: '', teacher_id: '' });
};

const removeAssignment = (index) => {
    form.assignments.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.courses.store'));
};
</script>

<template>
    <Head :title="t('Create Course')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Create Course') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Add a new course to your school') }}</p>
            </div>
        </template>

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <form @submit.prevent="submit" class="space-y-5">
                    <InputField
                        v-model="form.name"
                        :label="t('Name')"
                        :placeholder="t('Enter course name')"
                        :error="form.errors.name"
                    />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('Description') }}</label>
                        <textarea
                            v-model="form.description"
                            :placeholder="t('Enter course description')"
                            rows="3"
                            class="block w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 outline-none focus:ring-2 focus:ring-offset-0 focus:border-indigo-400 focus:ring-indigo-200 bg-white"
                        />
                        <p v-if="form.errors.description" class="mt-1.5 text-xs text-red-500 font-medium">{{ form.errors.description }}</p>
                    </div>

                    <!-- Assignments Section -->
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-gray-900">{{ t('Grade Assignments') }}</h3>
                            <ButtonSecondary type="button" @click="addAssignment">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                {{ t('Add Assignment') }}
                            </ButtonSecondary>
                        </div>

                        <div v-if="form.assignments.length === 0" class="text-center py-6 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">{{ t('No assignments added yet. You can add them now or later.') }}</p>
                        </div>

                        <div v-for="(assignment, index) in form.assignments" :key="index" class="flex items-start gap-3 mb-3 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <SelectField
                                    v-model="assignment.grade_id"
                                    :label="t('Grade')"
                                    :options="gradeOptions"
                                    :placeholder="t('Select grade')"
                                    :error="form.errors[`assignments.${index}.grade_id`]"
                                />
                                <SelectField
                                    v-model="assignment.teacher_id"
                                    :label="t('Teacher')"
                                    :options="teacherOptions"
                                    :placeholder="t('Select teacher')"
                                    :error="form.errors[`assignments.${index}.teacher_id`]"
                                />
                            </div>
                            <button
                                type="button"
                                @click="removeAssignment(index)"
                                class="mt-7 p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ t('Create Course') }}
                        </ButtonPrimary>
                        <Link :href="route('admin.courses.index')">
                            <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
