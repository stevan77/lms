import { Node, mergeAttributes } from '@tiptap/core';
import { VueNodeViewRenderer } from '@tiptap/vue-3';
import MathNodeView from './MathNodeView.vue';

export default Node.create({
    name: 'mathBlock',
    group: 'block',
    atom: true,

    addAttributes() {
        return {
            latex: {
                default: '',
            },
            display: {
                default: 'block',
            },
        };
    },

    parseHTML() {
        return [{ tag: 'div[data-math-block]' }];
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes({ 'data-math-block': '' }, HTMLAttributes)];
    },

    addNodeView() {
        return VueNodeViewRenderer(MathNodeView);
    },

    addCommands() {
        return {
            insertMath: (attrs) => ({ commands }) => {
                return commands.insertContent({
                    type: this.name,
                    attrs,
                });
            },
        };
    },
});
