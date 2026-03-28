<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(Request $request, User $user): RedirectResponse
    {
        $currentUser = $request->user();

        // Superadmin can impersonate admin
        // Admin can impersonate teacher or student (in their school)
        // Also: if currently impersonating as admin (original is superadmin), can go deeper
        $allowed = false;

        if ($currentUser->role === 'superadmin' && $user->role === 'admin') {
            $allowed = true;
        }

        if ($currentUser->role === 'admin' && in_array($user->role, ['teacher', 'student'])) {
            // Admin can only impersonate users from their own school
            if ($currentUser->school_id === $user->school_id) {
                $allowed = true;
            }
        }

        abort_if(!$allowed, 403, 'You cannot impersonate this user.');

        // Push current user onto the impersonation stack
        $stack = $request->session()->get('impersonation_stack', []);
        $stack[] = [
            'id' => $currentUser->id,
            'name' => $currentUser->name,
            'role' => $currentUser->role,
        ];
        $request->session()->put('impersonation_stack', $stack);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function leave(Request $request, int $index = null): RedirectResponse
    {
        $stack = $request->session()->get('impersonation_stack', []);

        if (empty($stack)) {
            abort(403, 'Not impersonating anyone.');
        }

        if ($index !== null && isset($stack[$index])) {
            // Return to specific level - pop everything from that index onwards
            $target = $stack[$index];
            $stack = array_slice($stack, 0, $index);
        } else {
            // Return to the previous level (pop last)
            $target = array_pop($stack);
        }

        $request->session()->put('impersonation_stack', $stack);

        if (empty($stack)) {
            $request->session()->forget('impersonation_stack');
        }

        $user = User::findOrFail($target['id']);
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
