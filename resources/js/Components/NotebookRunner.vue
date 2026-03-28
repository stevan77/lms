<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { EditorView, basicSetup } from 'codemirror';
import { python } from '@codemirror/lang-python';
import { EditorState } from '@codemirror/state';
import { marked } from './notebookMarkdown.js';
import { explainPythonError } from './pythonErrorHelper.js';

const props = defineProps({
    cellsJson: { type: String, default: '[]' },
});

const cells = ref([]);
const cellOutputs = ref({});
const cellRunning = ref({});
const editors = {};
const editorRefs = ref({});
const pyodideLoading = ref(false);
const pyodideStatus = ref('');
const executionCount = ref(0);
let pyodide = null;
let matplotlibReady = false;
const loadedPackages = new Set();

const parseCells = () => {
    try {
        cells.value = JSON.parse(props.cellsJson || '[]').map((c, i) => ({
            ...c,
            id: i,
            executionNumber: null,
        }));
    } catch {
        cells.value = [];
    }
};

const loadPyodide = async () => {
    if (pyodide) return pyodide;
    pyodideLoading.value = true;

    try {
        pyodideStatus.value = 'Loading Python...';
        if (!window.loadPyodide) {
            await new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/pyodide/v0.27.7/full/pyodide.js';
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }

        pyodide = await window.loadPyodide({
            indexURL: 'https://cdn.jsdelivr.net/pyodide/v0.27.7/full/',
        });

        pyodideStatus.value = 'Ready';
        return pyodide;
    } catch (err) {
        pyodideStatus.value = 'Error: ' + err.message;
        console.error('Pyodide load error:', err);
        return null;
    } finally {
        pyodideLoading.value = false;
    }
};

const ensureMatplotlib = async (py) => {
    if (matplotlibReady) return;
    try {
        pyodideStatus.value = 'Installing matplotlib...';
        await py.loadPackage('matplotlib');
        py.runPython(`
import matplotlib
matplotlib.use('AGG')
import matplotlib.pyplot as _plt
# Override plt.show() to not close figures
_plt.show = lambda *args, **kwargs: None
`);
        matplotlibReady = true;
        pyodideStatus.value = 'Ready';
    } catch (err) {
        console.error('matplotlib load error:', err);
        pyodideStatus.value = 'matplotlib failed: ' + err.message;
    }
};

const mountEditor = (el, index) => {
    if (!el || editors[index]) return;
    const cell = cells.value[index];
    if (cell.type !== 'code') return;

    const editable = cell.editable !== false;

    const state = EditorState.create({
        doc: cell.content || '',
        extensions: [
            basicSetup,
            python(),
            EditorState.readOnly.of(!editable),
            EditorView.theme({
                '&': { fontSize: '13px' },
                '.cm-content': {
                    padding: '10px 0',
                    fontFamily: "'JetBrains Mono', 'Fira Code', monospace",
                },
                '.cm-gutters': {
                    backgroundColor: editable ? '#f8fafc' : '#f1f5f9',
                },
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

const ensurePackages = async (py, code) => {
    // Packages that need micropip install (not built into Pyodide)
    const packagePatterns = [
        { pattern: /import\s+pandas|from\s+pandas/, pkg: 'pandas' },
        { pattern: /import\s+numpy|from\s+numpy/, pkg: 'numpy' },
    ];

    const needed = packagePatterns.filter(({ pattern, pkg }) =>
        pattern.test(code) && !loadedPackages.has(pkg)
    );

    for (const { pkg } of needed) {
        try {
            pyodideStatus.value = `Installing ${pkg}...`;
            await py.loadPackage(pkg);
            loadedPackages.add(pkg);
        } catch (err) {
            console.error(`${pkg} load error:`, err);
            pyodideStatus.value = `${pkg} failed: ${err.message}`;
        }
    }

    if (needed.length > 0) {
        pyodideStatus.value = 'Ready';
    }
};

const runCell = async (index) => {
    const cell = cells.value[index];
    if (cell.type !== 'code') return;

    cellRunning.value[index] = true;
    cellOutputs.value[index] = { text: '', images: [], error: null };

    try {
        const py = await loadPyodide();
        if (!py) {
            cellOutputs.value[index] = { text: '', images: [], error: 'Failed to load Python' };
            return;
        }

        const code = editors[index]?.state.doc.toString() || cell.content;

        // Load any required packages (pandas, numpy, etc.)
        await ensurePackages(py, code);

        // Check if code uses matplotlib
        const usesMatplotlib = /import\s+matplotlib|from\s+matplotlib|plt\.|pyplot/.test(code);
        if (usesMatplotlib) {
            await ensureMatplotlib(py);
        }

        // Redirect stdout/stderr, suppress warnings, override input()
        py.runPython(`
import sys as _sys
import warnings as _warnings
from io import StringIO as _StringIO
import js as _js
_warnings.filterwarnings('ignore')
_nb_stdout = _StringIO()
_nb_stderr = _StringIO()
_sys.stdout = _nb_stdout
_sys.stderr = _nb_stderr

def _browser_input(prompt=''):
    _saved = _sys.stdout
    _sys.stdout = _sys.__stdout__
    result = _js.prompt(str(prompt))
    _sys.stdout = _saved
    if result is None:
        raise EOFError('User cancelled input')
    _nb_stdout.write(str(prompt) + str(result) + '\\n')
    return result

import builtins as _builtins
_builtins.input = _browser_input
`);

        try {
            // If matplotlib, setup image capture via plt.show() override
            if (usesMatplotlib) {
                py.runPython(`
import matplotlib.pyplot as plt
import io as _io
import base64 as _b64
plt.close('all')
_nb_captured_images = []

def _nb_show(*args, **kwargs):
    for _fig_num in plt.get_fignums():
        _fig = plt.figure(_fig_num)
        _buf = _io.BytesIO()
        _fig.savefig(_buf, format='png', dpi=100, bbox_inches='tight', facecolor='white')
        _buf.seek(0)
        _nb_captured_images.append(_b64.b64encode(_buf.read()).decode('utf-8'))
        _buf.close()
    plt.close('all')

plt.show = _nb_show
`);
            }

            py.runPython(code);

            const stdout = py.runPython('_nb_stdout.getvalue()');
            const stderr = py.runPython('_nb_stderr.getvalue()');

            // Get captured images
            let images = [];
            if (usesMatplotlib) {
                const imgData = py.runPython(`'|||'.join(_nb_captured_images)`);
                if (imgData) {
                    images = imgData.split('|||').filter(s => s.length > 0);
                }
                py.runPython(`_nb_captured_images = []`);
            }

            executionCount.value++;
            cell.executionNumber = executionCount.value;

            // Filter out noisy matplotlib warnings from stderr
            const cleanStderr = stderr
                ? stderr.split('\n').filter(line =>
                    !line.includes('font cache') &&
                    !line.includes('non-interactive') &&
                    !line.includes('FigureCanvasAgg') &&
                    line.trim()
                ).join('\n')
                : '';

            cellOutputs.value[index] = {
                text: stdout + (cleanStderr ? cleanStderr : ''),
                images,
                error: null,
            };
        } catch (err) {
            executionCount.value++;
            cell.executionNumber = executionCount.value;
            let fullError = err.message || String(err);
            try {
                const tb = py.runPython(`
import traceback, sys
_ei = sys.last_value if hasattr(sys, 'last_value') else None
''.join(traceback.format_exception(type(_ei), _ei, _ei.__traceback__)) if _ei else ''
`);
                if (tb && tb.length > 5) fullError = tb;
            } catch {}
            const friendly = explainPythonError(fullError);
            cellOutputs.value[index] = {
                text: '',
                images: [],
                error: friendly
                    ? friendly + '\n\n--- Originalna greska ---\n' + fullError
                    : fullError,
            };
        }

        py.runPython(`
_sys.stdout = _sys.__stdout__
_sys.stderr = _sys.__stderr__
`);
    } catch (err) {
        const errMsg = err.message || String(err);
        const friendly = explainPythonError(errMsg);
        cellOutputs.value[index] = { text: '', images: [], error: friendly ? friendly + '\n\n--- Originalna greska ---\n' + errMsg : errMsg };
    } finally {
        cellRunning.value[index] = false;
    }
};

const runAll = async () => {
    for (let i = 0; i < cells.value.length; i++) {
        if (cells.value[i].type === 'code') {
            await runCell(i);
        }
    }
};

const clearOutputs = () => {
    cellOutputs.value = {};
    cells.value.forEach(c => c.executionNumber = null);
    executionCount.value = 0;
};

const renderMarkdown = (text) => {
    return marked(text || '');
};

const hasOutput = (index) => {
    const out = cellOutputs.value[index];
    return out && (out.text || (out.images && out.images.length > 0) || out.error);
};
</script>

<template>
    <div class="my-4 rounded-xl border-2 border-orange-200 overflow-hidden shadow-sm">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-4 py-2.5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span class="text-sm font-semibold text-white">Jupyter Notebook</span>
            </div>
            <div class="flex items-center gap-2">
                <span v-if="pyodideLoading" class="text-xs text-orange-100 animate-pulse">{{ pyodideStatus }}</span>
                <button
                    @click="clearOutputs"
                    class="px-2.5 py-1 text-xs font-medium text-orange-100 hover:text-white hover:bg-white/10 rounded-md transition-colors"
                >
                    Clear
                </button>
                <button
                    @click="runAll"
                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold bg-white text-orange-700 rounded-md hover:bg-orange-50 transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                    Run All
                </button>
            </div>
        </div>

        <!-- Cells -->
        <div class="bg-white">
            <div v-for="(cell, i) in cells" :key="i" class="border-b border-gray-100 last:border-b-0">
                <!-- Markdown cell -->
                <div v-if="cell.type === 'markdown'" class="px-5 py-4">
                    <div class="prose prose-sm max-w-none text-gray-700" v-html="renderMarkdown(cell.content)" />
                </div>

                <!-- Code cell -->
                <div v-else class="relative">
                    <!-- Cell header -->
                    <div class="flex items-center justify-between px-3 pt-2 pb-1">
                        <span class="text-xs font-mono text-blue-500 font-semibold">
                            In [{{ cell.executionNumber || ' ' }}]:
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span v-if="!cell.editable" class="text-[10px] text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">read-only</span>
                            <button
                                @click="runCell(i)"
                                :disabled="cellRunning[i]"
                                class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-md transition-colors disabled:opacity-50 border border-emerald-200"
                            >
                                <svg v-if="cellRunning[i]" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <svg v-else class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                {{ cellRunning[i] ? '...' : 'Run' }}
                            </button>
                        </div>
                    </div>

                    <!-- Editor -->
                    <div class="px-3 pb-2">
                        <div
                            :ref="(el) => setEditorRef(el, i)"
                            :class="[
                                'notebook-runner-editor rounded-lg overflow-hidden border',
                                cell.editable ? 'border-gray-200' : 'border-gray-200 bg-gray-50'
                            ]"
                        />
                    </div>

                    <!-- Running indicator -->
                    <div v-if="cellRunning[i]" class="mx-3 mb-2">
                        <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-amber-50 border border-amber-200">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 0ms" />
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 150ms" />
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 300ms" />
                            </div>
                            <span class="text-xs font-medium text-amber-700">{{ pyodideLoading ? pyodideStatus : 'Running...' }}</span>
                        </div>
                    </div>

                    <!-- Output -->
                    <div v-if="hasOutput(i)" v-show="!cellRunning[i]" class="mx-3 mb-3 rounded-lg border border-gray-200 overflow-hidden">
                        <div class="flex items-center gap-2 px-3 py-1 bg-gray-50 border-b border-gray-100">
                            <span class="text-xs font-mono text-red-500 font-semibold">Out [{{ cell.executionNumber || ' ' }}]:</span>
                        </div>
                        <!-- Error -->
                        <pre v-if="cellOutputs[i]?.error" class="px-3 py-2 text-sm font-mono text-red-600 bg-red-50 whitespace-pre-wrap overflow-auto max-h-[300px]">{{ cellOutputs[i].error }}</pre>
                        <!-- Text output -->
                        <pre v-if="cellOutputs[i]?.text" class="px-3 py-2 text-sm font-mono text-gray-800 whitespace-pre-wrap overflow-auto max-h-[300px]">{{ cellOutputs[i].text }}</pre>
                        <!-- Image outputs (matplotlib) -->
                        <div v-if="cellOutputs[i]?.images?.length" class="p-3 space-y-3 bg-white">
                            <img
                                v-for="(img, j) in cellOutputs[i].images"
                                :key="j"
                                :src="'data:image/png;base64,' + img"
                                class="max-w-full rounded border border-gray-100"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading indicator -->
        <div v-if="pyodideLoading" class="px-4 py-2 bg-amber-50 text-center text-xs text-amber-700 font-medium animate-pulse">
            ⏳ {{ pyodideStatus }}
        </div>
    </div>
</template>

<style>
.notebook-runner-editor .cm-editor {
    max-height: 300px;
}
.notebook-runner-editor .cm-scroller {
    overflow: auto;
}
</style>
