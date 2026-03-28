<?php

namespace App\Http\Controllers;

use App\Models\CourseGrade;
use App\Models\Lesson;
use App\Models\Notification;
use App\Models\SchoolYear;
use App\Models\StudentProgress;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SubmissionController extends Controller
{
    public function all(Request $request): Response
    {
        $user = $request->user();
        $yearId = session('selected_school_year_id', SchoolYear::active()?->id);

        // Get all courseGrade IDs this teacher is assigned to (current school year)
        $courseGradeIds = $user->teachingAssignments()
            ->where(function ($q) use ($yearId) {
                $q->whereHas('grade', fn ($g) => $g->where('school_year_id', $yearId))
                  ->orWhere(fn ($q2) => $q2->whereNull('grade_id')->where('school_year_id', $yearId));
            })
            ->pluck('id');

        $submissions = Submission::whereIn('course_grade_id', $courseGradeIds)
            ->with(['student:id,name,email', 'lesson:id,title', 'courseGrade.course:id,name', 'courseGrade.grade:id,name', 'courseGrade.student:id,name'])
            ->latest('submitted_at')
            ->get();

        // Get grades for filter dropdown
        $grades = $user->teachingAssignments()
            ->whereHas('grade', fn ($q) => $q->where('school_year_id', $yearId))
            ->with('grade:id,name')
            ->get()
            ->pluck('grade')
            ->unique('id')
            ->values();

        return Inertia::render('Teacher/Submissions/All', [
            'submissions' => $submissions,
            'grades' => $grades,
        ]);
    }

    public function studentAll(Request $request): Response
    {
        $user = $request->user();

        $submissions = Submission::where('student_id', $user->id)
            ->with(['lesson:id,title', 'courseGrade.course:id,name'])
            ->latest('submitted_at')
            ->get();

        // Get unique courses for filter
        $courses = $submissions->pluck('courseGrade.course')->filter()->unique('id')->values();

        return Inertia::render('Student/Submissions/All', [
            'submissions' => $submissions,
            'courses' => $courses,
        ]);
    }

    public function store(Request $request, Lesson $lesson, CourseGrade $courseGrade): RedirectResponse
    {
        $user = $request->user();

        $belongsToGrade = $courseGrade->grade_id && $user->grades()->where('grades.id', $courseGrade->grade_id)->exists();
        $isDirectAssignment = $courseGrade->student_id === $user->id;
        abort_if(!$belongsToGrade && !$isDirectAssignment, 403);
        abort_if(!$lesson->is_assignment, 403);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        Submission::updateOrCreate(
            [
                'student_id' => $user->id,
                'lesson_id' => $lesson->id,
                'course_grade_id' => $courseGrade->id,
            ],
            [
                'content' => $validated['content'],
                'status' => 'submitted',
                'submitted_at' => now(),
                'grade' => null,
                'feedback' => null,
                'reviewed_at' => null,
            ]
        );

        // Notify teacher
        $courseGrade->load(['course', 'grade']);
        Notification::send(
            $courseGrade->teacher_id,
            'submission_received',
            'Nova predaja zadatka',
            "{$user->name} je predao/la zadatak \"{$lesson->title}\"" . ($courseGrade->grade ? " ({$courseGrade->grade->name})" : ''),
            route('teacher.submissions.index', [$lesson->id, $courseGrade->id])
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }

    public function index(Request $request, Lesson $lesson, CourseGrade $courseGrade): Response
    {
        abort_if($courseGrade->teacher_id !== $request->user()->id, 403);

        $submissions = Submission::where('lesson_id', $lesson->id)
            ->where('course_grade_id', $courseGrade->id)
            ->with('student:id,name,email')
            ->latest('submitted_at')
            ->get();

        $submittedIds = $submissions->pluck('student_id');
        if ($courseGrade->student_id) {
            $allStudents = collect([$courseGrade->student]);
        } else {
            $allStudents = $courseGrade->grade->students()->get();
        }
        $notSubmitted = $allStudents->whereNotIn('id', $submittedIds);

        return Inertia::render('Teacher/Submissions/Index', [
            'lesson' => $lesson,
            'courseGrade' => $courseGrade->load(['course', 'grade', 'student']),
            'submissions' => $submissions,
            'notSubmitted' => $notSubmitted->values(),
        ]);
    }

    public function update(Request $request, Submission $submission): RedirectResponse
    {
        $courseGrade = $submission->courseGrade;
        abort_if($courseGrade->teacher_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'grade' => 'nullable|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:2000',
            'status' => 'required|in:reviewed,graded,returned',
        ]);

        $submission->update([
            ...$validated,
            'reviewed_at' => now(),
        ]);

        // Notify student
        $lesson = $submission->lesson;
        $teacher = $request->user();

        // Mark lesson as completed when graded
        if ($validated['status'] === 'graded') {
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $submission->student_id,
                    'lesson_id' => $lesson->id,
                    'course_grade_id' => $courseGrade->id,
                ],
                [
                    'status' => 'completed',
                    'completed_at' => now(),
                ]
            );

            Notification::send(
                $submission->student_id,
                'submission_graded',
                'Zadatak ocenjen',
                "Nastavnik {$teacher->name} je ocenio zadatak \"{$lesson->title}\" — ocena: {$validated['grade']}/5",
                route('student.courses.show', $courseGrade->id)
            );
        } elseif ($validated['status'] === 'returned') {
            // Reset progress so student sees the lesson as "in progress" again
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $submission->student_id,
                    'lesson_id' => $lesson->id,
                    'course_grade_id' => $courseGrade->id,
                ],
                [
                    'status' => 'in_progress',
                    'completed_at' => null,
                ]
            );

            Notification::send(
                $submission->student_id,
                'submission_returned',
                'Zadatak vraćen na doradu',
                "Nastavnik {$teacher->name} je vratio zadatak \"{$lesson->title}\" na doradu" . ($validated['feedback'] ? ": {$validated['feedback']}" : ''),
                route('student.courses.show', $courseGrade->id)
            );
        } elseif ($validated['status'] === 'reviewed') {
            Notification::send(
                $submission->student_id,
                'submission_reviewed',
                'Zadatak pregledan',
                "Nastavnik {$teacher->name} je pregledao zadatak \"{$lesson->title}\"",
                route('student.courses.show', $courseGrade->id)
            );
        }

        return back()->with('success', 'Submission updated successfully.');
    }
}
