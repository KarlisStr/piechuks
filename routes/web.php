<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Auth\LoginController;


Route::get('/home', function () {
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

// Database data fetching
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\ServiceController;

Route::get('/service-details/{id}', [ServiceController::class, 'serviceDetails']);



use App\Http\Controllers\ProfesionalisController;

Route::get('/profesionalis-home', [ProfesionalisController::class, 'index'])->name('profesionalis.home');
Route::get('/profesionalis-home/pakalpojumi', [ProfesionalisController::class, 'pakalpojumi'])->name('profesionalis.pakalpojumi');
Route::get('/profesionalis-home/pieteikumi', [ProfesionalisController::class, 'pieteikumi'])->name('profesionalis.pieteikumi');
Route::post('/profesionalis-home/pakalpojumi/add', [ProfesionalisController::class, 'addPakalpojums'])->name('profesionalis.pakalpojumi.add');
