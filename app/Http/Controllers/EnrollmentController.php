<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class EnrollmentController extends Controller
{
    public function show(string $token): Response
    {
        $grade = Grade::where('enrollment_token', $token)
            ->with('school')
            ->firstOrFail();

        return Inertia::render('Auth/Enroll', [
            'grade' => $grade,
            'school' => $grade->school,
            'token' => $token,
        ]);
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        $grade = Grade::where('enrollment_token', $token)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'school_id' => $grade->school_id,
            'locale' => $grade->locale ?? 'sr',
        ]);

        $user->grades()->attach($grade->id);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
