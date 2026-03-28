<?php

namespace App\Http\Controllers;

use App\Models\CourseGrade;
use App\Models\Grade;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SchoolYearController extends Controller
{
    public function index(): Response
    {
        $schoolYears = SchoolYear::withCount('grades')
            ->latest()
            ->get();

        return Inertia::render('Superadmin/SchoolYears/Index', [
            'schoolYears' => $schoolYears,
        ]);
    }

    public function preview(Request $request): Response
    {
        $activeYear = SchoolYear::active();
        abort_if(!$activeYear, 404, 'No active school year found.');

        // Build preview data per school
        $schools = School::with(['grades' => function ($q) use ($activeYear) {
            $q->where('school_year_id', $activeYear->id)
              ->withCount('students');
        }])->get();

        $preview = $schools->map(function ($school) {
            $transitions = [];
            $graduatingCount = 0;

            foreach ($school->grades as $grade) {
                $newLevel = $grade->level + 1;
                if ($newLevel > 8) {
                    $graduatingCount += $grade->students_count;
                    $transitions[] = [
                        'from' => $grade->name,
                        'to' => null,
                        'action' => 'graduate',
                        'students_count' => $grade->students_count,
                        'level' => $grade->level,
                        'section' => $grade->section,
                    ];
                } else {
                    $newName = $newLevel . '-' . $grade->section;
                    $transitions[] = [
                        'from' => $grade->name,
                        'to' => $newName,
                        'action' => 'promote',
                        'students_count' => $grade->students_count,
                        'level' => $grade->level,
                        'section' => $grade->section,
                    ];
                }
            }

            return [
                'school' => $school->only('id', 'name'),
                'transitions' => $transitions,
                'graduating_count' => $graduatingCount,
                'total_students' => $school->grades->sum('students_count'),
            ];
        });

        // Next year name
        $parts = explode('/', $activeYear->name);
        $nextName = ((int)$parts[0] + 1) . '/' . ((int)$parts[1] + 1);

        return Inertia::render('Superadmin/SchoolYears/Preview', [
            'activeYear' => $activeYear,
            'nextYearName' => $nextName,
            'schools' => $preview,
            'totalSchools' => $schools->count(),
            'totalGraduating' => $preview->sum('graduating_count'),
            'totalStudents' => $preview->sum('total_students'),
        ]);
    }

    public function closeYear(Request $request): RedirectResponse
    {
        $activeYear = SchoolYear::active();
        abort_if(!$activeYear, 404, 'No active school year found.');

        // Calculate next year name
        $parts = explode('/', $activeYear->name);
        $nextName = ((int)$parts[0] + 1) . '/' . ((int)$parts[1] + 1);

        // Create new school year
        $newYear = SchoolYear::create([
            'name' => $nextName,
            'start_date' => $activeYear->start_date?->addYear(),
            'end_date' => $activeYear->end_date?->addYear(),
            'is_active' => true,
            'created_by' => $request->user()->id,
        ]);

        // Lock and deactivate old year
        $activeYear->update(['is_active' => false, 'is_locked' => true]);

        // Process each school
        $schools = School::with(['grades' => function ($q) use ($activeYear) {
            $q->where('school_year_id', $activeYear->id)->with(['students', 'courseGrades']);
        }])->get();

        foreach ($schools as $school) {
            foreach ($school->grades as $oldGrade) {
                $newLevel = $oldGrade->level + 1;

                if ($newLevel > 8) {
                    // Graduate 8th grade students
                    $oldGrade->students()->update(['student_status' => 'graduated']);
                } else {
                    // Create new grade for next year
                    $newGrade = Grade::create([
                        'school_id' => $school->id,
                        'school_year_id' => $newYear->id,
                        'name' => $newLevel . '-' . $oldGrade->section,
                        'level' => $newLevel,
                        'section' => $oldGrade->section,
                        'locale' => $oldGrade->locale,
                        'enrollment_token' => Str::random(32),
                    ]);

                    // Move students to new grade
                    $studentIds = $oldGrade->students()->pluck('users.id');
                    foreach ($studentIds as $studentId) {
                        $newGrade->students()->attach($studentId);
                    }

                    // Copy course assignments to new grade (same courses, same teachers)
                    foreach ($oldGrade->courseGrades as $cg) {
                        CourseGrade::firstOrCreate([
                            'course_id' => $cg->course_id,
                            'grade_id' => $newGrade->id,
                        ], [
                            'teacher_id' => $cg->teacher_id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('superadmin.school-years.index')
            ->with('success', "School year {$activeYear->name} closed. New year {$nextName} is now active.");
    }
}
