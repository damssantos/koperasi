<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
}); 

// 3. Proteksi semua halaman dashboard, anggota, DAN profile baru milik mereka
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/anggota', function () {
        return view('anggota');
    });

    Route::get('/profile', function () {
        return view('profile');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});