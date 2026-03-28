<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(Request $request): Response
    {
        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        // Get grade IDs for selected year
        $gradeIds = $school->grades()->where('school_year_id', $yearId)->pluck('id');

        // Get students that belong to those grades
        $studentIds = \DB::table('student_grade')->whereIn('grade_id', $gradeIds)->pluck('student_id')->unique();

        $students = User::whereIn('id', $studentIds)
            ->where('role', 'student')
            ->with(['grades' => fn ($q) => $q->where('school_year_id', $yearId)])
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Students/Index', [
            'students' => $students,
        ]);
    }

    public function create(Request $request): Response
    {
        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        return Inertia::render('Admin/Students/Create', [
            'grades' => $school->grades()->where('school_year_id', $yearId)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'grade_ids' => 'nullable|array',
            'grade_ids.*' => 'exists:grades,id',
        ]);

        $student = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'school_id' => $request->user()->school_id,
        ]);

        if (!empty($validated['grade_ids'])) {
            $student->grades()->attach($validated['grade_ids']);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Request $request, User $student): Response
    {
        abort_if($student->school_id !== $request->user()->school_id || $student->role !== 'student', 403);

        $school = $request->user()->school;
        $yearId = $request->session()->get('selected_school_year_id', SchoolYear::active()?->id);

        $student->load(['grades' => fn ($q) => $q->where('school_year_id', $yearId)]);

        return Inertia::render('Admin/Students/Edit', [
            'student' => $student,
            'grades' => $school->grades()->where('school_year_id', $yearId)->get(),
        ]);
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        abort_if($student->school_id !== $request->user()->school_id || $student->role !== 'student', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'grade_ids' => 'nullable|array',
            'grade_ids.*' => 'exists:grades,id',
            'locale' => 'nullable|string|in:sr,ro,en',
        ]);

        $student->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'locale' => $validated['locale'] ?? $student->locale,
            ...(isset($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        $student->grades()->sync($validated['grade_ids'] ?? []);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Request $request, User $student): RedirectResponse
    {
        abort_if($student->school_id !== $request->user()->school_id || $student->role !== 'student', 403);

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
