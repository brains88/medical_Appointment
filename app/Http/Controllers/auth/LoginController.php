<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Patient, Doctor, Department};
use Auth;

class LoginController extends Controller
{
    
    public function index(){
         
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful
            $user = Auth::user();

            // Check user role and redirect accordingly
            if ($user->role == 'patient') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => '/patient/dashboard', // Redirect to patient dashboard
                ]);
            } elseif ($user->role === 'admin') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('admin.dashboard'),
                ]);
            }
            elseif ($user->role === 'doctor') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('doctor.dashboard'), // Redirect to admin dashboard
                ]);
            }

        } else {
            // Authentication failed
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }
    }

    //Logout function
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/');
    }
}
