<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        return match ($user->role) {
            'superadmin' => $this->superadminDashboard(),
            'admin' => $this->adminDashboard($user),
            'teacher' => $this->teacherDashboard($user),
            'student' => $this->studentDashboard($user),
            default => Inertia::render('Dashboard'),
        };
    }

    private function superadminDashboard(): Response
    {
        return Inertia::render('Superadmin/Dashboard', [
            'totalSchools' => School::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalTeachers' => User::where('role', 'teacher')->count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'recentSchools' => School::withCount('admins', 'teachers', 'students')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    private function adminDashboard(User $user): Response
    {
        $school = $user->school;
        $yearId = session('selected_school_year_id', SchoolYear::active()?->id);

        $gradeIds = $school->grades()->where('school_year_id', $yearId)->pluck('id');

        return Inertia::render('Admin/Dashboard', [
            'school' => $school,
            'totalGrades' => $gradeIds->count(),
            'totalCourses' => $school->courses()->count(),
            'totalTeachers' => $school->teachers()->count(),
            'totalStudents' => \DB::table('student_grade')->whereIn('grade_id', $gradeIds)->distinct('student_id')->count('student_id'),
        ]);
    }

    private function teacherDashboard(User $user): Response
    {
        $yearId = session('selected_school_year_id', SchoolYear::active()?->id);

        $assignments = $user->teachingAssignments()
            ->where(function ($q) use ($yearId) {
                $q->whereHas('grade', fn ($g) => $g->where('school_year_id', $yearId))
                  ->orWhere(fn ($q2) => $q2->whereNull('grade_id')->where('school_year_id', $yearId));
            })
            ->with(['course.chapters.subchapters.lessons', 'grade', 'student'])
            ->get();

        // Group by course - each course shows all its grades
        $courses = $assignments->groupBy('course_id')->map(function ($group) {
            $course = $group->first()->course;
            return [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'lessons_count' => $course->chapters->sum(fn ($ch) => $ch->subchapters->sum(fn ($sc) => $sc->lessons->count())),
                'grades' => $group->filter(fn ($cg) => $cg->grade_id)->map(fn ($cg) => [
                    'id' => $cg->grade->id,
                    'name' => $cg->grade->name,
                    'course_grade_id' => $cg->id,
                ])->values(),
                'students' => $group->filter(fn ($cg) => $cg->student_id)->map(fn ($cg) => [
                    'id' => $cg->student->id,
                    'name' => $cg->student->name,
                    'course_grade_id' => $cg->id,
                ])->values(),
                'total_students' => $group->sum(function ($cg) {
                    return $cg->grade_id ? $cg->grade->students()->count() : 1;
                }),
            ];
        })->values();

        return Inertia::render('Teacher/Dashboard', [
            'courses' => $courses,
        ]);
    }

    private function studentDashboard(User $user): Response
    {
        $activeYearId = SchoolYear::active()?->id;
        $gradeIds = $user->grades()
            ->where('school_year_id', $activeYearId)
            ->pluck('grades.id');

        $courseGrades = \App\Models\CourseGrade::where(function ($q) use ($gradeIds, $user, $activeYearId) {
                $q->whereIn('grade_id', $gradeIds)
                  ->orWhere(fn ($q2) => $q2->where('student_id', $user->id)->whereNull('grade_id')->where('school_year_id', $activeYearId));
            })
            ->with(['course', 'grade'])
            ->get()
            ->map(function ($courseGrade) use ($user) {
                $totalLessons = $courseGrade->course->lessons()->count();
                $completedLessons = $user->progress()
                    ->where('course_grade_id', $courseGrade->id)
                    ->where('status', 'completed')
                    ->count();

                $courseGrade->total_lessons = $totalLessons;
                $courseGrade->completed_lessons = $completedLessons;
                $courseGrade->progress_percentage = $totalLessons > 0
                    ? round(($completedLessons / $totalLessons) * 100)
                    : 0;

                return $courseGrade;
            });

        return Inertia::render('Student/Dashboard', [
            'courseGrades' => $courseGrades,
        ]);
    }
}
