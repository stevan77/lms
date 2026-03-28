<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { NodeViewWrapper } from '@tiptap/vue-3';
import { EditorView, basicSetup } from 'codemirror';
import { python } from '@codemirror/lang-python';
// light theme
import { EditorState } from '@codemirror/state';

const props = defineProps({
    node: Object,
    updateAttributes: Function,
    selected: Boolean,
});

const editorContainer = ref(null);
const instructionsInput = ref(null);
const editingInstructions = ref(false);
let editorView = null;

onMounted(() => {
    const state = EditorState.create({
        doc: props.node.attrs.starterCode || '# Write your code here\n\n',
        extensions: [
            basicSetup,
            python(),
            EditorView.updateListener.of((update) => {
                if (update.docChanged) {
                    props.updateAttributes({ starterCode: update.state.doc.toString() });
                }
            }),
            EditorView.theme({
                '&': { fontSize: '13px', borderRadius: '0 0 12px 12px' },
                '.cm-content': { padding: '12px 0' },
                '.cm-gutters': { borderRadius: '0 0 0 12px' },
            }),
        ],
    });

    editorView = new EditorView({
        state,
        parent: editorContainer.value,
    });
});

onBeforeUnmount(() => {
    editorView?.destroy();
});

const startEditingInstructions = () => {
    editingInstructions.value = true;
    setTimeout(() => instructionsInput.value?.focus(), 50);
};

const stopEditingInstructions = () => {
    editingInstructions.value = false;
};

const onInstructionsInput = (e) => {
    props.updateAttributes({ instructions: e.target.value });
};
</script>

<template>
    <NodeViewWrapper class="my-4">
        <div
            :class="[
                'rounded-xl border-2 overflow-hidden transition-all duration-200',
                selected ? 'border-emerald-400 shadow-lg shadow-emerald-100' : 'border-gray-200 hover:border-emerald-300',
            ]"
        >
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                    <span class="text-sm font-semibold text-white">Python</span>
                </div>
                <span class="text-xs text-emerald-200">Starter Code</span>
            </div>

            <!-- Instructions -->
            <div class="bg-emerald-50 border-b border-emerald-100 px-4 py-2">
                <div v-if="!editingInstructions" @click="startEditingInstructions" class="cursor-pointer">
                    <p v-if="node.attrs.instructions" class="text-sm text-emerald-800">
                        <span class="font-semibold">Task:</span> {{ node.attrs.instructions }}
                    </p>
                    <p v-else class="text-sm text-emerald-400 italic">Click to add task instructions...</p>
                </div>
                <textarea
                    v-else
                    ref="instructionsInput"
                    :value="node.attrs.instructions"
                    @input="onInstructionsInput"
                    @blur="stopEditingInstructions"
                    @keydown.escape="stopEditingInstructions"
                    placeholder="Describe what the student should do..."
                    class="w-full px-2 py-1 text-sm border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none bg-white"
                    rows="2"
                />
            </div>

            <!-- Code Editor -->
            <div ref="editorContainer" class="code-exercise-editor" />
        </div>
    </NodeViewWrapper>
</template>

<style>
.code-exercise-editor .cm-editor {
    max-height: 400px;
}
.code-exercise-editor .cm-scroller {
    overflow: auto;
}
</style>
