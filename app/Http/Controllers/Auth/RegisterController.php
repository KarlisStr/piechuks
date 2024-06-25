<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }



    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_professional' => 'nullable|accepted', // Validate the checkbox (optional and accepted)
        ]);
    
        Log::info('Validated data:', $validated);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_professional' => $request->has('is_professional'), // Store the checkbox value
        ]);
    
        Log::info('User created:', $user->toArray());
    
        return redirect()->route('  home')->with('success', 'Registration successful!');
    }
}
