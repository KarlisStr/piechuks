<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfesionalisController;
use App\Http\Controllers\KlientsController;
use App\Http\Controllers\FavoritesController;


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


Route::get('/service-details/{id}', [ServiceController::class, 'serviceDetails']);

// Profesionalis routes, ensure these routes are protected by authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profesionalis', [ProfesionalisController::class, 'index'])->name('profesionalis.index');
    Route::get('/profesionalis/pieteikumi', [ProfesionalisController::class, 'pieteikumi'])->name('profesionalis.pieteikumi');
    Route::get('/profesionalis/pakalpojumi', [ProfesionalisController::class, 'pakalpojumi'])->name('profesionalis.pakalpojumi');
    Route::delete('/delete-service/{pakalpojumaId}', [ProfesionalisController::class, 'deletePakalpojums'])->name('profesionalis.pakalpojumi.delete');
    Route::put('/edit-service/{pakalpojumaId}', [ProfesionalisController::class, 'updatePakalpojums'])->name('profesionalis.pakalpojumi.update');
    Route::post('/profesionalis/pakalpojumi/add', [ProfesionalisController::class, 'addPakalpojums'])->name('profesionalis.pakalpojumi.add');
    Route::delete('/delete-image/{imageId}', [ProfesionalisController::class, 'deleteImage'])->name('deleteImage');
});
Route::put('/pieteikums-status/{pieteikumsId}', [ProfesionalisController::class, 'updatePieteikumsStatus']);


// Ensure you have an Auth::routes() call somewhere in your routes file to include default auth routes
Auth::routes();

use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/save-to-favorites/{id}', [FavoritesController::class, 'save'])->name('save.to.favorites');
});
Route::get('/klients', [KlientsController::class, 'index'])->name('klients.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/klients/pieteikumi', [KlientsController::class, 'pieteikumi'])->name('klients.pieteikumi');
    Route::post('/klients/pieteikties', [KlientsController::class, 'pieteikties'])->name('klients.pieteikties');
    Route::get('/pieteikums-details/{pieteikumsId}', [KlientsController::class, 'getPieteikumsDetails'])->name('klients.getPieteikumsDetails');
});


use App\Http\Controllers\FiltrationController;

Route::middleware(['web'])->group(function () {
    Route::post('/filter-services', [FiltrationController::class, 'filter'])->name('filter.services');
});