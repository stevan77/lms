<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="EduPlatform" />

    <div class="min-h-screen bg-slate-950 flex flex-col relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-indigo-600/10 blur-3xl" />
            <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-purple-600/10 blur-3xl" />
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] rounded-full bg-indigo-500/5 blur-3xl" />
        </div>

        <!-- Nav -->
        <nav class="relative z-10 flex items-center justify-between px-6 py-5 lg:px-16">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">EduPlatform</span>
            </div>

            <div v-if="canLogin" class="flex items-center gap-3">
                <Link
                    :href="route('login')"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:from-indigo-600 hover:to-purple-700 transition-all duration-300"
                >
                    {{ t('Log In') }}
                </Link>
            </div>
        </nav>

        <!-- Hero -->
        <div class="relative z-10 flex-1 flex items-center justify-center px-6 py-16 lg:px-12">
            <div class="max-w-5xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-8 rounded-full bg-indigo-500/10 border border-indigo-500/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
                    <span class="text-xs font-semibold text-indigo-300">Platforma za moderne skole</span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight tracking-tight">
                    <span class="text-white">Ucenje bez </span>
                    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">granica</span>
                </h1>

                <p class="mt-6 text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Interaktivni kursevi, zadaci, ocene i komunikacija - sve na jednom mestu. Python, Pygame, Jupyter i Scratch rade direktno u browseru.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:from-indigo-600 hover:to-purple-700 transition-all duration-300"
                    >
                        Prijavi se
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </Link>
                </div>

                <!-- Stats -->
                <div class="mt-20 grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-8 max-w-3xl mx-auto">
                    <div class="p-4">
                        <div class="text-3xl font-bold text-white">4</div>
                        <div class="mt-1 text-sm text-slate-500">Uloge</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-white">3</div>
                        <div class="mt-1 text-sm text-slate-500">Jezika</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-white">5+</div>
                        <div class="mt-1 text-sm text-slate-500">Tipova sadrzaja</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">100%</div>
                        <div class="mt-1 text-sm text-slate-500">U browseru</div>
                    </div>
                </div>

                <!-- Features -->
                <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="group p-6 rounded-2xl bg-white/[0.03] border border-white/[0.06] hover:bg-white/[0.06] hover:border-white/10 transition-all duration-300">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 border border-blue-500/10 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-1">Python & Pygame</h3>
                        <p class="text-xs text-slate-500">Pisi i pokreci kod direktno u lekciji</p>
                    </div>

                    <div class="group p-6 rounded-2xl bg-white/[0.03] border border-white/[0.06] hover:bg-white/[0.06] hover:border-white/10 transition-all duration-300">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-xl bg-gradient-to-br from-orange-500/20 to-orange-600/10 border border-orange-500/10 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-1">Jupyter Notebook</h3>
                        <p class="text-xs text-slate-500">Interaktivni notebook-ovi sa graficima</p>
                    </div>

                    <div class="group p-6 rounded-2xl bg-white/[0.03] border border-white/[0.06] hover:bg-white/[0.06] hover:border-white/10 transition-all duration-300">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 border border-amber-500/10 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-amber-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.2 2C7.9 2 5.2 4.7 5.2 8c0 .7.1 1.4.3 2H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2h-1.5c.2-.6.3-1.3.3-2 0-3.3-2.7-6-6-6h-1.6zM9 8.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-1">Scratch</h3>
                        <p class="text-xs text-slate-500">Embed-ovani Scratch projekti</p>
                    </div>

                    <div class="group p-6 rounded-2xl bg-white/[0.03] border border-white/[0.06] hover:bg-white/[0.06] hover:border-white/10 transition-all duration-300">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/10 border border-indigo-500/10 mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 0 0 3 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 0 1 1.105.402l2.402 7.206a.75.75 0 0 0 1.105.401l1.444-.889m-8.25.75.213.09a1.687 1.687 0 0 0 2.062-.617l4.45-6.676a1.688 1.688 0 0 1 2.062-.618l.213.09" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-1">LaTeX matematika</h3>
                        <p class="text-xs text-slate-500">Formule i jednacine u lekcijama</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="relative z-10 px-6 py-6 text-center text-xs text-slate-600">
            EduPlatform &copy; {{ new Date().getFullYear() }}
        </footer>
    </div>
</template>
