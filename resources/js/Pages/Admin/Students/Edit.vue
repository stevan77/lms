<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    student: {
        type: Object,
        required: true,
    },
    grades: {
        type: Array,
        required: true,
    },
});

const gradeOptions = props.grades.map((g) => ({ value: g.id, label: g.name }));

const form = useForm({
    name: props.student.name,
    email: props.student.email,
    password: '',
    password_confirmation: '',
    grade_ids: props.student.grades?.map((g) => g.id) || [],
    locale: props.student.locale || 'sr',
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
    form.put(route('admin.students.update', props.student.id));
};
</script>

<template>
    <Head :title="t('Edit Student')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Edit Student') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Update student information') }}</p>
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

                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-3">{{ t('Leave password fields empty to keep the current password.') }}</p>

                        <div class="space-y-5">
                            <InputField
                                v-model="form.password"
                                type="password"
                                :label="t('New Password')"
                                :placeholder="t('Enter new password')"
                                :error="form.errors.password"
                            />

                            <InputField
                                v-model="form.password_confirmation"
                                type="password"
                                :label="t('Confirm New Password')"
                                :placeholder="t('Confirm new password')"
                            />
                        </div>
                    </div>

                    <!-- Language -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('Language') }}</label>
                        <select
                            v-model="form.locale"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        >
                            <option value="sr">Srpski</option>
                            <option value="ro">Română</option>
                            <option value="en">English</option>
                        </select>
                    </div>

                    <!-- Grade Selection -->
                    <div class="pt-4 border-t border-gray-100">
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
                            {{ t('Update Student') }}
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
