<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Handle password change.
     * Route: POST /settings  →  settings.update
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'new_password.min'       => 'The new password must be at least 8 characters.',
            'new_password.confirmed' => 'The new password and confirmation do not match.',
        ]);

        $user = Auth::user();

        // Verify current password
        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Your current password is incorrect.'])
                ->withInput();
        }

        // Prevent reusing the same password
        if (Hash::check($request->new_password, $user->password)) {
            return back()
                ->withErrors(['new_password' => 'The new password cannot be the same as your old password.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Your password has been updated successfully.');
    }
}