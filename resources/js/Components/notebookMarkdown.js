/**
 * Minimal markdown renderer for notebook cells.
 */
export function marked(text) {
    if (!text) return '';

    let html = text
        // Escape HTML
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')

        // Headers
        .replace(/^### (.+)$/gm, '<h3 class="text-base font-semibold text-gray-800 mt-3 mb-1">$1</h3>')
        .replace(/^## (.+)$/gm, '<h2 class="text-lg font-bold text-gray-900 mt-3 mb-2">$1</h2>')
        .replace(/^# (.+)$/gm, '<h1 class="text-xl font-bold text-gray-900 mt-3 mb-2">$1</h1>')

        // Bold & italic
        .replace(/\*\*\*(.+?)\*\*\*/g, '<strong><em>$1</em></strong>')
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.+?)\*/g, '<em>$1</em>')

        // Inline code
        .replace(/`([^`]+)`/g, '<code class="bg-gray-100 text-pink-600 px-1.5 py-0.5 rounded text-sm font-mono">$1</code>')

        // Unordered lists
        .replace(/^\- (.+)$/gm, '<li class="ml-4 list-disc text-sm text-gray-700">$1</li>')
        .replace(/^\* (.+)$/gm, '<li class="ml-4 list-disc text-sm text-gray-700">$1</li>')

        // Ordered lists
        .replace(/^\d+\. (.+)$/gm, '<li class="ml-4 list-decimal text-sm text-gray-700">$1</li>')

        // Blockquote
        .replace(/^&gt; (.+)$/gm, '<blockquote class="border-l-4 border-orange-300 pl-3 italic text-gray-600 my-2">$1</blockquote>')

        // Horizontal rule
        .replace(/^---$/gm, '<hr class="my-3 border-gray-200" />')

        // Line breaks -> paragraphs
        .replace(/\n\n/g, '</p><p class="text-sm text-gray-700 mb-2">')
        .replace(/\n/g, '<br/>');

    // Wrap in paragraph
    html = '<p class="text-sm text-gray-700 mb-2">' + html + '</p>';

    // Clean up empty paragraphs
    html = html.replace(/<p class="text-sm text-gray-700 mb-2"><\/p>/g, '');

    return html;
}
