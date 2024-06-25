<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
})->name('home');


Route::get('/pieteikties', function () {
    return view('pieteikties');
})->name('pieteikties');

use App\Http\Controllers\Auth\RegisterController;

// Route for registration page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// You might also want to add a route for handling the registration post request
Route::post('/register', [RegisterController::class, 'register']);

// Database data fetching
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');


