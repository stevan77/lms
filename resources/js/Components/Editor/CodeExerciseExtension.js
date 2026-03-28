import { Node, mergeAttributes } from '@tiptap/core';
import { VueNodeViewRenderer } from '@tiptap/vue-3';
import CodeExerciseNodeView from './CodeExerciseNodeView.vue';

export default Node.create({
    name: 'codeExercise',
    group: 'block',
    atom: true,

    addAttributes() {
        return {
            starterCode: {
                default: '# Write your code here\n\n',
            },
            language: {
                default: 'python',
            },
            instructions: {
                default: '',
            },
        };
    },

    parseHTML() {
        return [{ tag: 'div[data-code-exercise]' }];
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes({ 'data-code-exercise': '' }, HTMLAttributes)];
    },

    addNodeView() {
        return VueNodeViewRenderer(CodeExerciseNodeView);
    },

    addCommands() {
        return {
            insertCodeExercise: (attrs) => ({ commands }) => {
                return commands.insertContent({
                    type: this.name,
                    attrs,
                });
            },
        };
    },
});
