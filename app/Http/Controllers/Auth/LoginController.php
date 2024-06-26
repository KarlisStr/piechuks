<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply guest middleware to all methods except 'logout'
       // $this->middleware('guest')->except('logout');
        
        // Apply 'auth' middleware only to 'logout' method
        //$this->middleware('auth')->only('logout');
    }
    

    public function logout(Request $request)
    {
        // Logout logic here
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
