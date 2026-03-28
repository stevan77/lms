<script setup>
import { computed } from 'vue';

const props = defineProps({
    percentage: {
        type: Number,
        default: 0,
    },
    color: {
        type: String,
        default: 'indigo',
    },
});

const clampedPercentage = computed(() => Math.min(100, Math.max(0, props.percentage)));

const barColorClass = computed(() => {
    const colors = {
        indigo: 'from-indigo-500 to-purple-500',
        emerald: 'from-emerald-500 to-teal-500',
        amber: 'from-amber-500 to-orange-500',
        rose: 'from-rose-500 to-pink-500',
        sky: 'from-sky-500 to-blue-500',
    };
    return colors[props.color] || colors.indigo;
});
</script>

<template>
    <div class="flex items-center gap-3">
        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
            <div
                class="h-full bg-gradient-to-r rounded-full transition-all duration-700 ease-out"
                :class="barColorClass"
                :style="{ width: clampedPercentage + '%' }"
            />
        </div>
        <span class="text-sm font-semibold text-gray-600 tabular-nums min-w-[3ch] text-right">
            {{ Math.round(clampedPercentage) }}%
        </span>
    </div>
</template>
