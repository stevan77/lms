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
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        :class="[
            'inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg',
            'text-gray-700 bg-white border border-gray-200',
            'hover:bg-gray-50 hover:border-gray-300',
            'focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2',
            'shadow-sm',
            'transition-all duration-200',
            disabled ? 'opacity-60 cursor-not-allowed' : 'active:scale-[0.98]'
        ]"
    >
        <slot />
    </button>
</template>
