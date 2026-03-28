<script setup>
import { ref, computed, watch } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputField from '@/Components/InputField.vue';
import SelectField from '@/Components/SelectField.vue';
import ButtonPrimary from '@/Components/ButtonPrimary.vue';
import ButtonSecondary from '@/Components/ButtonSecondary.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { useTranslations } from '@/Composables/useTranslations.js';

const { t } = useTranslations();

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    grades: {
        type: Array,
        required: true,
    },
    teachers: {
        type: Array,
        required: true,
    },
    students: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: props.course.name,
    description: props.course.description || '',
});

const assignmentForm = useForm({
    course_id: props.course.id,
    grade_id: '',
    teacher_id: '',
});

const studentAssignmentForm = useForm({
    course_id: props.course.id,
    student_id: '',
    teacher_id: '',
});

const studentFilterGradeId = ref('');

const gradeOptions = props.grades.map((g) => ({ value: g.id, label: g.name }));
const teacherOptions = props.teachers.map((t) => ({ value: t.id, label: t.name }));
const filteredStudentOptions = computed(() => {
    let students = props.students;
    if (studentFilterGradeId.value) {
        students = students.filter(s => s.grades?.some(g => g.id == studentFilterGradeId.value));
    }
    return students.map((s) => ({ value: s.id, label: `${s.name} (${s.email})` }));
});

watch(studentFilterGradeId, () => {
    studentAssignmentForm.student_id = '';
});

const gradeAssignments = computed(() => props.course.course_grades?.filter(cg => cg.grade_id) || []);
const studentAssignments = computed(() => props.course.course_grades?.filter(cg => cg.student_id) || []);

const showDeleteAssignmentModal = ref(false);
const assignmentToDelete = ref(null);

const submitCourse = () => {
    form.put(route('admin.courses.update', props.course.id));
};

const addAssignment = () => {
    assignmentForm.post(route('admin.course-grades.store'), {
        preserveScroll: true,
        onSuccess: () => {
            assignmentForm.grade_id = '';
            assignmentForm.teacher_id = '';
        },
    });
};

const confirmDeleteAssignment = (cg) => {
    assignmentToDelete.value = cg;
    showDeleteAssignmentModal.value = true;
};

const addStudentAssignment = () => {
    studentAssignmentForm.post(route('admin.course-grades.store'), {
        preserveScroll: true,
        onSuccess: () => {
            studentAssignmentForm.student_id = '';
            studentAssignmentForm.teacher_id = '';
        },
    });
};

const deleteAssignment = () => {
    router.delete(route('admin.course-grades.destroy', assignmentToDelete.value.id), {
        preserveScroll: true,
        onFinish: () => {
            showDeleteAssignmentModal.value = false;
            assignmentToDelete.value = null;
        },
    });
};
</script>

<template>
    <Head :title="t('Edit Course')" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('Edit Course') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ t('Update course information and assignments') }}</p>
            </div>
        </template>

        <div class="max-w-2xl space-y-6">
            <!-- Course Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ t('Course Details') }}</h3>
                <form @submit.prevent="submitCourse" class="space-y-5">
                    <InputField
                        v-model="form.name"
                        :label="t('Name')"
                        :placeholder="t('Enter course name')"
                        :error="form.errors.name"
                    />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ t('Description') }}</label>
                        <textarea
                            v-model="form.description"
                            :placeholder="t('Enter course description')"
                            rows="3"
                            class="block w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 outline-none focus:ring-2 focus:ring-offset-0 focus:border-indigo-400 focus:ring-indigo-200 bg-white"
                        />
                        <p v-if="form.errors.description" class="mt-1.5 text-xs text-red-500 font-medium">{{ form.errors.description }}</p>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <ButtonPrimary type="submit" :loading="form.processing" :disabled="form.processing">
                            {{ t('Update Course') }}
                        </ButtonPrimary>
                        <Link :href="route('admin.courses.index')">
                            <ButtonSecondary>{{ t('Cancel') }}</ButtonSecondary>
                        </Link>
                    </div>
                </form>
            </div>

            <!-- Grade Assignments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ t('Grade Assignments') }}</h3>

                <div v-if="gradeAssignments.length" class="space-y-3 mb-6">
                    <div
                        v-for="cg in gradeAssignments"
                        :key="cg.id"
                        class="flex items-center justify-between p-4 bg-gray-50 rounded-xl"
                    >
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border border-indigo-100">
                                {{ cg.grade?.name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                            <span class="text-sm text-gray-700 font-medium">{{ cg.teacher?.name }}</span>
                        </div>
                        <ButtonDanger @click="confirmDeleteAssignment(cg)">
                            {{ t('Remove') }}
                        </ButtonDanger>
                    </div>
                </div>
                <div v-else class="text-center py-6 bg-gray-50 rounded-xl mb-6">
                    <p class="text-sm text-gray-500">{{ t('No grade assignments yet.') }}</p>
                </div>

                <!-- Add New Grade Assignment -->
                <div class="pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">{{ t('Add New Assignment') }}</h4>
                    <div class="flex items-end gap-3">
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <SelectField
                                v-model="assignmentForm.grade_id"
                                :label="t('Grade')"
                                :options="gradeOptions"
                                :placeholder="t('Select grade')"
                                :error="assignmentForm.errors.grade_id"
                            />
                            <SelectField
                                v-model="assignmentForm.teacher_id"
                                :label="t('Teacher')"
                                :options="teacherOptions"
                                :placeholder="t('Select teacher')"
                                :error="assignmentForm.errors.teacher_id"
                            />
                        </div>
                        <ButtonPrimary
                            type="button"
                            @click="addAssignment"
                            :loading="assignmentForm.processing"
                            :disabled="assignmentForm.processing"
                        >
                            {{ t('Add') }}
                        </ButtonPrimary>
                    </div>
                </div>
            </div>

            <!-- Student Assignments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/60 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ t('Student Assignments') }}</h3>

                <div v-if="studentAssignments.length" class="space-y-3 mb-6">
                    <div
                        v-for="cg in studentAssignments"
                        :key="cg.id"
                        class="flex items-center justify-between p-4 bg-gray-50 rounded-xl"
                    >
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 border border-emerald-100">
                                {{ cg.student?.name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                            <span class="text-sm text-gray-700 font-medium">{{ cg.teacher?.name }}</span>
                        </div>
                        <ButtonDanger @click="confirmDeleteAssignment(cg)">
                            {{ t('Remove') }}
                        </ButtonDanger>
                    </div>
                </div>
                <div v-else class="text-center py-6 bg-gray-50 rounded-xl mb-6">
                    <p class="text-sm text-gray-500">{{ t('No student assignments yet.') }}</p>
                </div>

                <!-- Add New Student Assignment -->
                <div class="pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">{{ t('Add New Student Assignment') }}</h4>
                    <div class="mb-3">
                        <SelectField
                            v-model="studentFilterGradeId"
                            :label="t('Filter by grade')"
                            :options="gradeOptions"
                            :placeholder="t('All students')"
                        />
                    </div>
                    <div class="flex items-end gap-3">
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <SelectField
                                v-model="studentAssignmentForm.student_id"
                                :label="t('Student')"
                                :options="filteredStudentOptions"
                                :placeholder="t('Select student')"
                                :error="studentAssignmentForm.errors.student_id"
                            />
                            <SelectField
                                v-model="studentAssignmentForm.teacher_id"
                                :label="t('Teacher')"
                                :options="teacherOptions"
                                :placeholder="t('Select teacher')"
                                :error="studentAssignmentForm.errors.teacher_id"
                            />
                        </div>
                        <ButtonPrimary
                            type="button"
                            @click="addStudentAssignment"
                            :loading="studentAssignmentForm.processing"
                            :disabled="studentAssignmentForm.processing"
                        >
                            {{ t('Add') }}
                        </ButtonPrimary>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Assignment Confirm Modal -->
        <DeleteConfirmModal
            :show="showDeleteAssignmentModal"
            :title="t('Remove Assignment')"
            :message="t('Are you sure you want to remove this grade-teacher assignment? This action cannot be undone.')"
            @close="showDeleteAssignmentModal = false"
            @confirm="deleteAssignment"
        />
    </AuthenticatedLayout>
</template>
