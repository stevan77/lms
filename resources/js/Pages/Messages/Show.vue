<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const showDeleteModal = ref(false);

const deleteMessage = () => {
    router.delete(route('messages.destroy', props.message.id));
};

const props = defineProps({
    message: Object,
    readReceipts: Array,
});

const formatDate = (date) => new Date(date).toLocaleString();

const linkify = (text) => {
    if (!text) return '';
    return text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" class="text-indigo-600 hover:text-indigo-800 underline font-medium">$1</a>');
};
</script>

<template>
    <Head :title="message.subject" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link :href="route('messages.inbox')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </Link>
                <h1 class="text-2xl font-bold text-gray-900">{{ message.subject }}</h1>
            </div>
        </template>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-11 h-11 rounded-full text-white text-sm font-semibold shrink-0"
                            :class="message.sender?.role === 'teacher' ? 'bg-gradient-to-br from-indigo-500 to-purple-600' : 'bg-gradient-to-br from-emerald-500 to-teal-600'"
                        >
                            {{ message.sender?.name?.charAt(0)?.toUpperCase() }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-semibold text-gray-900">{{ message.sender?.name }}</p>
                                <span class="text-xs text-gray-400 capitalize">{{ message.sender?.role }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span v-if="message.is_broadcast" class="inline-flex items-center gap-1 text-xs text-purple-600">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72" />
                                    </svg>
                                    {{ t('To') }}: {{ message.grade?.name || t('All students') }}
                                </span>
                                <span v-else class="text-xs text-gray-500">
                                    {{ t('To') }}: {{ message.recipient?.name }}
                                </span>
                                <span class="text-xs text-gray-400">{{ formatDate(message.created_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-5">
                    <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-wrap" v-html="linkify(message.body)"></div>
                </div>

                <!-- Read receipts (teacher only) -->
                <div v-if="readReceipts?.length" class="px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            {{ t('Read status') }}
                            <span class="text-gray-400 normal-case font-normal">
                                ({{ readReceipts.filter(r => r.read_at).length }}/{{ readReceipts.length }})
                            </span>
                        </span>
                    </div>
                    <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ t('Student') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ t('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                <tr v-for="r in readReceipts" :key="r.id" class="hover:bg-gray-50/50">
                                    <td class="px-4 py-2.5">
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-[10px] font-semibold shrink-0">
                                                {{ r.name?.charAt(0)?.toUpperCase() }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ r.name }}</p>
                                                <p class="text-xs text-gray-400">{{ r.email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <span v-if="r.read_at" class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ formatDate(r.read_at) }}
                                        </span>
                                        <span v-else class="inline-flex items-center gap-1 text-xs text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ t('Not seen') }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
                    <Link :href="route('messages.create', { reply_to: message.id, recipient: message.sender?.id, subject: message.subject })">
                        <ButtonSecondary>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            {{ t('Reply') }}
                        </ButtonSecondary>
                    </Link>
                    <Link :href="route('messages.inbox')" class="text-sm text-gray-500 hover:text-gray-700">
                        {{ t('Back to Inbox') }}
                    </Link>
                    <ButtonDanger @click="showDeleteModal = true" class="ml-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79" />
                        </svg>
                        {{ t('Delete') }}
                    </ButtonDanger>
                </div>
            </div>
        </div>
        <DeleteConfirmModal
            :show="showDeleteModal"
            :title="t('Delete') + ' ' + t('Message')"
            :message="t('Are you sure?') + ' ' + t('This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteMessage"
        />
    </AuthenticatedLayout>
</template>
