<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;

// Halaman Utama / Katalog
Route::get('/', [ToolController::class, 'index'])->name('home');

// Autentikasi User
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus user yang sudah Login
Route::middleware('auth')->group(function () {
    // Halaman Riwayat Peminjaman Saya
    Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('borrowings.index');
    
    // Proses Pengajuan Peminjaman Alat
    Route::post('/pinjam/{tool}', [BorrowingController::class, 'store'])->name('borrowings.store');
});