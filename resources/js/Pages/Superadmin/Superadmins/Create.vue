<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('superadmin.superadmins.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="t('Create') + ' Superadmin'" />

        <template #header>
            <h2 class="text-xl font-bold text-gray-800">{{ t('Create') }} Superadmin</h2>
        </template>

        <div class="max-w-2xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6 sm:p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <InputField
                        :label="t('Name')"
                        v-model="form.name"
                        :error="form.errors.name"
                        required
                    />

                    <InputField
                        :label="t('Email')"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        required
                    />

                    <InputField
                        :label="t('Password')"
                        type="password"
                        v-model="form.password"
                        :error="form.errors.password"
                        required
                    />

                    <InputField
                        :label="t('Confirm Password')"
                        type="password"
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        required
                    />

                    <div class="flex items-center gap-3 pt-2">
                        <ButtonPrimary type="submit" :loading="form.processing">
                            {{ t('Save') }}
                        </ButtonPrimary>
                        <Link :href="route('superadmin.superadmins.index')">
                            <ButtonSecondary type="button">{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
