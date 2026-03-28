<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t, locale } = useTranslations();
const page = usePage();

const sidebarOpen = ref(false);

const user = computed(() => page.props.auth?.user);
const userRole = computed(() => user.value?.role || '');
const impersonationStack = computed(() => page.props.impersonationStack || []);
const isImpersonating = computed(() => impersonationStack.value.length > 0);

const leaveImpersonation = (index) => {
    router.post(route('impersonate.leave', { index }));
};

const notifications = computed(() => page.props.notifications || []);
const unreadCount = computed(() => page.props.unreadNotificationsCount || 0);
const showNotifications = ref(false);

const markAsRead = (notification) => {
    router.post(route('notifications.read', notification.id), {}, { preserveScroll: true });
};

const markAllAsRead = () => {
    router.post(route('notifications.read-all'), {}, { preserveScroll: true });
    showNotifications.value = false;
};

const clearAllNotifications = () => {
    router.delete(route('notifications.clear-all'), { preserveScroll: true });
    showNotifications.value = false;
};

const allSchoolYears = computed(() => page.props.allSchoolYears || []);
const selectedSchoolYearId = computed(() => page.props.selectedSchoolYearId);
const activeSchoolYear = computed(() => page.props.activeSchoolYear);
const showYearSelector = computed(() => ['admin', 'teacher', 'superadmin'].includes(userRole.value) && allSchoolYears.value.length > 1);

const switchSchoolYear = (yearId) => {
    router.post(route('switch-school-year'), { school_year_id: yearId }, { preserveState: false });
};

const unreadMessagesCount = computed(() => page.props.unreadMessagesCount || 0);

const timeAgo = (date) => {
    const seconds = Math.floor((Date.now() - new Date(date)) / 1000);
    if (seconds < 60) return 'just now';
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes}m`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}h`;
    const days = Math.floor(hours / 24);
    return `${days}d`;
};

const navItems = computed(() => {
    const role = userRole.value;

    if (role === 'superadmin') {
        return [
            { label: t('Dashboard'), href: 'dashboard', routeName: 'dashboard', icon: 'dashboard' },
            { label: t('Schools'), href: 'superadmin.schools.index', routeName: 'superadmin.schools.*', icon: 'school' },
            { label: t('Superadmins'), href: 'superadmin.superadmins.index', routeName: 'superadmin.superadmins.*', icon: 'teacher' },
            { label: t('School Years'), href: 'superadmin.school-years.index', routeName: 'superadmin.school-years.*', icon: 'calendar' },
        ];
    }
    if (role === 'admin') {
        return [
            { label: t('Dashboard'), href: 'dashboard', routeName: 'dashboard', icon: 'dashboard' },
            { label: t('Grades'), href: 'admin.grades.index', routeName: 'admin.grades.*', icon: 'grade' },
            { label: t('Courses'), href: 'admin.courses.index', routeName: 'admin.courses.*', icon: 'course' },
            { label: t('Teachers'), href: 'admin.teachers.index', routeName: 'admin.teachers.*', icon: 'teacher' },
            { label: t('Students'), href: 'admin.students.index', routeName: 'admin.students.*', icon: 'student' },
        ];
    }
    if (role === 'teacher') {
        return [
            { label: t('Dashboard'), href: 'dashboard', routeName: 'dashboard', icon: 'dashboard' },
            { label: t('My Courses'), href: 'dashboard', routeName: 'teacher.lessons.*', icon: 'course' },
            { label: t('Submissions'), href: 'teacher.submissions.all', routeName: 'teacher.submissions.*', icon: 'submission' },
            { label: t('Messages'), href: 'messages.inbox', routeName: 'messages.*', icon: 'message' },
        ];
    }
    if (role === 'student') {
        return [
            { label: t('Dashboard'), href: 'dashboard', routeName: 'dashboard', icon: 'dashboard' },
            { label: t('My Courses'), href: 'student.courses.index', routeName: 'student.courses.*', icon: 'course' },
            { label: t('My Submissions'), href: 'student.submissions.all', routeName: 'student.submissions.*', icon: 'submission' },
            { label: t('Messages'), href: 'messages.inbox', routeName: 'messages.*', icon: 'message' },
        ];
    }
    return [
        { label: t('Dashboard'), href: 'dashboard', routeName: 'dashboard', icon: 'dashboard' },
    ];
});

const isActive = (routeName) => {
    try {
        return route().current(routeName);
    } catch {
        return false;
    }
};

const switchLanguage = (lang) => {
    router.post(route('language.update'), { locale: lang }, { preserveState: true, preserveScroll: true });
};

const logout = () => {
    router.post(route('logout'));
};

const closeSidebar = () => {
    sidebarOpen.value = false;
};
</script>

<template>
    <div class="min-h-screen flex bg-gray-50">
        <!-- Mobile sidebar overlay -->
        <Transition
            enter-active-class="transition-opacity duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="sidebarOpen"
                class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"
                @click="closeSidebar"
            />
        </Transition>

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-[260px] flex flex-col',
                'bg-gradient-to-b from-slate-900 to-slate-800',
                'transform transition-transform duration-300 ease-in-out',
                'lg:translate-x-0 lg:static lg:z-auto',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full'
            ]"
        >
            <!-- Brand -->
            <div class="flex items-center gap-3 px-6 py-6 border-b border-slate-700/50">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                    LMS
                </span>
                <!-- Close button (mobile) -->
                <button
                    @click="closeSidebar"
                    class="ml-auto lg:hidden text-slate-400 hover:text-white transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="route(item.href)"
                    @click="closeSidebar"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200',
                        isActive(item.routeName)
                            ? 'bg-slate-700/30 text-white border-l-[3px] border-indigo-500 pl-[9px]'
                            : 'text-slate-300 hover:bg-slate-700/50 hover:text-white border-l-[3px] border-transparent pl-[9px]'
                    ]"
                >
                    <!-- Dashboard icon -->
                    <svg v-if="item.icon === 'dashboard'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <!-- School icon -->
                    <svg v-else-if="item.icon === 'school'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                    <!-- Grade icon -->
                    <svg v-else-if="item.icon === 'grade'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                    <!-- Course icon -->
                    <svg v-else-if="item.icon === 'course'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <!-- Teacher icon -->
                    <svg v-else-if="item.icon === 'teacher'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <!-- Calendar icon -->
                    <svg v-else-if="item.icon === 'calendar'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <!-- Submission icon -->
                    <svg v-else-if="item.icon === 'submission'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <!-- Message icon -->
                    <svg v-else-if="item.icon === 'message'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <!-- Student icon -->
                    <svg v-else-if="item.icon === 'student'" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    <span class="flex-1">{{ item.label }}</span>
                    <span
                        v-if="item.icon === 'message' && unreadMessagesCount > 0"
                        class="flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-red-500 rounded-full"
                    >
                        {{ unreadMessagesCount > 9 ? '9+' : unreadMessagesCount }}
                    </span>
                </Link>
            </nav>

            <!-- Bottom section -->
            <div class="border-t border-slate-700/50 p-4 space-y-3">
                <!-- Language switcher -->
                <div class="flex items-center justify-center gap-1.5">
                    <button
                        v-for="lang in [
                            { code: 'en', label: 'EN' },
                            { code: 'sr', label: 'SR' },
                            { code: 'ro', label: 'RO' }
                        ]"
                        :key="lang.code"
                        @click="switchLanguage(lang.code)"
                        :class="[
                            'px-2.5 py-1 text-xs font-semibold rounded-md transition-all duration-200',
                            locale === lang.code
                                ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25'
                                : 'bg-slate-700/50 text-slate-400 hover:bg-slate-700 hover:text-slate-200'
                        ]"
                    >
                        {{ lang.label }}
                    </button>
                </div>

                <!-- User info -->
                <div class="flex items-center gap-3 px-2">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-semibold shrink-0">
                        {{ user?.name?.charAt(0)?.toUpperCase() }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-white truncate">{{ user?.name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ user?.email }}</p>
                    </div>
                </div>

                <!-- Logout & Profile -->
                <div class="flex gap-2">
                    <Link
                        :href="route('profile.edit')"
                        class="flex-1 flex items-center justify-center gap-2 px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ t('Profile') }}
                    </Link>
                    <button
                        @click="logout"
                        class="flex-1 flex items-center justify-center gap-2 px-3 py-2 text-sm text-slate-300 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all duration-200"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        {{ t('Logout') }}
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
            <!-- Impersonation banners -->
            <div v-if="isImpersonating" class="relative z-40">
                <div
                    v-for="(entry, index) in impersonationStack"
                    :key="index"
                    class="flex items-center justify-between px-4 sm:px-6 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm"
                >
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span class="font-medium">
                            {{ t('Viewing as') }} {{ user?.name }} ({{ user?.role }})
                            <span class="opacity-75">— {{ t('originally') }} {{ entry.name }} ({{ entry.role }})</span>
                        </span>
                    </div>
                    <button
                        @click="leaveImpersonation(index)"
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-semibold transition-colors"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        {{ t('Return to') }} {{ entry.name }}
                    </button>
                </div>
            </div>

            <!-- Top header bar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-200/50">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Hamburger (mobile) -->
                    <button
                        @click="sidebarOpen = true"
                        class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Page title -->
                    <div class="flex-1 ml-4 lg:ml-0">
                        <slot name="header" />
                    </div>

                    <!-- Year selector + Notifications + User info -->
                    <div class="hidden sm:flex items-center gap-3">
                        <!-- School Year selector -->
                        <select
                            v-if="showYearSelector"
                            :value="selectedSchoolYearId"
                            @change="switchSchoolYear($event.target.value)"
                            class="text-xs font-medium border border-gray-200 rounded-lg px-2.5 py-1.5 bg-white text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option v-for="y in allSchoolYears" :key="y.id" :value="y.id">
                                {{ y.name }} {{ y.is_active ? '●' : '' }}
                            </option>
                        </select>
                    </div>
                    <div class="hidden sm:flex items-center gap-3">
                        <!-- Notification bell -->
                        <div class="relative">
                            <button
                                @click="showNotifications = !showNotifications"
                                class="relative p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                <span
                                    v-if="unreadCount > 0"
                                    class="absolute -top-0.5 -right-0.5 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white"
                                >
                                    {{ unreadCount > 9 ? '9+' : unreadCount }}
                                </span>
                            </button>

                            <!-- Dropdown -->
                            <Transition
                                enter-active-class="transition duration-200 ease-out"
                                enter-from-class="opacity-0 scale-95 translate-y-1"
                                enter-to-class="opacity-100 scale-100 translate-y-0"
                                leave-active-class="transition duration-150 ease-in"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >
                                <div v-if="showNotifications" class="absolute right-0 top-full mt-2 w-96 bg-white rounded-xl shadow-xl border border-gray-200/60 overflow-hidden z-50">
                                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ t('Notifications') }}</h3>
                                        <div class="flex items-center gap-3">
                                            <button v-if="unreadCount > 0" @click="markAllAsRead" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                                {{ t('Mark all as read') }}
                                            </button>
                                            <button v-if="notifications.length > 0" @click="clearAllNotifications" class="text-xs text-red-500 hover:text-red-700 font-medium">
                                                {{ t('Clear all') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                                        <button
                                            v-for="n in notifications"
                                            :key="n.id"
                                            @click="markAsRead(n)"
                                            class="w-full px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors text-left"
                                        >
                                            <div :class="[
                                                'w-2 h-2 rounded-full mt-1.5 shrink-0',
                                                n.type === 'submission_received' ? 'bg-amber-400' :
                                                n.type === 'submission_graded' ? 'bg-emerald-400' :
                                                n.type === 'submission_returned' ? 'bg-orange-400' : 'bg-blue-400'
                                            ]" />
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">{{ n.title }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ n.message }}</p>
                                                <p class="text-xs text-gray-400 mt-1">{{ timeAgo(n.created_at) }}</p>
                                            </div>
                                        </button>
                                    </div>

                                    <div v-if="notifications.length === 0" class="px-4 py-8 text-center">
                                        <p class="text-sm text-gray-400">{{ t('No new notifications') }}</p>
                                    </div>
                                </div>
                            </Transition>

                            <!-- Click outside to close -->
                            <div v-if="showNotifications" class="fixed inset-0 z-40" @click="showNotifications = false" />
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-700">{{ user?.name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ userRole }}</p>
                        </div>
                        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-semibold">
                            {{ user?.name?.charAt(0)?.toUpperCase() }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash messages -->
            <FlashMessage />

            <!-- Page content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
