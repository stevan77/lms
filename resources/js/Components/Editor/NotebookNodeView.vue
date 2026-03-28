<script setup>
import { ref, computed, onMounted, nextTick, onBeforeUnmount } from 'vue';
import { NodeViewWrapper } from '@tiptap/vue-3';
import { EditorView, basicSetup } from 'codemirror';
import { python } from '@codemirror/lang-python';
import { EditorState } from '@codemirror/state';

const props = defineProps({
    node: Object,
    updateAttributes: Function,
    selected: Boolean,
});

const cells = ref([]);
const editors = {};
const editorRefs = ref({});

const parseCells = () => {
    try {
        cells.value = JSON.parse(props.node.attrs.cells || '[]');
    } catch {
        cells.value = [];
    }
};

const saveCells = () => {
    // Sync editor contents back
    cells.value.forEach((cell, i) => {
        if (cell.type === 'code' && editors[i]) {
            cell.content = editors[i].state.doc.toString();
        }
    });
    props.updateAttributes({ cells: JSON.stringify(cells.value) });
};

const mountEditor = (el, index) => {
    if (!el || editors[index]) return;
    const cell = cells.value[index];
    if (cell.type !== 'code') return;

    const state = EditorState.create({
        doc: cell.content || '',
        extensions: [
            basicSetup,
            python(),
            EditorView.updateListener.of((update) => {
                if (update.docChanged) {
                    cells.value[index].content = update.state.doc.toString();
                    saveCells();
                }
            }),
            EditorView.theme({
                '&': { fontSize: '13px' },
                '.cm-content': { padding: '8px 0', fontFamily: "'JetBrains Mono', 'Fira Code', monospace" },
            }),
        ],
    });

    editors[index] = new EditorView({ state, parent: el });
};

const setEditorRef = (el, index) => {
    if (el) {
        editorRefs.value[index] = el;
        nextTick(() => mountEditor(el, index));
    }
};

onMounted(() => {
    parseCells();
});

onBeforeUnmount(() => {
    Object.values(editors).forEach(e => e?.destroy());
});

const addCell = (type) => {
    cells.value.push({
        type,
        content: type === 'code' ? '# code\n' : 'Text...',
        editable: true,
    });
    saveCells();
    nextTick(() => {
        const idx = cells.value.length - 1;
        if (type === 'code' && editorRefs.value[idx]) {
            mountEditor(editorRefs.value[idx], idx);
        }
    });
};

const removeCell = (index) => {
    if (editors[index]) {
        editors[index].destroy();
        delete editors[index];
    }
    cells.value.splice(index, 1);
    saveCells();
};

const moveCell = (index, dir) => {
    const newIndex = index + dir;
    if (newIndex < 0 || newIndex >= cells.value.length) return;

    // Destroy editors being moved
    [index, newIndex].forEach(i => {
        if (editors[i]) { editors[i].destroy(); delete editors[i]; }
    });

    const temp = cells.value[index];
    cells.value[index] = cells.value[newIndex];
    cells.value[newIndex] = temp;
    saveCells();

    // Remount
    nextTick(() => {
        [index, newIndex].forEach(i => {
            if (cells.value[i].type === 'code' && editorRefs.value[i]) {
                mountEditor(editorRefs.value[i], i);
            }
        });
    });
};

const toggleEditable = (index) => {
    cells.value[index].editable = !cells.value[index].editable;
    saveCells();
};

const updateMarkdown = (index, event) => {
    cells.value[index].content = event.target.value;
    saveCells();
};
</script>

<template>
    <NodeViewWrapper class="my-4">
        <div
            :class="[
                'rounded-xl border-2 overflow-hidden transition-all duration-200',
                selected ? 'border-orange-400 shadow-lg shadow-orange-100' : 'border-gray-200 hover:border-orange-300',
            ]"
        >
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-4 py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span class="text-sm font-semibold text-white">Jupyter Notebook</span>
                </div>
                <div class="flex items-center gap-1">
                    <button
                        @click="addCell('markdown')"
                        class="px-2 py-1 text-[10px] font-medium text-orange-100 hover:text-white hover:bg-white/10 rounded transition-colors"
                    >+ Markdown</button>
                    <button
                        @click="addCell('code')"
                        class="px-2 py-1 text-[10px] font-medium text-orange-100 hover:text-white hover:bg-white/10 rounded transition-colors"
                    >+ Code</button>
                </div>
            </div>

            <!-- Cells -->
            <div class="divide-y divide-gray-100">
                <div v-for="(cell, i) in cells" :key="i" class="group relative">
                    <!-- Cell toolbar -->
                    <div class="absolute right-2 top-1 z-10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-0.5">
                        <button
                            @click="toggleEditable(i)"
                            :class="['p-1 rounded text-[10px]', cell.editable ? 'text-emerald-600 bg-emerald-50' : 'text-gray-400 bg-gray-50']"
                            :title="cell.editable ? 'Editable by student' : 'Read-only for student'"
                        >
                            {{ cell.editable ? '✏️' : '🔒' }}
                        </button>
                        <button @click="moveCell(i, -1)" class="p-1 rounded text-gray-400 hover:text-gray-700 hover:bg-gray-100" :disabled="i === 0">↑</button>
                        <button @click="moveCell(i, 1)" class="p-1 rounded text-gray-400 hover:text-gray-700 hover:bg-gray-100" :disabled="i === cells.length - 1">↓</button>
                        <button @click="removeCell(i)" class="p-1 rounded text-red-400 hover:text-red-600 hover:bg-red-50">✕</button>
                    </div>

                    <!-- Cell type badge -->
                    <div class="flex items-center gap-2 px-3 pt-2 pb-1">
                        <span
                            :class="[
                                'inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider',
                                cell.type === 'code' ? 'text-blue-600 bg-blue-50' : 'text-purple-600 bg-purple-50'
                            ]"
                        >
                            {{ cell.type === 'code' ? 'In [' + (i + 1) + ']:' : 'Markdown' }}
                        </span>
                        <span
                            :class="[
                                'inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium',
                                cell.editable ? 'text-emerald-600 bg-emerald-50' : 'text-gray-500 bg-gray-100'
                            ]"
                        >
                            {{ cell.editable ? 'Student can edit' : 'Read-only' }}
                        </span>
                    </div>

                    <!-- Code cell -->
                    <div v-if="cell.type === 'code'" class="px-3 pb-3">
                        <div :ref="(el) => setEditorRef(el, i)" class="notebook-cell-editor rounded-lg overflow-hidden border border-gray-200" />
                    </div>

                    <!-- Markdown cell -->
                    <div v-else class="px-3 pb-3">
                        <textarea
                            :value="cell.content"
                            @input="updateMarkdown(i, $event)"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-y font-mono"
                            rows="3"
                            :placeholder="'Markdown content...'"
                        />
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div v-if="cells.length === 0" class="p-8 text-center text-sm text-gray-400">
                Add cells using the buttons above
            </div>
        </div>
    </NodeViewWrapper>
</template>

<style>
.notebook-cell-editor .cm-editor {
    max-height: 300px;
}
.notebook-cell-editor .cm-scroller {
    overflow: auto;
}
</style>
