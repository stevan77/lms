<script setup>
import { ref, watch, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success');
let timer = null;

const dismiss = () => {
    show.value = false;
};

const showFlash = (msg, msgType) => {
    message.value = msg;
    type.value = msgType;
    show.value = true;
    clearTimeout(timer);
    timer = setTimeout(dismiss, 4000);
};

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) {
            showFlash(flash.success, 'success');
        } else if (flash?.error) {
            showFlash(flash.error, 'error');
        }
    },
    { immediate: true, deep: true }
);

onUnmounted(() => clearTimeout(timer));
</script>

<template>
    <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 translate-x-8 -translate-y-2"
        enter-to-class="opacity-100 translate-x-0 translate-y-0"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100 translate-x-0"
        leave-to-class="opacity-0 translate-x-8"
    >
        <div
            v-if="show"
            class="fixed top-4 right-4 z-[60] max-w-sm w-full"
        >
            <div
                :class="[
                    'flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border',
                    type === 'success'
                        ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                        : 'bg-red-50 border-red-200 text-red-800'
                ]"
            >
                <!-- Success icon -->
                <svg v-if="type === 'success'" class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <!-- Error icon -->
                <svg v-else class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>

                <p class="text-sm font-medium flex-1">{{ message }}</p>

                <button
                    @click="dismiss"
                    class="shrink-0 p-1 rounded-lg hover:bg-black/5 transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </Transition>
</template>
