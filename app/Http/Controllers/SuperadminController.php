<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class SuperadminController extends Controller
{
    public function index(): Response
    {
        $superadmins = User::where('role', 'superadmin')
            ->latest()
            ->paginate(15);

        return Inertia::render('Superadmin/Superadmins/Index', [
            'superadmins' => $superadmins,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Superadmin/Superadmins/Create');
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
            'role' => 'superadmin',
        ]);

        return redirect()->route('superadmin.superadmins.index')
            ->with('success', 'Superadmin created successfully.');
    }

    public function destroy(User $superadmin): RedirectResponse
    {
        abort_if($superadmin->role !== 'superadmin', 403);
        abort_if($superadmin->id === auth()->id(), 403, 'You cannot delete yourself.');

        $superadmin->delete();

        return redirect()->route('superadmin.superadmins.index')
            ->with('success', 'Superadmin deleted successfully.');
    }
}
