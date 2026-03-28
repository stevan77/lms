<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number, null],
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    options: {
        type: Array,
        default: () => [],
        // Each option: { value: string|number, label: string }
    },
    error: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Select an option...',
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
        <select
            v-model="inputValue"
            :disabled="disabled"
            :class="[
                'block w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900',
                'transition-all duration-200 outline-none appearance-none',
                'focus:ring-2 focus:ring-offset-0',
                'bg-[length:20px_20px] bg-[right_12px_center] bg-no-repeat',
                error
                    ? 'border-red-300 focus:border-red-400 focus:ring-red-200'
                    : 'border-gray-200 focus:border-indigo-400 focus:ring-indigo-200',
                disabled ? 'bg-gray-50 cursor-not-allowed opacity-60' : 'bg-white'
            ]"
            style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236b7280%22><path fill-rule=%22evenodd%22 d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22 clip-rule=%22evenodd%22/></svg>');"
        >
            <option value="" disabled>{{ placeholder }}</option>
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <p v-if="error" class="mt-1.5 text-xs text-red-500 font-medium">{{ error }}</p>
    </div>
</template>
