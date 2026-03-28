<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
    rows: {
        type: [String, Number],
        default: 4,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const inputValue = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val),
});
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1.5">
            {{ label }}
        </label>
        <textarea
            v-model="inputValue"
            :placeholder="placeholder"
            :rows="rows"
            :disabled="disabled"
            :class="[
                'block w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-y',
                'transition-all duration-200 outline-none',
                'focus:ring-2 focus:ring-offset-0',
                error
                    ? 'border-red-300 focus:border-red-400 focus:ring-red-200'
                    : 'border-gray-200 focus:border-indigo-400 focus:ring-indigo-200',
                disabled ? 'bg-gray-50 cursor-not-allowed opacity-60' : 'bg-white'
            ]"
        />
        <p v-if="error" class="mt-1.5 text-xs text-red-500 font-medium">{{ error }}</p>
    </div>
</template>
