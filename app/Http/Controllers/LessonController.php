<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\CourseGrade;
use App\Models\Lesson;
use App\Models\Subchapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LessonController extends Controller
{
    public function index(Request $request, Course $course): Response
    {
        $assignments = CourseGrade::where('course_id', $course->id)
            ->where('teacher_id', $request->user()->id)
            ->with('grade')
            ->get();

        abort_if($assignments->isEmpty(), 403);

        $chapters = $course->chapters()
            ->with(['subchapters.lessons' => fn ($q) => $q->orderBy('order')])
            ->orderBy('order')
            ->get();

        return Inertia::render('Teacher/Lessons/Index', [
            'course' => $course,
            'chapters' => $chapters,
            'grades' => $assignments->filter(fn ($cg) => $cg->grade_id)->map(fn ($cg) => [
                'id' => $cg->grade->id,
                'name' => $cg->grade->name,
                'course_grade_id' => $cg->id,
            ])->values(),
        ]);
    }

    public function create(Request $request, Subchapter $subchapter): Response
    {
        $chapter = $subchapter->chapter;
        $course = $chapter->course;

        abort_if(!CourseGrade::where('course_id', $course->id)->where('teacher_id', $request->user()->id)->exists(), 403);

        return Inertia::render('Teacher/Lessons/Create', [
            'course' => $course,
            'chapter' => $chapter,
            'subchapter' => $subchapter,
        ]);
    }

    public function store(Request $request, Subchapter $subchapter): RedirectResponse
    {
        $chapter = $subchapter->chapter;
        $course = $chapter->course;

        abort_if(!CourseGrade::where('course_id', $course->id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_assignment' => 'boolean',
        ]);

        $validated['is_assignment'] = $request->boolean('is_assignment');
        $validated['subchapter_id'] = $subchapter->id;
        $validated['course_id'] = $course->id;

        if (!isset($validated['order'])) {
            $validated['order'] = $subchapter->lessons()->max('order') + 1;
        }

        Lesson::create($validated);

        return redirect()->route('teacher.lessons.index', $course)
            ->with('success', 'Lesson created successfully.');
    }

    public function edit(Request $request, Lesson $lesson): Response
    {
        abort_if(!CourseGrade::where('course_id', $lesson->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $lesson->load('subchapter.chapter');

        return Inertia::render('Teacher/Lessons/Edit', [
            'lesson' => $lesson,
            'course' => $lesson->course,
            'chapter' => $lesson->subchapter->chapter,
            'subchapter' => $lesson->subchapter,
        ]);
    }

    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $lesson->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_assignment' => 'boolean',
        ]);

        $validated['is_assignment'] = $request->boolean('is_assignment');

        $lesson->update($validated);

        return redirect()->route('teacher.lessons.index', $lesson->course_id)
            ->with('success', 'Lesson updated successfully.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:chapters,subchapters,lessons',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $model = match ($validated['type']) {
            'chapters' => Chapter::class,
            'subchapters' => Subchapter::class,
            'lessons' => Lesson::class,
        };

        foreach ($validated['ids'] as $order => $id) {
            $model::where('id', $id)->update(['order' => $order + 1]);
        }

        return back();
    }

    public function destroy(Request $request, Lesson $lesson): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $lesson->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()->route('teacher.lessons.index', $courseId)
            ->with('success', 'Lesson deleted successfully.');
    }
}
