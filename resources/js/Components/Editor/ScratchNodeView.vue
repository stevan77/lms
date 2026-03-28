<script setup>
import { ref } from 'vue';
import { NodeViewWrapper } from '@tiptap/vue-3';

const props = defineProps({
    node: Object,
    updateAttributes: Function,
    selected: Boolean,
});

const editingId = ref(false);
const editingCaption = ref(false);
const idInput = ref(null);
const captionInput = ref(null);

const startEditingId = () => {
    editingId.value = true;
    setTimeout(() => idInput.value?.focus(), 50);
};

const stopEditingId = () => {
    editingId.value = false;
};

const onIdInput = (e) => {
    // Extract project ID from URL or plain number
    let val = e.target.value.trim();
    const match = val.match(/scratch\.mit\.edu\/projects\/(\d+)/);
    if (match) val = match[1];
    props.updateAttributes({ projectId: val });
};

const startEditingCaption = () => {
    editingCaption.value = true;
    setTimeout(() => captionInput.value?.focus(), 50);
};

const stopEditingCaption = () => {
    editingCaption.value = false;
};

const onCaptionInput = (e) => {
    props.updateAttributes({ caption: e.target.value });
};
</script>

<template>
    <NodeViewWrapper class="my-4">
        <div
            :class="[
                'rounded-xl border-2 overflow-hidden transition-all duration-200',
                selected ? 'border-amber-400 shadow-lg shadow-amber-100' : 'border-gray-200 hover:border-amber-300',
            ]"
        >
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.2 2C7.9 2 5.2 4.7 5.2 8c0 .7.1 1.4.3 2H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2h-1.5c.2-.6.3-1.3.3-2 0-3.3-2.7-6-6-6h-1.6zM9 8.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-white">Scratch projekat</span>
                </div>
            </div>

            <!-- Project ID -->
            <div class="bg-amber-50 border-b border-amber-100 px-4 py-2">
                <div v-if="!editingId" @click="startEditingId" class="cursor-pointer">
                    <p v-if="node.attrs.projectId" class="text-sm text-amber-800">
                        <span class="font-semibold">Projekat ID:</span> {{ node.attrs.projectId }}
                    </p>
                    <p v-else class="text-sm text-amber-400 italic">Klikni da dodas Scratch projekat (ID ili URL)...</p>
                </div>
                <input
                    v-else
                    ref="idInput"
                    :value="node.attrs.projectId"
                    @input="onIdInput"
                    @blur="stopEditingId"
                    @keydown.enter="stopEditingId"
                    @keydown.escape="stopEditingId"
                    placeholder="ID projekta ili scratch.mit.edu URL..."
                    class="w-full px-2 py-1 text-sm border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 bg-white"
                />
            </div>

            <!-- Caption -->
            <div class="bg-amber-50/50 border-b border-amber-100 px-4 py-1.5">
                <div v-if="!editingCaption" @click="startEditingCaption" class="cursor-pointer">
                    <p v-if="node.attrs.caption" class="text-sm text-amber-700">{{ node.attrs.caption }}</p>
                    <p v-else class="text-xs text-amber-300 italic">Klikni za opis projekta...</p>
                </div>
                <input
                    v-else
                    ref="captionInput"
                    :value="node.attrs.caption"
                    @input="onCaptionInput"
                    @blur="stopEditingCaption"
                    @keydown.enter="stopEditingCaption"
                    @keydown.escape="stopEditingCaption"
                    placeholder="Opis projekta..."
                    class="w-full px-2 py-1 text-sm border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 bg-white"
                />
            </div>

            <!-- Preview -->
            <div class="bg-white p-4">
                <div v-if="node.attrs.projectId" class="rounded-lg overflow-hidden border border-gray-200">
                    <iframe
                        :src="`https://scratch.mit.edu/projects/${node.attrs.projectId}/embed`"
                        allowtransparency="true"
                        width="485"
                        height="402"
                        frameborder="0"
                        scrolling="no"
                        allowfullscreen
                        class="w-full"
                        style="max-width: 485px;"
                    />
                </div>
                <div v-else class="flex items-center justify-center h-40 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200 text-gray-400 text-sm">
                    Unesi Scratch projekat ID iznad da vidis preview
                </div>
            </div>
        </div>
    </NodeViewWrapper>
</template>
