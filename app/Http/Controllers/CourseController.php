<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\SchoolYear;
use App\Models\Subchapter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseController extends Controller
{
    public function index(Request $request): Response
    {
        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        $courses = Course::where('school_id', $school->id)
            ->with(['courseGrades' => fn ($q) => $q->where(function ($q2) use ($yearId) {
                $q2->whereHas('grade', fn ($g) => $g->where('school_year_id', $yearId))
                    ->orWhere(fn ($q3) => $q3->whereNull('grade_id')->where('school_year_id', $yearId));
            }), 'courseGrades.grade', 'courseGrades.teacher', 'courseGrades.student'])
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function create(Request $request): Response
    {
        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        return Inertia::render('Admin/Courses/Create', [
            'grades' => $school->grades()->where('school_year_id', $yearId)->get(),
            'teachers' => $school->teachers()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['school_id'] = $request->user()->school_id;

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Request $request, Course $course): Response
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        $course->load(['courseGrades' => fn ($q) => $q->where(function ($q2) use ($yearId) {
            $q2->whereHas('grade', fn ($g) => $g->where('school_year_id', $yearId))
                ->orWhere(fn ($q3) => $q3->whereNull('grade_id')->where('school_year_id', $yearId));
        }), 'courseGrades.grade', 'courseGrades.teacher', 'courseGrades.student']);

        return Inertia::render('Admin/Courses/Edit', [
            'course' => $course,
            'grades' => $school->grades()->where('school_year_id', $yearId)->get(),
            'teachers' => $school->teachers()->get(),
            'students' => $school->students()->with('grades:id,name')->orderBy('name')->get(['id', 'name', 'email']),
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Request $request, Course $course): RedirectResponse
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function export(Request $request, Course $course): Response
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $course->load(['chapters.subchapters.lessons']);

        return Inertia::render('Admin/Courses/Export', [
            'course' => $course,
        ]);
    }

    public function exportDownload(Request $request, Course $course): StreamedResponse
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $request->validate([
            'lesson_ids' => 'required|array|min:1',
            'lesson_ids.*' => 'integer|exists:lessons,id',
        ]);

        $selectedLessonIds = collect($request->lesson_ids);

        $course->load(['chapters.subchapters.lessons' => fn ($q) => $q->whereIn('id', $selectedLessonIds)]);

        $chapters = $course->chapters
            ->filter(fn ($ch) => $ch->subchapters->contains(fn ($sub) => $sub->lessons->isNotEmpty()))
            ->values();

        $data = [
            'lms_export_version' => 1,
            'course' => [
                'name' => $course->name,
                'description' => $course->description,
            ],
            'chapters' => $chapters->map(fn ($chapter) => [
                'title' => $chapter->title,
                'order' => $chapter->order,
                'subchapters' => $chapter->subchapters
                    ->filter(fn ($sub) => $sub->lessons->isNotEmpty())
                    ->values()
                    ->map(fn ($sub) => [
                        'title' => $sub->title,
                        'order' => $sub->order,
                        'lessons' => $sub->lessons->map(fn ($lesson) => [
                            'title' => $lesson->title,
                            'content' => $lesson->content,
                            'order' => $lesson->order,
                            'is_assignment' => $lesson->is_assignment,
                        ])->toArray(),
                    ])->toArray(),
            ])->toArray(),
        ];

        $filename = str_replace(' ', '_', $course->name) . '_export.json';

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, ['Content-Type' => 'application/json']);
    }

    public function structure(Request $request, Course $course)
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $chapters = $course->chapters()->with('subchapters')->orderBy('order')->get();

        return response()->json($chapters);
    }

    public function import(Request $request, Course $course): RedirectResponse
    {
        abort_if($course->school_id !== $request->user()->school_id, 403);

        $request->validate([
            'file' => 'required|file|mimes:json,txt|max:10240',
            'merge_map' => 'nullable|string',
        ]);

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if (!$data || !isset($data['lms_export_version']) || !isset($data['chapters'])) {
            return back()->with('error', 'Invalid export file format.');
        }

        $mergeMap = $request->merge_map ? json_decode($request->merge_map, true) : [];
        $mergeChapters = $mergeMap['chapters'] ?? [];
        $mergeSubchapters = $mergeMap['subchapters'] ?? [];

        $maxChapterOrder = $course->chapters()->max('order') ?? 0;

        DB::transaction(function () use ($course, $data, $mergeChapters, $mergeSubchapters, $maxChapterOrder) {
            foreach ($data['chapters'] as $ci => $chapterData) {
                $chapterKey = (string) $ci;

                if (isset($mergeChapters[$chapterKey]) && $mergeChapters[$chapterKey]) {
                    $chapter = Chapter::find($mergeChapters[$chapterKey]);
                } else {
                    $maxChapterOrder++;
                    $chapter = $course->chapters()->create([
                        'title' => $chapterData['title'],
                        'order' => $maxChapterOrder,
                    ]);
                }

                $maxSubOrder = $chapter->subchapters()->max('order') ?? 0;

                foreach ($chapterData['subchapters'] ?? [] as $si => $subData) {
                    $subKey = $ci . '_' . $si;

                    if (isset($mergeSubchapters[$subKey]) && $mergeSubchapters[$subKey]) {
                        $subchapter = Subchapter::find($mergeSubchapters[$subKey]);
                    } else {
                        $maxSubOrder++;
                        $subchapter = $chapter->subchapters()->create([
                            'title' => $subData['title'],
                            'order' => $maxSubOrder,
                        ]);
                    }

                    $maxLessonOrder = $subchapter->lessons()->max('order') ?? 0;

                    foreach ($subData['lessons'] ?? [] as $lessonData) {
                        $maxLessonOrder++;
                        $subchapter->lessons()->create([
                            'course_id' => $course->id,
                            'title' => $lessonData['title'],
                            'content' => $lessonData['content'],
                            'order' => $maxLessonOrder,
                            'is_assignment' => $lessonData['is_assignment'] ?? false,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Course content imported successfully.');
    }
}
