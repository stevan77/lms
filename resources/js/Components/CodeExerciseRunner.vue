<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { EditorView, basicSetup } from 'codemirror';
import { python } from '@codemirror/lang-python';
import { EditorState } from '@codemirror/state';
import { explainPythonError } from './pythonErrorHelper.js';

const props = defineProps({
    starterCode: { type: String, default: '' },
    instructions: { type: String, default: '' },
});

const editorContainer = ref(null);
const canvasContainer = ref(null);
const output = ref('');
const outputIsError = ref(false);
const isRunning = ref(false);
const pyodideReady = ref(false);
const pyodideLoading = ref(false);
const showOutput = ref(false);
const showCanvas = ref(false);
let editorView = null;
let pyodide = null;
const loadedPackages = new Set();

// Unique ID for this exercise's canvas container
const canvasId = `pygame-canvas-${Math.random().toString(36).slice(2, 9)}`;

onMounted(() => {
    const state = EditorState.create({
        doc: props.starterCode || '# Write your code here\n',
        extensions: [
            basicSetup,
            python(),
            EditorView.theme({
                '&': { fontSize: '14px', borderRadius: '0 0 0 0' },
                '.cm-content': { padding: '12px 0', fontFamily: "'JetBrains Mono', 'Fira Code', monospace" },
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

const loadPyodide = async () => {
    if (pyodide) return pyodide;

    pyodideLoading.value = true;
    try {
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
        pyodideReady.value = true;
        return pyodide;
    } catch (err) {
        output.value = `Error loading Python: ${err.message}`;
    } finally {
        pyodideLoading.value = false;
    }
};

const loadPygameShim = async (py) => {
    // Load the pygame shim only once
    if (py.globals.has('_pygame_shim_loaded')) return;

    try {
        const response = await fetch('/pygame-shim.py');
        const shimCode = await response.text();

        // Register as a module so "import pygame" works
        py.registerJsModule('_pygame_shim_marker', { loaded: true });
        py.runPython(`
import sys
from types import ModuleType

# Load shim code
_shim_code = ${JSON.stringify(shimCode)}
_shim_module = ModuleType('pygame')
_shim_module.__dict__['__name__'] = 'pygame'
exec(_shim_code, _shim_module.__dict__)

# Register in sys.modules
sys.modules['pygame'] = _shim_module
sys.modules['pygame.display'] = type(sys)('pygame.display')
sys.modules['pygame.display'].__dict__.update({
    'set_mode': _shim_module.display.set_mode,
    'flip': _shim_module.display.flip,
    'update': _shim_module.display.update,
    'set_caption': _shim_module.display.set_caption,
    'get_surface': _shim_module.display.get_surface,
})
sys.modules['pygame.draw'] = type(sys)('pygame.draw')
sys.modules['pygame.draw'].__dict__.update({
    'line': _shim_module.draw.line,
    'lines': _shim_module.draw.lines,
    'rect': _shim_module.draw.rect,
    'circle': _shim_module.draw.circle,
    'ellipse': _shim_module.draw.ellipse,
    'polygon': _shim_module.draw.polygon,
    'arc': _shim_module.draw.arc,
    'aaline': _shim_module.draw.aaline,
    'aalines': _shim_module.draw.aalines,
})
sys.modules['pygame.event'] = type(sys)('pygame.event')
sys.modules['pygame.event'].__dict__.update({
    'get': _shim_module.event.get,
    'pump': _shim_module.event.pump,
})
sys.modules['pygame.time'] = type(sys)('pygame.time')
sys.modules['pygame.time'].__dict__.update({
    'Clock': _shim_module.time.Clock,
    'wait': _shim_module.time.wait,
    'delay': _shim_module.time.delay,
    'get_ticks': _shim_module.time.get_ticks,
})
sys.modules['pygame.font'] = type(sys)('pygame.font')
sys.modules['pygame.font'].__dict__.update({
    'init': _shim_module.font.init,
    'SysFont': _shim_module.font.SysFont,
    'get_fonts': _shim_module.font.get_fonts,
})
sys.modules['pygame.mouse'] = type(sys)('pygame.mouse')
sys.modules['pygame.mouse'].__dict__.update({
    'get_pos': _shim_module.mouse.get_pos,
    'get_pressed': _shim_module.mouse.get_pressed,
})
sys.modules['pygame.key'] = type(sys)('pygame.key')
sys.modules['pygame.key'].__dict__.update({
    'get_pressed': _shim_module.key.get_pressed,
})

_pygame_shim_loaded = True
`);
    } catch (err) {
        console.error('Failed to load pygame shim:', err);
    }
};

const runCode = async () => {
    if (!editorView) return;

    const code = editorView.state.doc.toString();
    isRunning.value = true;
    showOutput.value = true;
    output.value = '';
    outputIsError.value = false;

    // Detect if code uses pygame
    const usesPygame = /import\s+pygame|from\s+pygame/.test(code);

    if (usesPygame) {
        showCanvas.value = true;
        await nextTick();
    }

    try {
        const py = await loadPyodide();
        if (!py) return;

        // Auto-load packages (pandas, numpy, etc.)
        const packagePatterns = [
            { pattern: /import\s+pandas|from\s+pandas/, pkg: 'pandas' },
            { pattern: /import\s+numpy|from\s+numpy/, pkg: 'numpy' },
            { pattern: /import\s+matplotlib|from\s+matplotlib|plt\.|pyplot/, pkg: 'matplotlib' },
        ];
        for (const { pattern, pkg } of packagePatterns) {
            if (pattern.test(code) && !loadedPackages.has(pkg)) {
                await py.loadPackage(pkg);
                loadedPackages.add(pkg);
            }
        }

        // Load pygame shim if needed
        if (usesPygame) {
            await loadPygameShim(py);

            // Point pygame canvas to our container
            py.runPython(`
import js
# Set the canvas container ID
_container = js.document.getElementById('${canvasId}')
if _container:
    _container.id = 'pygame-canvas-container'
`);
        }

        // Redirect stdout/stderr and override input()
        py.runPython(`
import sys
from io import StringIO
import js

_stdout = StringIO()
_stderr = StringIO()
sys.stdout = _stdout
sys.stderr = _stderr

def _browser_input(prompt=''):
    _sys_stdout = sys.stdout
    sys.stdout = sys.__stdout__
    result = js.prompt(str(prompt))
    sys.stdout = _sys_stdout
    if result is None:
        raise EOFError('User cancelled input')
    _stdout.write(str(prompt) + str(result) + '\\n')
    return result

import builtins
builtins.input = _browser_input
`);

        try {
            py.runPython(code);
            const stdout = py.runPython('_stdout.getvalue()');
            const stderr = py.runPython('_stderr.getvalue()');

            if (usesPygame) {
                // Restore container ID
                py.runPython(`
_container = js.document.getElementById('pygame-canvas-container')
if _container:
    _container.id = '${canvasId}'
`);
            }

            output.value = stdout + (stderr ? '\n⚠️ ' + stderr : '');
            if (!output.value.trim() && !usesPygame) {
                output.value = '✓ Program finished (no output)';
            } else if (!output.value.trim() && usesPygame) {
                output.value = '✓ Pygame rendered successfully';
            }
        } catch (err) {
            const errMsg = err.type ? String(err.type + ': ' + err.message) : (err.message || String(err));
            // Pyodide puts the full traceback in err.message, but sometimes just 'PythonError'
            // Try to get the actual Python traceback
            let fullError = errMsg;
            try {
                const tb = py.runPython(`
import traceback, sys
_ei = sys.last_value if hasattr(sys, 'last_value') else None
_tb = ''.join(traceback.format_exception(type(_ei), _ei, _ei.__traceback__)) if _ei else ''
_tb
`);
                if (tb && tb.length > 5) fullError = tb;
            } catch {}
            const friendly = explainPythonError(fullError);
            if (friendly) {
                output.value = friendly + '\n\n--- Originalna greska ---\n' + fullError;
            } else {
                output.value = fullError;
            }
            outputIsError.value = true;
        }

        py.runPython(`
sys.stdout = sys.__stdout__
sys.stderr = sys.__stderr__
`);
    } catch (err) {
        output.value = String(err.message || err);
        outputIsError.value = true;
    } finally {
        isRunning.value = false;
    }
};

const resetCode = () => {
    outputIsError.value = false;
    if (editorView) {
        editorView.dispatch({
            changes: { from: 0, to: editorView.state.doc.length, insert: props.starterCode || '' },
        });
    }
    output.value = '';
    showOutput.value = false;
    showCanvas.value = false;
};
</script>

<template>
    <div class="my-4 rounded-xl border-2 border-emerald-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2.5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                </svg>
                <span class="text-sm font-semibold text-white">Python</span>
            </div>
            <div class="flex items-center gap-2">
                <button
                    @click="resetCode"
                    class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-md transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                    </svg>
                    Reset
                </button>
                <button
                    @click="runCode"
                    :disabled="isRunning"
                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold bg-white text-emerald-700 rounded-md hover:bg-emerald-50 transition-colors disabled:opacity-50"
                >
                    <svg v-if="isRunning" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    <svg v-else class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                    {{ isRunning ? (pyodideLoading ? 'Loading Python...' : 'Running...') : 'Run' }}
                </button>
            </div>
        </div>

        <!-- Instructions -->
        <div v-if="instructions" class="bg-emerald-50 border-b border-emerald-100 px-4 py-2.5">
            <p class="text-sm text-emerald-800">
                <span class="font-semibold">Task:</span> {{ instructions }}
            </p>
        </div>

        <!-- Code Editor -->
        <div ref="editorContainer" class="code-runner-editor" />

        <!-- Running indicator -->
        <div v-if="isRunning" class="border-t border-gray-200">
            <div class="flex items-center gap-3 px-4 py-3 bg-amber-50">
                <div class="flex gap-1">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 0ms" />
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 150ms" />
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 300ms" />
                </div>
                <span class="text-xs font-medium text-amber-700">{{ pyodideLoading ? 'Loading Python...' : 'Running...' }}</span>
            </div>
        </div>

        <!-- Pygame Canvas -->
        <div v-show="showCanvas" class="border-t border-gray-200 bg-gray-50 p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M2.25 18V6a2.25 2.25 0 012.25-2.25h15A2.25 2.25 0 0121.75 6v12A2.25 2.25 0 0119.5 20.25h-15A2.25 2.25 0 012.25 18z" />
                </svg>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Canvas</span>
            </div>
            <div :id="canvasId" ref="canvasContainer" class="flex justify-center" />
        </div>

        <!-- Output -->
        <Transition
            enter-active-class="transition-all duration-200 ease-out"
            enter-from-class="opacity-0 max-h-0"
            enter-to-class="opacity-100 max-h-[500px]"
            leave-active-class="transition-all duration-150 ease-in"
            leave-from-class="opacity-100 max-h-[500px]"
            leave-to-class="opacity-0 max-h-0"
        >
            <div v-if="showOutput" class="border-t border-gray-200 bg-gray-900 overflow-hidden">
                <div class="flex items-center justify-between px-4 py-1.5 bg-gray-800/50 border-b border-gray-700">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Output</span>
                    <button @click="showOutput = false" class="text-gray-500 hover:text-gray-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <pre v-if="outputIsError" class="px-4 py-3 text-sm font-mono text-red-300 whitespace-pre-wrap overflow-auto max-h-[300px] bg-red-950/50">{{ output }}</pre>
                <pre v-else class="px-4 py-3 text-sm font-mono text-gray-100 whitespace-pre-wrap overflow-auto max-h-[200px]">{{ output || (isRunning ? 'Running...' : '') }}</pre>
            </div>
        </Transition>
    </div>
</template>

<style>
.code-runner-editor .cm-editor {
    max-height: 400px;
}
.code-runner-editor .cm-scroller {
    overflow: auto;
}
</style>
