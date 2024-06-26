<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfesionalisController;
use Illuminate\Support\Facades\Auth;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route for registration page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes for login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Route for logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Database data fetching
Route::get('/', [HomeController::class, 'index'])->name('home');

// Service details route
Route::get('/service-details/{id}', [ServiceController::class, 'serviceDetails']);

// Profesionalis routes, ensure these routes are protected by authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profesionalis', [ProfesionalisController::class, 'index'])->name('profesionalis.index');
    Route::get('/profesionalis/pieteikumi', [ProfesionalisController::class, 'pieteikumi'])->name('profesionalis.pieteikumi');
    Route::get('/profesionalis/pakalpojumi', [ProfesionalisController::class, 'pakalpojumi'])->name('profesionalis.pakalpojumi');
    Route::post('/profesionalis/pakalpojumi/add', [ProfesionalisController::class, 'addPakalpojums'])->name('profesionalis.pakalpojumi.add');
});

// Ensure you have an Auth::routes() call somewhere in your routes file to include default auth routes
Auth::routes();
