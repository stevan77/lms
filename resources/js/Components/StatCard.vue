<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    color: {
        type: String,
        default: 'indigo',
    },
});

const colorClasses = computed(() => {
    const colors = {
        indigo: {
            border: 'from-indigo-500 to-indigo-600',
            iconBg: 'bg-indigo-100',
            iconText: 'text-indigo-600',
        },
        emerald: {
            border: 'from-emerald-500 to-emerald-600',
            iconBg: 'bg-emerald-100',
            iconText: 'text-emerald-600',
        },
        amber: {
            border: 'from-amber-500 to-amber-600',
            iconBg: 'bg-amber-100',
            iconText: 'text-amber-600',
        },
        rose: {
            border: 'from-rose-500 to-rose-600',
            iconBg: 'bg-rose-100',
            iconText: 'text-rose-600',
        },
        purple: {
            border: 'from-purple-500 to-purple-600',
            iconBg: 'bg-purple-100',
            iconText: 'text-purple-600',
        },
        sky: {
            border: 'from-sky-500 to-sky-600',
            iconBg: 'bg-sky-100',
            iconText: 'text-sky-600',
        },
    };
    return colors[props.color] || colors.indigo;
});
</script>

<template>
    <div class="relative bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
        <!-- Gradient top border -->
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r" :class="colorClasses.border" />

        <div class="p-6 pt-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ value }}</p>
                    <p class="mt-1 text-sm font-medium text-gray-500">{{ title }}</p>
                </div>
                <div
                    class="flex items-center justify-center w-12 h-12 rounded-xl"
                    :class="[colorClasses.iconBg, colorClasses.iconText]"
                >
                    <slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>
