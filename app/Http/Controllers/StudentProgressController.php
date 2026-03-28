<?php

namespace App\Http\Controllers;

use App\Models\CourseGrade;
use App\Models\Lesson;
use App\Models\StudentProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentProgressController extends Controller
{
    public function index(Request $request, CourseGrade $courseGrade): Response
    {
        abort_if($courseGrade->teacher_id !== $request->user()->id, 403);

        $courseGrade->load(['course.lessons', 'grade', 'student']);

        if ($courseGrade->student_id) {
            $students = collect([$courseGrade->student->load(['progress' => function ($query) use ($courseGrade) {
                $query->where('course_grade_id', $courseGrade->id);
            }])]);
        } else {
            $students = $courseGrade->grade->students()
                ->with(['progress' => function ($query) use ($courseGrade) {
                    $query->where('course_grade_id', $courseGrade->id);
                }])
                ->get();
        }

        return Inertia::render('Teacher/Progress/Index', [
            'courseGrade' => $courseGrade,
            'students' => $students,
            'lessons' => $courseGrade->course->lessons,
        ]);
    }

    public function update(Request $request, Lesson $lesson, CourseGrade $courseGrade): RedirectResponse
    {
        $user = $request->user();

        $belongsToGrade = $courseGrade->grade_id && $user->grades()->where('grades.id', $courseGrade->grade_id)->exists();
        $isDirectAssignment = $courseGrade->student_id === $user->id;
        abort_if(!$belongsToGrade && !$isDirectAssignment, 403);

        $requestedStatus = $request->input('status', 'completed');

        $existing = StudentProgress::where([
            'student_id' => $user->id,
            'lesson_id' => $lesson->id,
            'course_grade_id' => $courseGrade->id,
        ])->first();

        // Don't auto-downgrade when opening a lesson, but allow explicit undo
        if ($existing && $existing->status === 'completed' && $requestedStatus === 'in_progress' && !$request->boolean('force')) {
            return back();
        }

        $data = ['status' => $requestedStatus];
        if ($requestedStatus === 'completed') {
            $data['completed_at'] = now();
        }

        StudentProgress::updateOrCreate(
            [
                'student_id' => $user->id,
                'lesson_id' => $lesson->id,
                'course_grade_id' => $courseGrade->id,
            ],
            $data
        );

        if ($requestedStatus === 'completed') {
            return back()->with('success', 'Lesson marked as completed.');
        }

        return back();
    }
}
