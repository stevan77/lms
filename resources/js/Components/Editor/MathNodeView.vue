<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue';
import { NodeViewWrapper } from '@tiptap/vue-3';
import katex from 'katex';

const props = defineProps({
    node: Object,
    updateAttributes: Function,
    selected: Boolean,
});

const editing = ref(false);
const inputRef = ref(null);
const latex = computed(() => props.node.attrs.latex || '');

const renderLatex = (input) => {
    // Split on \[ ... \] or $$ ... $$ delimiters to handle mixed text+math
    // If no delimiters found, treat entire input as math
    const hasDelimiters = /\\\[[\s\S]*?\\\]|\$\$[\s\S]*?\$\$/.test(input);

    if (!hasDelimiters) {
        return katex.renderToString(input, {
            displayMode: true,
            throwOnError: false,
            strict: false,
            trust: true,
            macros: {
                '\\textbf': '\\mathbf',
            },
        });
    }

    // Mixed mode: render text parts as HTML, math parts via KaTeX
    return input.replace(
        /\\\[([\s\S]*?)\\\]|\$\$([\s\S]*?)\$\$/g,
        (match, g1, g2) => {
            const formula = g1 || g2;
            return katex.renderToString(formula.trim(), {
                displayMode: true,
                throwOnError: false,
                strict: false,
                trust: true,
            });
        }
    ).replace(/\\textbf\{([^}]*)\}/g, '<strong>$1</strong>')
     .replace(/\\textit\{([^}]*)\}/g, '<em>$1</em>')
     .replace(/\n/g, '<br/>');
};

const renderedHtml = computed(() => {
    if (!latex.value) return '<span class="text-gray-400 italic">Click to add formula...</span>';
    try {
        return renderLatex(latex.value);
    } catch {
        return `<span class="text-red-500">Invalid LaTeX</span>`;
    }
});

const startEditing = () => {
    editing.value = true;
    nextTick(() => inputRef.value?.focus());
};

const stopEditing = () => {
    editing.value = false;
};

const onInput = (e) => {
    props.updateAttributes({ latex: e.target.value });
};
</script>

<template>
    <NodeViewWrapper class="my-4">
        <div
            :class="[
                'rounded-xl border-2 transition-all duration-200 overflow-hidden',
                selected ? 'border-indigo-400 shadow-lg shadow-indigo-100' : 'border-gray-200 hover:border-indigo-300',
                editing ? 'bg-slate-50' : 'bg-white'
            ]"
        >
            <!-- Rendered math -->
            <div
                v-if="!editing"
                @click="startEditing"
                class="p-4 cursor-pointer text-center min-h-[3rem] flex items-center justify-center"
                v-html="renderedHtml"
            />

            <!-- Editor -->
            <div v-else class="p-3 space-y-2">
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889" />
                    </svg>
                    LaTeX formula
                </div>
                <textarea
                    ref="inputRef"
                    :value="latex"
                    @input="onInput"
                    @blur="stopEditing"
                    @keydown.escape="stopEditing"
                    placeholder="Pure math: \frac{-b \pm \sqrt{b^2 - 4ac}}{2a}&#10;&#10;Or mixed text + math with \[ ... \] delimiters:&#10;\textbf{Rešenje:}&#10;\[ x = \frac{16}{5} \]"
                    class="w-full px-3 py-2 text-sm font-mono bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y"
                    rows="4"
                />
                <!-- Preview -->
                <div
                    v-if="latex"
                    class="p-3 bg-white rounded-lg border border-gray-100 text-center"
                    v-html="renderedHtml"
                />
            </div>
        </div>
    </NodeViewWrapper>
</template>
