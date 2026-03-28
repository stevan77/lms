<script setup>
import { ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();
const userRole = usePage().props.auth?.user?.role;

const props = defineProps({
    messages: Object,
    unreadCount: Number,
    filterStudents: Array,
    filterGrades: Array,
    currentFilterStudent: [String, Number],
    currentFilterGrade: [String, Number],
});

const showDeleteModal = ref(false);
const messageToDelete = ref(null);

const confirmDelete = (msg) => {
    messageToDelete.value = msg;
    showDeleteModal.value = true;
};

const deleteMessage = () => {
    if (messageToDelete.value) {
        router.delete(route('messages.destroy', messageToDelete.value.id), {
            onSuccess: () => { showDeleteModal.value = false; messageToDelete.value = null; },
        });
    }
};

const applyFilter = (type, value) => {
    const params = {};
    if (type === 'student') {
        params.student = value || undefined;
        if (props.currentFilterGrade) params.grade = props.currentFilterGrade;
    } else {
        params.grade = value || undefined;
        if (props.currentFilterStudent) params.student = props.currentFilterStudent;
    }
    router.get(route('messages.inbox'), params, { preserveState: true });
};

const clearFilters = () => {
    router.get(route('messages.inbox'));
};

const hasFilters = props.currentFilterStudent || props.currentFilterGrade;

const timeAgo = (date) => {
    const seconds = Math.floor((Date.now() - new Date(date)) / 1000);
    if (seconds < 60) return t('just now');
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes}m`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}h`;
    const days = Math.floor(hours / 24);
    return `${days}d`;
};
</script>

<template>
    <Head :title="t('Messages')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ t('Messages') }}</h1>
                    <p v-if="unreadCount > 0" class="mt-1 text-sm text-indigo-600 font-medium">{{ unreadCount }} {{ t('unread') }}</p>
                </div>
                <Link :href="route('messages.create')">
                    <ButtonPrimary>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ t('New Message') }}
                    </ButtonPrimary>
                </Link>
            </div>
        </template>

        <div class="max-w-3xl mx-auto">

            <!-- Filters (teacher only) -->
            <div v-if="userRole === 'teacher' && (filterStudents?.length || filterGrades?.length)" class="mb-4 bg-white rounded-xl shadow-sm border border-gray-200/60 p-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('Filter') }}:</span>

                    <!-- Student filter -->
                    <select
                        v-if="filterStudents?.length"
                        :value="currentFilterStudent || ''"
                        @change="applyFilter('student', $event.target.value)"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">{{ t('All Students') }}</option>
                        <option v-for="s in filterStudents" :key="s.id" :value="s.id">{{ s.name }}</option>
                    </select>

                    <!-- Grade filter -->
                    <select
                        v-if="filterGrades?.length"
                        :value="currentFilterGrade || ''"
                        @change="applyFilter('grade', $event.target.value)"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">{{ t('All Grades') }}</option>
                        <option v-for="g in filterGrades" :key="g.id" :value="g.id">{{ g.name }}</option>
                    </select>

                    <!-- Clear -->
                    <button
                        v-if="hasFilters"
                        @click="clearFilters"
                        class="text-xs text-red-500 hover:text-red-700 font-medium"
                    >
                        {{ t('Clear filters') }}
                    </button>
                </div>
            </div>

            <!-- Messages list -->
            <div v-if="messages.data?.length" class="bg-white rounded-xl shadow-sm border border-gray-200/60 overflow-hidden divide-y divide-gray-100">
                <div
                    v-for="msg in messages.data"
                    :key="msg.id"
                    :class="[
                        'flex items-start gap-4 px-5 py-4 hover:bg-gray-50/50 transition-colors',
                        !msg.is_read ? 'bg-indigo-50/30' : ''
                    ]"
                >
                    <!-- Link to message -->
                    <Link :href="route('messages.show', msg.id)" class="flex items-start gap-4 flex-1 min-w-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 text-white text-sm font-semibold"
                            :class="msg.sender?.role === 'teacher' ? 'bg-gradient-to-br from-indigo-500 to-purple-600' : 'bg-gradient-to-br from-emerald-500 to-teal-600'"
                        >
                            {{ msg.sender?.name?.charAt(0)?.toUpperCase() }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-900">{{ msg.sender?.name }}</span>
                                <span v-if="msg.recipient && msg.sender?.id !== msg.recipient?.id" class="text-xs text-gray-400">→ {{ msg.recipient?.name }}</span>
                                <span v-if="msg.is_broadcast" class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium text-purple-700 bg-purple-50 border border-purple-100">
                                    {{ msg.grade?.name || t('Broadcast') }}
                                </span>
                                <span v-if="!msg.is_read" class="w-2 h-2 rounded-full bg-indigo-500 shrink-0" />
                            </div>
                            <p class="text-sm font-medium text-gray-800 truncate mt-0.5">{{ msg.subject }}</p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">{{ msg.body?.substring(0, 100) }}</p>
                        </div>

                        <span class="text-xs text-gray-400 shrink-0 mt-1">{{ timeAgo(msg.created_at) }}</span>
                    </Link>

                    <!-- Delete button -->
                    <button
                        @click.prevent="confirmDelete(msg)"
                        class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors shrink-0 mt-1"
                        :title="t('Delete')"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Empty -->
            <div v-else class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                <p class="text-gray-500 mb-4">{{ hasFilters ? t('No messages match your filters') : t('No messages yet') }}</p>
                <div class="flex items-center justify-center gap-3">
                    <Link v-if="!hasFilters" :href="route('messages.create')">
                        <ButtonPrimary>{{ t('Send First Message') }}</ButtonPrimary>
                    </Link>
                    <button v-if="hasFilters" @click="clearFilters" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        {{ t('Clear filters') }}
                    </button>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="messages.links && messages.last_page > 1" class="mt-6 flex items-center justify-center gap-1">
                <Link
                    v-for="link in messages.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    :class="[
                        'px-3 py-1.5 text-sm rounded-lg transition-colors',
                        link.active ? 'bg-indigo-600 text-white' : link.url ? 'text-gray-600 hover:bg-gray-100' : 'text-gray-300'
                    ]"
                    v-html="link.label"
                    preserve-scroll
                />
            </div>
        </div>

        <DeleteConfirmModal
            :show="showDeleteModal"
            :title="t('Delete') + ' ' + t('Message')"
            :message="t('Are you sure?') + ' ' + t('This action cannot be undone.')"
            @close="showDeleteModal = false"
            @confirm="deleteMessage"
        />
    </AuthenticatedLayout>
</template>
