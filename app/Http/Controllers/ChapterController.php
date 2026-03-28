<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\CourseGrade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $course->id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $validated['course_id'] = $course->id;
        $validated['order'] = $course->chapters()->max('order') + 1;

        Chapter::create($validated);

        return back()->with('success', 'Chapter created successfully.');
    }

    public function update(Request $request, Chapter $chapter): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $chapter->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $chapter->update($validated);

        return back()->with('success', 'Chapter updated successfully.');
    }

    public function destroy(Request $request, Chapter $chapter): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $chapter->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $chapter->delete();

        return back()->with('success', 'Chapter deleted successfully.');
    }
}
