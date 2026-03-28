<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\CourseGrade;
use App\Models\Subchapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubchapterController extends Controller
{
    public function store(Request $request, Chapter $chapter): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $chapter->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $validated['chapter_id'] = $chapter->id;
        $validated['order'] = $chapter->subchapters()->max('order') + 1;

        Subchapter::create($validated);

        return back()->with('success', 'Subchapter created successfully.');
    }

    public function update(Request $request, Subchapter $subchapter): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $subchapter->chapter->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $subchapter->update($validated);

        return back()->with('success', 'Subchapter updated successfully.');
    }

    public function destroy(Request $request, Subchapter $subchapter): RedirectResponse
    {
        abort_if(!CourseGrade::where('course_id', $subchapter->chapter->course_id)->where('teacher_id', $request->user()->id)->exists(), 403);

        $subchapter->delete();

        return back()->with('success', 'Subchapter deleted successfully.');
    }
}
