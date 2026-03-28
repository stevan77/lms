<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :class="[
            'inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-lg',
            'bg-gradient-to-r from-red-600 to-rose-600',
            'hover:from-red-700 hover:to-rose-700',
            'focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2',
            'shadow-sm hover:shadow-md',
            'transition-all duration-200',
            (disabled || loading) ? 'opacity-60 cursor-not-allowed' : 'active:scale-[0.98]'
        ]"
    >
        <!-- Loading spinner -->
        <svg
            v-if="loading"
            class="w-4 h-4 animate-spin"
            fill="none"
            viewBox="0 0 24 24"
        >
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
        </svg>
        <slot />
    </button>
</template>
