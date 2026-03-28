<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.teachers.store'));
};
</script>

<template>
    <Head :title="t('Create Teacher')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Create Teacher') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Add a new teacher to your school') }}</p>
            </div>
        </template>

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <form @submit.prevent="submit" class="space-y-5">
                    <InputField
                        v-model="form.name"
                        :label="t('Name')"
                        :placeholder="t('Enter teacher name')"
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

                    <div class="flex items-center gap-3 pt-4">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ t('Create Teacher') }}
                        </ButtonPrimary>
                        <Link :href="route('admin.teachers.index')">
                            <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
