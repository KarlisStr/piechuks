<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pieteikties', function () {
    return view('pieteikties');
})->name('pieteikties');
