<?php

namespace App\Http\Controllers;

use App\Models\CourseGrade;
use App\Models\SchoolYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseGradeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'grade_id' => 'required_without:student_id|nullable|exists:grades,id',
            'student_id' => 'required_without:grade_id|nullable|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        // For individual student assignments, store the school year
        if (!empty($validated['student_id']) && empty($validated['grade_id'])) {
            $validated['school_year_id'] = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);
        }

        CourseGrade::create($validated);

        return back()->with('success', 'Assignment created successfully.');
    }

    public function destroy(Request $request, CourseGrade $courseGrade): RedirectResponse
    {
        $courseGrade->delete();

        return back()->with('success', 'Assignment removed successfully.');
    }
}
