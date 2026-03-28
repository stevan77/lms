<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();
const currentUserId = usePage().props.auth.user.id;

defineProps({
    superadmins: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const itemToDelete = ref(null);

const confirmDelete = (sa) => {
    itemToDelete.value = sa;
    showDeleteModal.value = true;
};

const deleteSuperadmin = () => {
    if (itemToDelete.value) {
        router.delete(route('superadmin.superadmins.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                itemToDelete.value = null;
            },
        });
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="t('Superadmins')" />

        <template #header>
            <h2 class="text-xl font-bold text-gray-800">{{ t('Superadmins') }}</h2>
        </template>

        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-gray-500">{{ superadmins.data?.length || 0 }} {{ t('Superadmins').toLowerCase() }}</p>
            <Link :href="route('superadmin.superadmins.create')">
                <ButtonPrimary>+ {{ t('Create') }} Superadmin</ButtonPrimary>
            </Link>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Email') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="sa in superadmins.data" :key="sa.id" class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-semibold shrink-0">
                                    {{ sa.name?.charAt(0)?.toUpperCase() }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ sa.name }}</p>
                                    <p v-if="sa.id === currentUserId" class="text-xs text-indigo-500 font-medium">( you )</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ sa.email }}</td>
                        <td class="px-6 py-4 text-right">
                            <ButtonDanger
                                v-if="sa.id !== currentUserId"
                                @click="confirmDelete(sa)"
                                class="text-xs"
                            >
                                {{ t('Delete') }}
                            </ButtonDanger>
                            <span v-else class="text-xs text-gray-400 italic">—</span>
                        </td>
                    </tr>
                    <tr v-if="!superadmins.data?.length">
                        <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-400">
                            {{ t('No results found') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <DeleteConfirmModal
            :show="showDeleteModal"
            :title="t('Delete') + ' Superadmin'"
            :message="t('Are you sure?') + ' ' + t('This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteSuperadmin"
        />
    </AuthenticatedLayout>
</template>
