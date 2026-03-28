<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import RichTextEditor from '@/Components/Editor/RichTextEditor.vue';
import LessonContent from '@/Components/LessonContent.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    lesson: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.lesson.title,
    content: props.lesson.content,
    order: props.lesson.order,
    is_assignment: props.lesson.is_assignment || false,
});

const showPreview = ref(true);

const submit = () => {
    form.put(route('teacher.lessons.update', props.lesson.id));
};
</script>

<template>
    <Head :title="t('Edit Lesson')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Edit Lesson') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ course.name }}</p>
                </div>
                <button
                    type="button"
                    @click="showPreview = !showPreview"
                    :class="[
                        'inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg border transition-all',
                        showPreview
                            ? 'text-indigo-700 bg-indigo-50 border-indigo-200'
                            : 'text-gray-600 bg-white border-gray-200 hover:bg-gray-50'
                    ]"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ showPreview ? t('Hide Preview') : t('Show Preview') }}
                </button>
            </div>
        </template>

        <form @submit.prevent="submit">
            <!-- Title + Order + Assignment row -->
            <div class="flex gap-4 mb-5 items-end">
                <div class="flex-1">
                    <InputField
                        v-model="form.title"
                        :label="t('Title')"
                        :placeholder="t('Enter lesson title')"
                        :error="form.errors.title"
                    />
                </div>
                <div class="w-32">
                    <InputField
                        v-model="form.order"
                        type="number"
                        :label="t('Order')"
                        placeholder="0"
                        :error="form.errors.order"
                    />
                </div>
                <label class="flex items-center gap-2 px-4 py-2.5 rounded-lg border cursor-pointer transition-colors" :class="form.is_assignment ? 'border-amber-300 bg-amber-50' : 'border-gray-200 bg-white hover:bg-gray-50'">
                    <input type="checkbox" v-model="form.is_assignment" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500" />
                    <span class="text-sm font-medium" :class="form.is_assignment ? 'text-amber-700' : 'text-gray-600'">{{ t('Assignment') }}</span>
                </label>
            </div>

            <!-- Editor + Preview side by side -->
            <div :class="['grid gap-5 mb-5', showPreview ? 'grid-cols-1 xl:grid-cols-2' : 'grid-cols-1']">
                <!-- Editor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('Content') }}</label>
                    <RichTextEditor
                        v-model="form.content"
                        :placeholder="t('Start writing your lesson content...')"
                        :error="form.errors.content"
                    />
                </div>

                <!-- Live Preview -->
                <div v-if="showPreview">
                    <div class="flex items-center gap-2 mb-1.5">
                        <label class="block text-sm font-medium text-gray-700">{{ t('Live Preview') }}</label>
                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-50 border border-indigo-100">
                            {{ t('Student view') }}
                        </span>
                    </div>
                    <div class="rounded-xl border border-gray-300 bg-white min-h-[350px] overflow-auto">
                        <div v-if="form.content" class="p-5">
                            <LessonContent :content="form.content" :key="form.content" />
                        </div>
                        <div v-else class="flex items-center justify-center h-[350px] text-sm text-gray-400">
                            {{ t('Start typing to see preview...') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                    {{ t('Update Lesson') }}
                </ButtonPrimary>
                <Link :href="route('teacher.lessons.index', course.id)">
                    <ButtonSecondary type="button">{{ t('Cancel') }}</ButtonSecondary>
                </Link>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
