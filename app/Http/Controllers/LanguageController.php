<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => 'required|string|in:en,sr,ro',
        ]);

        $request->user()->update([
            'locale' => $validated['locale'],
        ]);

        return back()->with('success', 'Language updated successfully.');
    }
}
