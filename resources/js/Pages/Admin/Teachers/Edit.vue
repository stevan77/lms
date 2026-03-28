<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    teacher: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.teacher.name,
    email: props.teacher.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('admin.teachers.update', props.teacher.id));
};
</script>

<template>
    <Head :title="t('Edit Teacher')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Edit Teacher') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Update teacher information') }}</p>
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

                    <div class="flex items-center gap-3 pt-4">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ t('Update Teacher') }}
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
