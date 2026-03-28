<script setup>
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    columns: {
        type: Array,
        required: true,
        // Each column: { key: string, label: string }
    },
    rows: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th
                            v-for="col in columns"
                            :key="col.key"
                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider"
                        >
                            {{ col.label }}
                        </th>
                        <th
                            v-if="$slots.actions"
                            class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider"
                        >
                            {{ t('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr
                        v-for="(row, index) in rows"
                        :key="row.id || index"
                        class="hover:bg-gray-50/50 transition-colors duration-150"
                        :class="index % 2 === 1 ? 'bg-gray-50/30' : ''"
                    >
                        <td
                            v-for="col in columns"
                            :key="col.key"
                            class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap"
                        >
                            <slot :name="'cell-' + col.key" :row="row" :value="row[col.key]">
                                {{ row[col.key] }}
                            </slot>
                        </td>
                        <td
                            v-if="$slots.actions"
                            class="px-6 py-4 text-right text-sm whitespace-nowrap"
                        >
                            <slot name="actions" :row="row" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Empty state -->
        <div
            v-if="rows.length === 0"
            class="flex flex-col items-center justify-center py-12 px-4"
        >
            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p class="text-sm text-gray-400 font-medium">{{ t('No data available') }}</p>
        </div>
    </div>
</template>
