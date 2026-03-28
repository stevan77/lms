<script setup>
import Modal from '@/Components/Modal.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: 'Confirm Deletion',
    },
    message: {
        type: String,
        default: 'Are you sure you want to delete this item? This action cannot be undone.',
    },
});

const emit = defineEmits(['close', 'confirm']);
</script>

<template>
    <Modal :show="show" max-width="sm" @close="emit('close')">
        <div class="p-6">
            <!-- Warning icon -->
            <div class="flex items-center justify-center w-14 h-14 mx-auto rounded-full bg-red-100 mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>

            <!-- Content -->
            <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">{{ title }}</h3>
            <p class="text-sm text-gray-500 text-center mb-6">{{ message }}</p>

            <!-- Actions -->
            <div class="flex gap-3 justify-end">
                <ButtonSecondary @click="emit('close')">
                    {{ t('Cancel') }}
                </ButtonSecondary>
                <ButtonDanger @click="emit('confirm')">
                    {{ t('Delete') }}
                </ButtonDanger>
            </div>
        </div>
    </Modal>
</template>
