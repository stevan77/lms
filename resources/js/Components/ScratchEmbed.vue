<script setup>
const props = defineProps({
    projectId: { type: String, default: '' },
    caption: { type: String, default: '' },
});
</script>

<template>
    <div v-if="projectId" class="my-4 rounded-xl border-2 border-amber-200 overflow-hidden shadow-sm">
        <!-- Header -->
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-2.5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.2 2C7.9 2 5.2 4.7 5.2 8c0 .7.1 1.4.3 2H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2h-1.5c.2-.6.3-1.3.3-2 0-3.3-2.7-6-6-6h-1.6zM9 8.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/>
                </svg>
                <span class="text-sm font-semibold text-white">Scratch projekat</span>
            </div>
            <a
                :href="`https://scratch.mit.edu/projects/${projectId}`"
                target="_blank"
                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-amber-100 hover:text-white hover:bg-white/10 rounded-md transition-colors"
            >
                Otvori u Scratch-u
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>

        <!-- Caption -->
        <div v-if="caption" class="px-4 py-2 bg-amber-50 border-b border-amber-100">
            <p class="text-sm text-amber-800">{{ caption }}</p>
        </div>

        <!-- Embed -->
        <div class="bg-white flex justify-center p-3">
            <iframe
                :src="`https://scratch.mit.edu/projects/${projectId}/embed`"
                allowtransparency="true"
                width="485"
                height="402"
                frameborder="0"
                scrolling="no"
                allowfullscreen
                class="rounded-lg border border-gray-100"
                style="max-width: 100%;"
            />
        </div>
    </div>
</template>
