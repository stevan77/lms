import { Node, mergeAttributes } from '@tiptap/core';
import { VueNodeViewRenderer } from '@tiptap/vue-3';
import NotebookNodeView from './NotebookNodeView.vue';

export default Node.create({
    name: 'notebook',
    group: 'block',
    atom: true,

    addAttributes() {
        return {
            cells: {
                default: JSON.stringify([
                    { type: 'markdown', content: '# Notebook\nOpis zadatka...', editable: false },
                    { type: 'code', content: '# Your code here\n', editable: true },
                ]),
            },
        };
    },

    parseHTML() {
        return [{ tag: 'div[data-notebook]' }];
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes({ 'data-notebook': '' }, HTMLAttributes)];
    },

    addNodeView() {
        return VueNodeViewRenderer(NotebookNodeView);
    },

    addCommands() {
        return {
            insertNotebook: (attrs) => ({ commands }) => {
                return commands.insertContent({
                    type: this.name,
                    attrs,
                });
            },
        };
    },
});
