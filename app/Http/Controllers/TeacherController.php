<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class TeacherController extends Controller
{
    public function index(Request $request): Response
    {
        $school = $request->user()->school;

        $teachers = User::where('school_id', $school->id)
            ->where('role', 'teacher')
            ->withCount('teachingAssignments')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Teachers/Index', [
            'teachers' => $teachers,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Teachers/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'school_id' => $request->user()->school_id,
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function edit(Request $request, User $teacher): Response
    {
        abort_if($teacher->school_id !== $request->user()->school_id || $teacher->role !== 'teacher', 403);

        return Inertia::render('Admin/Teachers/Edit', [
            'teacher' => $teacher,
        ]);
    }

    public function update(Request $request, User $teacher): RedirectResponse
    {
        abort_if($teacher->school_id !== $request->user()->school_id || $teacher->role !== 'teacher', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $teacher->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $teacher->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...(isset($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Request $request, User $teacher): RedirectResponse
    {
        abort_if($teacher->school_id !== $request->user()->school_id || $teacher->role !== 'teacher', 403);

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
