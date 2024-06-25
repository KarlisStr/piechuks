<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/pieteikties', function () {
    return view('pieteikties');
})->name('pieteikties');


// Route for registration page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// You might also want to add a route for handling the registration post request
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
