<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('profile.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $request->validate([
            'first_name' => 'string|nullable',
            'company_name' => 'string|nullable',
            'position' => 'string|nullable',
            'phone_number' => 'string|nullable',
            'location_address' => 'string|nullable',
            'gender' => 'in:male,female|nullable',
            'photo' => 'image|nullable',
        ]);

        // Update user's first name if provided
        if ($request->filled('first_name')) {
            $user->update(['first_name' => $request->input('first_name')]);
        }

        // Prepare profile data for update
        $profileData = $request->only(['company_name', 'position', 'phone_number', 'location_address', 'gender']);

        if ($request->hasFile('photo')) {
            $profileData['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        if ($profile) {
            $profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function deletePhoto()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
            $profile->photo = null;
            $profile->save();
        }

        return redirect()->back()->with('success', 'Photo deleted successfully');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
