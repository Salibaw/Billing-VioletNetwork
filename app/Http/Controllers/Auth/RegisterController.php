<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'first_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
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

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->toArray()
                ]);
            }

            // Create and store the user
            $user = User::create([
                'username' => $request->username,
                'first_name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Respond with a success message
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error during registration: ' . $e->getMessage());

            // Return a JSON response with an error message
            return response()->json(['error' => 'An internal server error occurred'], 500);
        }
    }


    public function validateUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:4|max:255|unique:users,username',
        ]);

        if ($validator->fails()) {
            return response()->json(['available' => false]);
        }

        return response()->json(['available' => true]);
    }

    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['available' => false]);
        }

        return response()->json(['available' => true]);
    }
    
}
