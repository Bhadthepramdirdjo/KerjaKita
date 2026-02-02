<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes (protected by auth middleware)
// Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on user role
        if (auth()->user()->peran === 'PemberiKerja') {
            return redirect()->route('pemberi-kerja.dashboard');
        }
        return redirect()->route('pekerja.dashboard');
    })->name('dashboard');
    
    // Pemberi Kerja Routes
    Route::prefix('pemberi-kerja')->name('pemberi-kerja.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PemberiKerjaController::class, 'dashboard'])->name('dashboard');
        Route::get('/lowongan', [App\Http\Controllers\LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/lowongan/create', [App\Http\Controllers\LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/lowongan', [App\Http\Controllers\LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/lowongan/{id}', [App\Http\Controllers\LowonganController::class, 'show'])->name('lowongan.show');
        Route::get('/lowongan/{id}/pelamar', [App\Http\Controllers\LamaranController::class, 'pelamar'])->name('lowongan.pelamar');
    });
    
    // Pekerja Routes (Temporary without auth for testing)
    Route::prefix('pekerja')->name('pekerja.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PekerjaController::class, 'dashboard'])->name('dashboard');
        Route::get('/cari-pekerjaan', [App\Http\Controllers\PekerjaController::class, 'cariPekerjaan'])->name('cari-pekerjaan');
        Route::get('/lowongan/{id}', [App\Http\Controllers\PekerjaController::class, 'detailLowongan'])->name('lowongan.detail');
        Route::post('/lowongan/{id}/lamar', [App\Http\Controllers\LamaranController::class, 'lamar'])->name('lowongan.lamar');
        Route::get('/lamaran', [App\Http\Controllers\LamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/pengaturan', [App\Http\Controllers\PekerjaController::class, 'pengaturan'])->name('pengaturan');
    });

    
    // Pemberi Kerja Routes (Temporary without auth for testing)
    Route::prefix('pemberi-kerja')->name('pemberi-kerja.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PemberiKerjaController::class, 'dashboard'])->name('dashboard');
        Route::get('/buat-lowongan', [App\Http\Controllers\PemberiKerjaController::class, 'buatLowongan'])->name('buat-lowongan');
        Route::post('/simpan-lowongan', [App\Http\Controllers\PemberiKerjaController::class, 'simpanLowongan'])->name('simpan-lowongan');
        Route::get('/rekomendasi-pekerja', [App\Http\Controllers\PemberiKerjaController::class, 'rekomendasiPekerja'])->name('rekomendasi-pekerja');
        Route::get('/lowongan-saya', [App\Http\Controllers\PemberiKerjaController::class, 'lowonganSaya'])->name('lowongan-saya');
        Route::get('/pengaturan', [App\Http\Controllers\PemberiKerjaController::class, 'pengaturan'])->name('pengaturan');
    });
// });