<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import SelectField from '@/Components/SelectField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const form = useForm({
    name: '',
    level: '',
    section: '',
    locale: 'sr',
});

const localeOptions = [
    { value: 'sr', label: 'Srpski' },
    { value: 'ro', label: 'Română' },
    { value: 'en', label: 'English' },
];

const submit = () => {
    form.post(route('admin.grades.store'));
};
</script>

<template>
    <Head :title="t('Create Grade')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Create Grade') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Add a new grade to your school') }}</p>
            </div>
        </template>

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <form @submit.prevent="submit" class="space-y-5">
                    <InputField
                        v-model="form.name"
                        :label="t('Name')"
                        :placeholder="t('Enter grade name')"
                        :error="form.errors.name"
                    />

                    <InputField
                        v-model="form.level"
                        :label="t('Level')"
                        :placeholder="t('Enter level')"
                        :error="form.errors.level"
                    />

                    <InputField
                        v-model="form.section"
                        :label="t('Section')"
                        :placeholder="t('Enter section')"
                        :error="form.errors.section"
                    />

                    <SelectField
                        v-model="form.locale"
                        :label="t('Language')"
                        :options="localeOptions"
                        :error="form.errors.locale"
                    />

                    <div class="flex items-center gap-3 pt-4">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ t('Create Grade') }}
                        </ButtonPrimary>
                        <Link :href="route('admin.grades.index')">
                            <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
