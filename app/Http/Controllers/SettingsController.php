<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    // Display the settings page
    public function showSettingsPage()
    {
        return view('settings');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        // Validate email
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Check if email has changed
        if ($request->email !== $user->email) {
            $user->email = $request->email;
        }

        // Validate password
        if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('new_password_confirmation')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'new_password' => [
                    'required',
                    'string',
                    'min:8', // must be at least 8 characters in length
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[0-9]/', // must contain at least one digit
                    'regex:/[@$!%*?&]/', // must contain a special character
                    'confirmed'
                ],
            ]);

            // Check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('settings')->with('success', 'Settings updated successfully');
    }

    public function checkPassword(Request $request)
    {
        $currentPassword = $request->input('current_password');
        if (Hash::check($currentPassword, Auth::user()->password)) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false]);
        }
    }


    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        // Update the user's status to inactive
        $user->status = 0;
        $user->save();

        // Log the user out
        Auth::logout();

        return redirect()->route('home')->with('success', 'Your account has been deactivated successfully.');
    }
}
