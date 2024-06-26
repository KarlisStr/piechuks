<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    // Method to handle login form submission
    public function login(Request $request)
    {
        // Validate the login request (you can use LoginRequest here for validation)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            if (Auth::user()->is_professional) {
                return redirect()->intended('/profesionalis'); // Redirect to professional dashboard
            } else {
                return redirect()->intended('/klients'); // Redirect to client dashboard
            }
        }

        // Authentication failed...
        return back()->withErrors(['email' => 'Invalid credentials']); // Redirect back with error message
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect to the home page or login page
    }
}
