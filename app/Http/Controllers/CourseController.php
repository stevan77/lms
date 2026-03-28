<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
}
