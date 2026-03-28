<script setup>
import { ref, watch, onBeforeUnmount } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TextAlign from '@tiptap/extension-text-align';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import Placeholder from '@tiptap/extension-placeholder';
import Highlight from '@tiptap/extension-highlight';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import { TextStyle } from '@tiptap/extension-text-style';
import Color from '@tiptap/extension-color';
import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight';
import { Table } from '@tiptap/extension-table';
import { TableRow } from '@tiptap/extension-table';
import { TableCell } from '@tiptap/extension-table';
import { TableHeader } from '@tiptap/extension-table';
import { common, createLowlight } from 'lowlight';
import MathExtension from './MathExtension.js';
import CodeExerciseExtension from './CodeExerciseExtension.js';
import NotebookExtension from './NotebookExtension.js';
import ScratchExtension from './ScratchExtension.js';

const lowlight = createLowlight(common);

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: 'Start writing...' },
    error: { type: String, default: null },
});

const emit = defineEmits(['update:modelValue']);

const showLinkModal = ref(false);
const linkUrl = ref('');

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit.configure({
            codeBlock: false,
            heading: { levels: [1, 2, 3] },
            bold: true,
            italic: true,
            strike: true,
            link: false,
        }),
        Underline,
        Subscript,
        Superscript,
        TextStyle,
        Color,
        Highlight.configure({ multicolor: true }),
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
        Link.configure({ openOnClick: false }),
        Image.configure({ inline: false }),
        Placeholder.configure({ placeholder: props.placeholder }),
        CodeBlockLowlight.configure({ lowlight }),
        Table.configure({ resizable: true }),
        TableRow,
        TableCell,
        TableHeader,
        MathExtension,
        CodeExerciseExtension,
        NotebookExtension,
        ScratchExtension,
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
    },
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose max-w-none focus:outline-none min-h-[300px] px-4 py-3',
        },
    },
});

watch(() => props.modelValue, (val) => {
    if (editor.value && editor.value.getHTML() !== val) {
        editor.value.commands.setContent(val, false);
    }
});

onBeforeUnmount(() => {
    editor.value?.destroy();
});

const setLink = () => {
    if (linkUrl.value) {
        editor.value.chain().focus().extendMarkRange('link').setLink({ href: linkUrl.value }).run();
    } else {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
    }
    showLinkModal.value = false;
    linkUrl.value = '';
};

const openLinkModal = () => {
    linkUrl.value = editor.value.getAttributes('link').href || '';
    showLinkModal.value = true;
};

const addImage = () => {
    const url = window.prompt('Image URL:');
    if (url) {
        editor.value.chain().focus().setImage({ src: url }).run();
    }
};

const insertTable = () => {
    editor.value.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run();
};

const insertMath = () => {
    editor.value.chain().focus().insertMath({ latex: '', display: 'block' }).run();
};

const insertScratch = () => {
    editor.value.chain().focus().insertScratchEmbed({ projectId: '', caption: '' }).run();
};

const insertNotebook = () => {
    editor.value.chain().focus().insertNotebook({
        cells: JSON.stringify([
            { type: 'markdown', content: '# Notebook naslov\nOpis zadatka ili objašnjenje...', editable: false },
            { type: 'code', content: '# Primer koda\nprint("Hello, World!")\n', editable: false },
            { type: 'markdown', content: '**Tvoj zadatak:** Dopuni kod ispod.', editable: false },
            { type: 'code', content: '# Tvoj kod ovde\n\n', editable: true },
        ]),
    }).run();
};

const insertCodeExercise = () => {
    editor.value.chain().focus().insertCodeExercise({
        starterCode: '# Write your code here\n\n',
        language: 'python',
        instructions: '',
    }).run();
};

const isActive = (name, attrs = {}) => editor.value?.isActive(name, attrs);
</script>

<template>
    <div>
        <div
            :class="[
                'rounded-xl border overflow-hidden transition-all duration-200',
                error ? 'border-red-300 ring-2 ring-red-100' : 'border-gray-300 focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-100'
            ]"
        >
            <!-- Toolbar -->
            <div v-if="editor" class="bg-gray-50 border-b border-gray-200 px-2 py-1.5 flex flex-wrap items-center gap-0.5">
                <!-- Text formatting -->
                <div class="flex items-center gap-0.5 pr-2 border-r border-gray-200">
                    <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="['toolbar-btn', { active: isActive('bold') }]" title="Bold">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="['toolbar-btn', { active: isActive('italic') }]" title="Italic">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 4h-9M14 20H5M15 4L9 20"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleUnderline().run()" :class="['toolbar-btn', { active: isActive('underline') }]" title="Underline">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 3v7a6 6 0 006 6 6 6 0 006-6V3M4 21h16"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleStrike().run()" :class="['toolbar-btn', { active: isActive('strike') }]" title="Strikethrough">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 4H9a3 3 0 00-3 3v0a3 3 0 003 3h6a3 3 0 013 3v0a3 3 0 01-3 3H6M4 12h16"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleSubscript().run()" :class="['toolbar-btn', { active: isActive('subscript') }]" title="Subscript">
                        <span class="text-xs font-bold">X<sub class="text-[9px]">2</sub></span>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleSuperscript().run()" :class="['toolbar-btn', { active: isActive('superscript') }]" title="Superscript">
                        <span class="text-xs font-bold">X<sup class="text-[9px]">2</sup></span>
                    </button>
                </div>

                <!-- Headings -->
                <div class="flex items-center gap-0.5 px-2 border-r border-gray-200">
                    <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="['toolbar-btn', { active: isActive('heading', { level: 1 }) }]" title="Heading 1">
                        <span class="text-xs font-bold">H1</span>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="['toolbar-btn', { active: isActive('heading', { level: 2 }) }]" title="Heading 2">
                        <span class="text-xs font-bold">H2</span>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="['toolbar-btn', { active: isActive('heading', { level: 3 }) }]" title="Heading 3">
                        <span class="text-xs font-bold">H3</span>
                    </button>
                </div>

                <!-- Alignment -->
                <div class="flex items-center gap-0.5 px-2 border-r border-gray-200">
                    <button type="button" @click="editor.chain().focus().setTextAlign('left').run()" :class="['toolbar-btn', { active: isActive({ textAlign: 'left' }) }]" title="Align left">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h12M3 18h18"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().setTextAlign('center').run()" :class="['toolbar-btn', { active: isActive({ textAlign: 'center' }) }]" title="Align center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6h18M6 12h12M3 18h18"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().setTextAlign('right').run()" :class="['toolbar-btn', { active: isActive({ textAlign: 'right' }) }]" title="Align right">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6h18M9 12h12M3 18h18"/></svg>
                    </button>
                </div>

                <!-- Lists -->
                <div class="flex items-center gap-0.5 px-2 border-r border-gray-200">
                    <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="['toolbar-btn', { active: isActive('bulletList') }]" title="Bullet list">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="['toolbar-btn', { active: isActive('orderedList') }]" title="Numbered list">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 6h11M10 12h11M10 18h11M4 6h1v4M4 10h2M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleBlockquote().run()" :class="['toolbar-btn', { active: isActive('blockquote') }]" title="Quote">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3z"/></svg>
                    </button>
                </div>

                <!-- Special -->
                <div class="flex items-center gap-0.5 px-2 border-r border-gray-200">
                    <button type="button" @click="editor.chain().focus().toggleCodeBlock().run()" :class="['toolbar-btn', { active: isActive('codeBlock') }]" title="Code block">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
                    </button>
                    <button type="button" @click="openLinkModal" :class="['toolbar-btn', { active: isActive('link') }]" title="Link">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                    </button>
                    <button type="button" @click="addImage" class="toolbar-btn" title="Image">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M2.25 18V6a2.25 2.25 0 012.25-2.25h15A2.25 2.25 0 0121.75 6v12A2.25 2.25 0 0119.5 20.25h-15A2.25 2.25 0 012.25 18z"/></svg>
                    </button>
                    <button type="button" @click="insertTable" class="toolbar-btn" title="Table">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M10.875 12c-.621 0-1.125.504-1.125 1.125M12 12c.621 0 1.125.504 1.125 1.125m0-1.125V12m-2.25 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5"/></svg>
                    </button>
                </div>

                <!-- Math / LaTeX / Code -->
                <div class="flex items-center gap-0.5 px-2">
                    <button type="button" @click="insertMath" class="toolbar-btn group" title="Insert LaTeX formula">
                        <span class="text-xs font-bold text-indigo-600 group-hover:text-indigo-700">∑ LaTeX</span>
                    </button>
                    <button type="button" @click="insertCodeExercise" class="toolbar-btn group" title="Insert Python exercise">
                        <span class="text-xs font-bold text-emerald-600 group-hover:text-emerald-700">&#x3E;_ Python</span>
                    </button>
                    <button type="button" @click="insertNotebook" class="toolbar-btn group" title="Insert Jupyter notebook">
                        <span class="text-xs font-bold text-orange-600 group-hover:text-orange-700">Jupyter</span>
                    </button>
                    <button type="button" @click="insertScratch" class="toolbar-btn group" title="Insert Scratch embed">
                        <span class="text-xs font-bold text-amber-600 group-hover:text-amber-700">Scratch</span>
                    </button>
                    <button type="button" @click="editor.chain().focus().toggleHighlight({ color: '#fef08a' }).run()" :class="['toolbar-btn', { active: isActive('highlight') }]" title="Highlight">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
                    </button>
                </div>

                <!-- Undo/Redo -->
                <div class="flex items-center gap-0.5 ml-auto">
                    <button type="button" @click="editor.chain().focus().undo().run()" class="toolbar-btn" :disabled="!editor.can().undo()" title="Undo">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                    </button>
                    <button type="button" @click="editor.chain().focus().redo().run()" class="toolbar-btn" :disabled="!editor.can().redo()" title="Redo">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Editor content -->
            <EditorContent :editor="editor" />
        </div>

        <!-- Error message -->
        <p v-if="error" class="mt-1.5 text-sm text-red-500">{{ error }}</p>

        <!-- Link modal -->
        <Teleport to="body">
            <div v-if="showLinkModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showLinkModal = false">
                <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Insert Link</h3>
                    <input
                        v-model="linkUrl"
                        type="url"
                        placeholder="https://example.com"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        @keydown.enter="setLink"
                        autofocus
                    />
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="showLinkModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                        <button type="button" @click="setLink" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Apply</button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<style>
.toolbar-btn {
    @apply p-1.5 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-200 transition-colors disabled:opacity-30 disabled:cursor-not-allowed;
}
.toolbar-btn.active {
    @apply bg-indigo-100 text-indigo-700;
}

/* TipTap editor styles */
.tiptap {
    @apply focus:outline-none;
}
.tiptap h1 { @apply text-2xl font-bold mb-3 mt-4; }
.tiptap h2 { @apply text-xl font-bold mb-2 mt-3; }
.tiptap h3 { @apply text-lg font-semibold mb-2 mt-3; }
.tiptap p { @apply mb-2; }
.tiptap ul { @apply list-disc pl-6 mb-3; }
.tiptap ol { @apply list-decimal pl-6 mb-3; }
.tiptap li { @apply mb-1; }
.tiptap blockquote { @apply border-l-4 border-indigo-300 pl-4 italic text-gray-600 my-3; }
.tiptap pre { @apply bg-gray-900 text-gray-100 rounded-lg p-4 my-3 overflow-x-auto text-sm font-mono; }
.tiptap code { @apply bg-gray-100 text-pink-600 px-1.5 py-0.5 rounded text-sm font-mono; }
.tiptap pre code { @apply bg-transparent text-inherit p-0; }
.tiptap a { @apply text-indigo-600 underline hover:text-indigo-800; }
.tiptap img { @apply rounded-lg max-w-full my-3; }
.tiptap mark { @apply bg-yellow-200 px-0.5 rounded; }
.tiptap hr { @apply my-4 border-gray-200; }

/* Table styles */
.tiptap table { @apply border-collapse w-full my-3 rounded-lg overflow-hidden; }
.tiptap th { @apply bg-gray-100 border border-gray-300 px-3 py-2 text-left font-semibold text-sm; }
.tiptap td { @apply border border-gray-300 px-3 py-2 text-sm; }

/* Placeholder */
.tiptap p.is-editor-empty:first-child::before {
    @apply text-gray-400 float-left pointer-events-none h-0;
    content: attr(data-placeholder);
}
</style>
