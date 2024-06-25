<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Method to show the login form (optional)
    public function showLoginForm()
    {
        return view('auth.login');
    }

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
            return redirect()->intended('/'); // Redirect to a dashboard or home route
        }

        // Authentication failed...
        return back()->withErrors(['email' => 'Invalid credentials']); // Redirect back with error message
    }
}
