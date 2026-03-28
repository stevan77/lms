<?php

namespace App\Http\Controllers;

use App\Models\CourseGrade;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseViewController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $activeYearId = SchoolYear::active()?->id;
        $gradeIds = $user->grades()->where('school_year_id', $activeYearId)->pluck('grades.id');

        // Courses through grade membership
        $gradeAssignments = CourseGrade::whereIn('grade_id', $gradeIds)
            ->with(['course', 'grade', 'teacher'])
            ->get();

        // Courses assigned directly to this student
        $directAssignments = CourseGrade::where('student_id', $user->id)
            ->whereNull('grade_id')
            ->where('school_year_id', $activeYearId)
            ->with(['course', 'teacher'])
            ->get();

        $courseGrades = $gradeAssignments->merge($directAssignments)
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

        return Inertia::render('Student/Courses/Index', [
            'courseGrades' => $courseGrades,
        ]);
    }

    public function show(Request $request, CourseGrade $courseGrade): Response
    {
        $user = $request->user();

        // Verify access: either through grade or direct assignment
        $belongsToGrade = $courseGrade->grade_id && $user->grades()->where('grades.id', $courseGrade->grade_id)->exists();
        $isDirectAssignment = $courseGrade->student_id === $user->id;
        abort_if(!$belongsToGrade && !$isDirectAssignment, 403);

        $courseGrade->load(['course', 'grade', 'teacher']);

        $chapters = $courseGrade->course->chapters()
            ->with(['subchapters.lessons' => fn ($q) => $q->orderBy('order')])
            ->orderBy('order')
            ->get();

        $progressMap = $user->progress()
            ->where('course_grade_id', $courseGrade->id)
            ->pluck('status', 'lesson_id');

        $submissionsMap = \App\Models\Submission::where('student_id', $user->id)
            ->where('course_grade_id', $courseGrade->id)
            ->get()
            ->keyBy('lesson_id');

        return Inertia::render('Student/Courses/Show', [
            'courseGrade' => $courseGrade,
            'chapters' => $chapters,
            'progressMap' => $progressMap,
            'submissionsMap' => $submissionsMap,
        ]);
    }
}
