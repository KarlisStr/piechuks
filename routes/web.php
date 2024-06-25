<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Auth\RegisterController;

// Route for registration page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// You might also want to add a route for handling the registration post request
Route::post('/register', [RegisterController::class, 'register']);

