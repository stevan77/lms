<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import SelectField from '@/Components/SelectField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    recipients: Array,
    grades: Array,
    userRole: String,
    replyTo: [String, Number],
    replySubject: String,
    replyRecipient: Object,
});

const sendMode = ref(props.replyRecipient ? 'direct' : 'direct'); // 'direct' or 'broadcast'

const form = useForm({
    subject: props.replySubject
        ? (props.replySubject.startsWith('Re: ') ? props.replySubject : 'Re: ' + props.replySubject)
        : '',
    body: '',
    recipient_id: props.replyRecipient?.id || '',
    grade_id: '',
    is_broadcast: false,
});

const submit = () => {
    form.is_broadcast = sendMode.value === 'broadcast';
    if (sendMode.value === 'broadcast') {
        form.recipient_id = '';
    } else {
        form.grade_id = '';
    }
    form.post(route('messages.store'));
};

const recipientOptions = computed(() =>
    (props.recipients || []).map(r => ({ value: r.id, label: r.name + ' (' + r.email + ')' }))
);

const gradeOptions = computed(() =>
    (props.grades || []).map(g => ({ value: g.id, label: g.name }))
);

const isTeacher = computed(() => props.userRole === 'teacher');
</script>

<template>
    <Head :title="t('New Message')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link :href="route('messages.inbox')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </Link>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('New Message') }}</h1>
            </div>
        </template>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Send mode toggle (teachers only) -->
                    <div v-if="isTeacher" class="flex items-center gap-2 p-1 bg-gray-100 rounded-lg w-fit">
                        <button
                            type="button"
                            @click="sendMode = 'direct'"
                            :class="[
                                'px-4 py-2 text-sm font-medium rounded-md transition-all',
                                sendMode === 'direct' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'
                            ]"
                        >
                            {{ t('Direct Message') }}
                        </button>
                        <button
                            type="button"
                            @click="sendMode = 'broadcast'"
                            :class="[
                                'px-4 py-2 text-sm font-medium rounded-md transition-all',
                                sendMode === 'broadcast' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'
                            ]"
                        >
                            {{ t('Send to Grade') }}
                        </button>
                    </div>

                    <!-- Recipient select (direct) -->
                    <div v-if="sendMode === 'direct'">
                        <SelectField
                            v-model="form.recipient_id"
                            :label="t('To')"
                            :options="recipientOptions"
                            :placeholder="t('Select recipient...')"
                            :error="form.errors.recipient_id"
                        />
                        <p v-if="replyRecipient" class="mt-1 text-xs text-gray-500">
                            {{ t('Replying to') }} {{ replyRecipient.name }}
                        </p>
                    </div>

                    <!-- Grade select (broadcast) -->
                    <div v-if="sendMode === 'broadcast'">
                        <SelectField
                            v-model="form.grade_id"
                            :label="t('Send to Grade')"
                            :options="gradeOptions"
                            :placeholder="t('Select grade...')"
                            :error="form.errors.grade_id"
                        />
                        <p class="mt-1 text-xs text-gray-500">{{ t('Message will be sent to all students in this grade') }}</p>
                    </div>

                    <InputField
                        v-model="form.subject"
                        :label="t('Subject')"
                        :placeholder="t('Message subject...')"
                        :error="form.errors.subject"
                    />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('Message') }}</label>
                        <textarea
                            v-model="form.body"
                            :placeholder="t('Write your message...')"
                            class="w-full px-4 py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y"
                            rows="8"
                        />
                        <p v-if="form.errors.body" class="mt-1 text-sm text-red-500">{{ form.errors.body }}</p>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            {{ t('Send') }}
                        </ButtonPrimary>
                        <Link :href="route('messages.inbox')">
                            <ButtonSecondary type="button">{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
