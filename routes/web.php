<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
})->name('home');

Route::get('dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/settings.php';
