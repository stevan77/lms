<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SchoolYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GradeController extends Controller
{
    public function index(Request $request): Response
    {
        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        $grades = Grade::where('school_id', $school->id)
            ->where('school_year_id', $yearId)
            ->withCount('students', 'courseGrades')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Grades/Index', [
            'grades' => $grades,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Grades/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|max:50',
            'section' => 'nullable|string|max:50',
            'locale' => 'required|string|in:sr,ro,en',
        ]);

        $validated['school_id'] = $request->user()->school_id;
        $validated['school_year_id'] = SchoolYear::active()?->id;

        Grade::create($validated);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade created successfully.');
    }

    public function edit(Request $request, Grade $grade): Response
    {
        abort_if($grade->school_id !== $request->user()->school_id, 403);

        return Inertia::render('Admin/Grades/Edit', [
            'grade' => $grade,
        ]);
    }

    public function update(Request $request, Grade $grade): RedirectResponse
    {
        abort_if($grade->school_id !== $request->user()->school_id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|max:50',
            'section' => 'nullable|string|max:50',
            'locale' => 'required|string|in:sr,ro,en',
        ]);

        $grade->update($validated);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade updated successfully.');
    }

    public function destroy(Request $request, Grade $grade): RedirectResponse
    {
        abort_if($grade->school_id !== $request->user()->school_id, 403);

        $grade->delete();

        return redirect()->route('admin.grades.index')
            ->with('success', 'Grade deleted successfully.');
    }
}
