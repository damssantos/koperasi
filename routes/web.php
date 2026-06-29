<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/anggota', function () {
    return view('anggota');
});

Route::get('/profile', function () {
    return view('profile');
});
