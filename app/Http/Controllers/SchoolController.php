<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class SchoolController extends Controller
{
    public function index(): Response
    {
        $schools = School::with('admins:id,name,email,school_id')
            ->withCount('admins', 'teachers', 'students', 'grades', 'courses')
            ->latest()
            ->paginate(15);

        $allSchools = School::with('courses:id,school_id,name')->get(['id', 'name']);

        return Inertia::render('Superadmin/Schools/Index', [
            'schools' => $schools,
            'allSchools' => $allSchools,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Superadmin/Schools/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        School::create($validated);

        return redirect()->route('superadmin.schools.index')
            ->with('success', 'School created successfully.');
    }

    public function edit(School $school): Response
    {
        return Inertia::render('Superadmin/Schools/Edit', [
            'school' => $school,
        ]);
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        $school->update($validated);

        return redirect()->route('superadmin.schools.index')
            ->with('success', 'School updated successfully.');
    }

    public function destroy(School $school): RedirectResponse
    {
        $school->delete();

        return redirect()->route('superadmin.schools.index')
            ->with('success', 'School deleted successfully.');
    }

    public function assignAdmin(School $school): Response
    {
        $school->load('admins');

        return Inertia::render('Superadmin/Schools/AssignAdmin', [
            'school' => $school,
        ]);
    }

    public function storeAdmin(Request $request, School $school): RedirectResponse
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
            'role' => 'admin',
            'school_id' => $school->id,
        ]);

        return redirect()->route('superadmin.schools.index')
            ->with('success', 'Admin assigned to school successfully.');
    }

    public function copyCourse(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'target_school_id' => 'required|exists:schools,id',
        ]);

        $sourceCourse = Course::with('chapters.subchapters.lessons')->findOrFail($validated['course_id']);

        abort_if($sourceCourse->school_id == $validated['target_school_id'], 422, 'Cannot copy course to the same school.');

        DB::transaction(function () use ($sourceCourse, $validated) {
            $newCourse = Course::create([
                'school_id' => $validated['target_school_id'],
                'name' => $sourceCourse->name,
                'description' => $sourceCourse->description,
            ]);

            foreach ($sourceCourse->chapters as $chapter) {
                $newChapter = $newCourse->chapters()->create([
                    'title' => $chapter->title,
                    'order' => $chapter->order,
                ]);

                foreach ($chapter->subchapters as $subchapter) {
                    $newSubchapter = $newChapter->subchapters()->create([
                        'title' => $subchapter->title,
                        'order' => $subchapter->order,
                    ]);

                    foreach ($subchapter->lessons as $lesson) {
                        $newCourse->lessons()->create([
                            'subchapter_id' => $newSubchapter->id,
                            'title' => $lesson->title,
                            'content' => $lesson->content,
                            'order' => $lesson->order,
                            'is_assignment' => $lesson->is_assignment,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('superadmin.schools.index')
            ->with('success', 'Course copied successfully.');
    }
}
