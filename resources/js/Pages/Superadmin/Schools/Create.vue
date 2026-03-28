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
    address: '',
    phone: '',
    email: '',
});

const submit = () => {
    form.post(route('superadmin.schools.store'));
};
</script>

<template>
    <Head :title="t('Create School')" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl font-bold text-gray-900">{{ t('Create School') }}</h1>
        </template>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-600" />
                <div class="p-6 sm:p-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ t('School Information') }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ t('Fill in the details to create a new school') }}</p>

                    <form @submit.prevent="submit" class="space-y-5">
                        <InputField
                            v-model="form.name"
                            :label="t('School Name')"
                            :placeholder="t('Enter school name')"
                            :error="form.errors.name"
                        />

                        <InputField
                            v-model="form.address"
                            :label="t('Address')"
                            :placeholder="t('Enter school address')"
                            :error="form.errors.address"
                        />

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <InputField
                                v-model="form.phone"
                                :label="t('Phone')"
                                :placeholder="t('Enter phone number')"
                                :error="form.errors.phone"
                            />

                            <InputField
                                v-model="form.email"
                                type="email"
                                :label="t('Email')"
                                :placeholder="t('Enter email address')"
                                :error="form.errors.email"
                            />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <Link :href="route('superadmin.schools.index')">
                                <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                            </Link>
                            <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                                {{ t('Create School') }}
                            </ButtonPrimary>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
