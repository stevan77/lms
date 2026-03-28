import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useTranslations() {
    const page = usePage();

    const t = (key) => {
        const translations = page.props.translations || {};
        return translations[key] || key;
    };

    const locale = computed(() => page.props.locale || 'en');

    return { t, locale };
}
