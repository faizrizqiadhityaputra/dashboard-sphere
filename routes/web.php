<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/geospasial', function () {
    return view('geospasial');
})->name('geospasial');

Route::get('/lingkungan', function () {
    return view('lingkungan');
})->name('lingkungan');

Route::get('/ekonomi', function () {
    return view('ekonomi');
})->name('ekonomi');

Route::get('/karbon', function () {
    return view('karbon');
})->name('karbon');

Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');