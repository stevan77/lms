<script setup>
import { ref, computed, onMounted, watch, nextTick } from 'vue';
import katex from 'katex';
import CodeExerciseRunner from './CodeExerciseRunner.vue';
import NotebookRunner from './NotebookRunner.vue';
import ScratchEmbed from './ScratchEmbed.vue';

const props = defineProps({
    content: { type: String, default: '' },
});

// Parse content into segments: html parts, code exercise blocks, and notebook blocks
const segments = computed(() => {
    if (!props.content) return [];

    const parts = [];
    // Match code-exercise and notebook blocks
    const regex = /<div[^>]*data-(code-exercise|notebook|scratch-embed)[^>]*><\/div>/g;
    let lastIndex = 0;
    let match;

    while ((match = regex.exec(props.content)) !== null) {
        // HTML before this block
        if (match.index > lastIndex) {
            parts.push({ type: 'html', content: props.content.slice(lastIndex, match.index) });
        }

        const tag = match[0];
        const blockType = match[1]; // 'code-exercise' or 'notebook'

        if (blockType === 'code-exercise') {
            const starterCode = extractAttr(tag, 'startercode') || extractAttr(tag, 'starterCode') || '';
            const instructions = extractAttr(tag, 'instructions') || '';
            parts.push({
                type: 'code-exercise',
                starterCode: decodeHtmlEntities(starterCode),
                instructions: decodeHtmlEntities(instructions),
            });
        } else if (blockType === 'notebook') {
            const cellsJson = extractAttr(tag, 'cells') || '[]';
            parts.push({
                type: 'notebook',
                cellsJson: decodeHtmlEntities(cellsJson),
            });
        } else if (blockType === 'scratch-embed') {
            const projectId = extractAttr(tag, 'projectid') || extractAttr(tag, 'projectId') || '';
            const caption = extractAttr(tag, 'caption') || '';
            parts.push({
                type: 'scratch-embed',
                projectId: decodeHtmlEntities(projectId),
                caption: decodeHtmlEntities(caption),
            });
        }

        lastIndex = match.index + match[0].length;
    }

    // Remaining HTML
    if (lastIndex < props.content.length) {
        parts.push({ type: 'html', content: props.content.slice(lastIndex) });
    }

    return parts;
});

function extractAttr(tag, name) {
    // Match both name="value" and name='value'
    const regex = new RegExp(`${name}="([^"]*)"`, 'i');
    const match = tag.match(regex);
    return match ? match[1] : '';
}

function decodeHtmlEntities(str) {
    const textarea = document.createElement('textarea');
    textarea.innerHTML = str;
    return textarea.value;
}

// Render KaTeX in html segments after mount
const htmlRefs = ref([]);

const renderKatex = (formula, displayMode = true) => {
    try {
        return katex.renderToString(formula.trim(), {
            displayMode,
            throwOnError: false,
            strict: false,
            trust: true,
        });
    } catch {
        return `<span class="text-red-500">Invalid: ${formula}</span>`;
    }
};

const renderMathInHtml = () => {
    htmlRefs.value.forEach((el) => {
        if (!el) return;

        // 1. Process data-math-block elements (editor-created math)
        const mathBlocks = el.querySelectorAll('div[data-math-block]');
        mathBlocks.forEach((block) => {
            const latex = block.getAttribute('latex') || '';
            if (!latex) return;

            const hasDelimiters = /\\\[[\s\S]*?\\\]/.test(latex);

            if (!hasDelimiters) {
                block.innerHTML = renderKatex(latex);
            } else {
                let html = latex;
                html = html.replace(/\\\[([\s\S]*?)\\\]/g, (m, f) => renderKatex(f));
                html = html.replace(/(?<!\$)\$(?!\$)(.+?)(?<!\$)\$(?!\$)/g, (m, f) => renderKatex(f, false));
                html = html.replace(/\\textbf\{([^}]*)\}/g, '<strong>$1</strong>');
                html = html.replace(/\\textit\{([^}]*)\}/g, '<em>$1</em>');
                html = html.replace(/\n/g, '<br/>');
                block.innerHTML = `<div class="math-content text-center py-2">${html}</div>`;
            }

            block.classList.add('my-4', 'p-4', 'bg-gradient-to-r', 'from-indigo-50/50', 'to-purple-50/50', 'rounded-xl', 'border', 'border-indigo-100');
        });

        // 2. Process raw \[...\], \(...\) and bare LaTeX in HTML content
        const mathPattern = /(\\\[[\s\S]*?\\\]|\\\([\s\S]*?\\\))/;
        const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT, null);
        const textNodes = [];
        let node;
        while ((node = walker.nextNode())) {
            if (node.parentElement?.closest('[data-math-block]')) continue;
            if (node.parentElement?.closest('.katex')) continue;
            if (mathPattern.test(node.textContent)) {
                textNodes.push(node);
            }
        }

        textNodes.forEach((textNode) => {
            const text = textNode.textContent;
            const parts = text.split(/(\\\[[\s\S]*?\\\]|\\\([\s\S]*?\\\))/);
            if (parts.length <= 1) return;

            const span = document.createElement('span');
            parts.forEach((part) => {
                const displayMatch = part.match(/^\\\[([\s\S]*?)\\\]$/);
                const inlineMatch = part.match(/^\\\(([\s\S]*?)\\\)$/);
                if (displayMatch) {
                    const mathSpan = document.createElement('span');
                    mathSpan.innerHTML = renderKatex(displayMatch[1]);
                    mathSpan.className = 'block-math my-2';
                    span.appendChild(mathSpan);
                } else if (inlineMatch) {
                    const mathSpan = document.createElement('span');
                    mathSpan.innerHTML = renderKatex(inlineMatch[1], false);
                    mathSpan.className = 'inline-math';
                    span.appendChild(mathSpan);
                } else if (part) {
                    span.appendChild(document.createTextNode(part));
                }
            });
            textNode.parentNode.replaceChild(span, textNode);
        });
    });
};

onMounted(() => nextTick(renderMathInHtml));
watch(() => props.content, () => nextTick(renderMathInHtml));

const setHtmlRef = (el, index) => {
    if (el) htmlRefs.value[index] = el;
};
</script>

<template>
    <div class="lesson-content">
        <template v-for="(segment, i) in segments" :key="i">
            <div
                v-if="segment.type === 'html'"
                :ref="(el) => setHtmlRef(el, i)"
                class="prose prose-sm sm:prose max-w-none text-gray-700"
                v-html="segment.content"
            />
            <CodeExerciseRunner
                v-else-if="segment.type === 'code-exercise'"
                :starter-code="segment.starterCode"
                :instructions="segment.instructions"
            />
            <NotebookRunner
                v-else-if="segment.type === 'notebook'"
                :cells-json="segment.cellsJson"
            />
            <ScratchEmbed
                v-else-if="segment.type === 'scratch-embed'"
                :project-id="segment.projectId"
                :caption="segment.caption"
            />
        </template>
    </div>
</template>

<style>
.lesson-content h1 { @apply text-2xl font-bold mb-3 mt-4; }
.lesson-content h2 { @apply text-xl font-bold mb-2 mt-3; }
.lesson-content h3 { @apply text-lg font-semibold mb-2 mt-3; }
.lesson-content p { @apply mb-2; }
.lesson-content ul { @apply list-disc pl-6 mb-3; }
.lesson-content ol { @apply list-decimal pl-6 mb-3; }
.lesson-content li { @apply mb-1; }
.lesson-content blockquote { @apply border-l-4 border-indigo-300 pl-4 italic text-gray-600 my-3; }
.lesson-content pre { @apply bg-gray-900 text-gray-100 rounded-lg p-4 my-3 overflow-x-auto text-sm font-mono; }
.lesson-content code { @apply bg-gray-100 text-pink-600 px-1.5 py-0.5 rounded text-sm font-mono; }
.lesson-content pre code { @apply bg-transparent text-inherit p-0; }
.lesson-content a { @apply text-indigo-600 underline; }
.lesson-content img { @apply rounded-lg max-w-full my-3; }
.lesson-content mark { @apply bg-yellow-200 px-0.5 rounded; }
.lesson-content table { @apply border-collapse w-full my-3; }
.lesson-content th { @apply bg-gray-100 border border-gray-300 px-3 py-2 text-left font-semibold text-sm; }
.lesson-content td { @apply border border-gray-300 px-3 py-2 text-sm; }

.math-content .katex-display { @apply my-2; }
.math-content strong { @apply text-gray-900; }
.math-content br + br { @apply hidden; }
</style>
