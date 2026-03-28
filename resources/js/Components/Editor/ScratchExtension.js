import { Node, mergeAttributes } from '@tiptap/core';
import { VueNodeViewRenderer } from '@tiptap/vue-3';
import ScratchNodeView from './ScratchNodeView.vue';

export default Node.create({
    name: 'scratchEmbed',
    group: 'block',
    atom: true,

    addAttributes() {
        return {
            projectId: {
                default: '',
            },
            caption: {
                default: '',
            },
        };
    },

    parseHTML() {
        return [{ tag: 'div[data-scratch-embed]' }];
    },

    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes({ 'data-scratch-embed': '' }, HTMLAttributes)];
    },

    addNodeView() {
        return VueNodeViewRenderer(ScratchNodeView);
    },

    addCommands() {
        return {
            insertScratchEmbed: (attrs) => ({ commands }) => {
                return commands.insertContent({
                    type: this.name,
                    attrs,
                });
            },
        };
    },
});
