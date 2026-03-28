<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import SelectField from '@/Components/SelectField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    grades: {
        type: Array,
        required: true,
    },
});

const gradeOptions = props.grades.map((g) => ({ value: g.id, label: g.name }));

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    grade_ids: [],
});

const toggleGrade = (gradeId) => {
    const index = form.grade_ids.indexOf(gradeId);
    if (index === -1) {
        form.grade_ids.push(gradeId);
    } else {
        form.grade_ids.splice(index, 1);
    }
};

const isGradeSelected = (gradeId) => {
    return form.grade_ids.includes(gradeId);
};

const submit = () => {
    form.post(route('admin.students.store'));
};
</script>

<template>
    <Head :title="t('Create Student')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Create Student') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Add a new student to your school') }}</p>
            </div>
        </template>

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <form @submit.prevent="submit" class="space-y-5">
                    <InputField
                        v-model="form.name"
                        :label="t('Name')"
                        :placeholder="t('Enter student name')"
                        :error="form.errors.name"
                    />

                    <InputField
                        v-model="form.email"
                        type="email"
                        :label="t('Email')"
                        :placeholder="t('Enter email address')"
                        :error="form.errors.email"
                    />

                    <InputField
                        v-model="form.password"
                        type="password"
                        :label="t('Password')"
                        :placeholder="t('Enter password')"
                        :error="form.errors.password"
                    />

                    <InputField
                        v-model="form.password_confirmation"
                        type="password"
                        :label="t('Confirm Password')"
                        :placeholder="t('Confirm password')"
                    />

                    <!-- Grade Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ t('Grades') }}</label>
                        <div v-if="gradeOptions.length" class="flex flex-wrap gap-2">
                            <button
                                v-for="grade in gradeOptions"
                                :key="grade.value"
                                type="button"
                                @click="toggleGrade(grade.value)"
                                :class="[
                                    'px-3 py-1.5 text-sm font-medium rounded-lg border transition-all duration-200',
                                    isGradeSelected(grade.value)
                                        ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm'
                                        : 'bg-white text-gray-700 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50'
                                ]"
                            >
                                {{ grade.label }}
                            </button>
                        </div>
                        <p v-else class="text-sm text-gray-500">{{ t('No grades available.') }}</p>
                        <p v-if="form.errors.grade_ids" class="mt-1.5 text-xs text-red-500 font-medium">{{ form.errors.grade_ids }}</p>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ t('Create Student') }}
                        </ButtonPrimary>
                        <Link :href="route('admin.students.index')">
                            <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
