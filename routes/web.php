<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemberiKerjaController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout Route (Authenticated Only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on user role
        if (auth()->user()->tipe_user === 'PemberiKerja') {
            return redirect()->route('pemberi-kerja.dashboard');
        }
        return redirect()->route('pekerja.dashboard');
    })->name('dashboard');
    
    // Pemberi Kerja Routes
    Route::prefix('pemberi-kerja')->name('pemberi-kerja.')->middleware('pemberi_kerja')->group(function () {
        Route::get('/dashboard', [PemberiKerjaController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengaturan', [PemberiKerjaController::class, 'pengaturan'])->name('pengaturan');
        Route::get('/profil', [PemberiKerjaController::class, 'profil'])->name('profil');
        Route::put('/profil', [PemberiKerjaController::class, 'updateProfil'])->name('profil.update');
        Route::get('/buat-lowongan', [PemberiKerjaController::class, 'buatLowongan'])->name('buat-lowongan');
        Route::post('/simpan-lowongan', [PemberiKerjaController::class, 'simpanLowongan'])->name('simpan-lowongan');
        Route::get('/rekomendasi-pekerja', [PemberiKerjaController::class, 'rekomendasiPekerja'])->name('rekomendasi-pekerja');
        Route::get('/lowongan-saya', [PemberiKerjaController::class, 'lowonganSaya'])->name('lowongan-saya');
        Route::get('/konfirmasi-pekerja', [PemberiKerjaController::class, 'konfirmasiPekerja'])->name('konfirmasi-pekerja');
        
        // Lowongan Routes
        Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/lowongan/{id}', [LowonganController::class, 'show'])->name('lowongan.show');
        Route::get('/lowongan/{id}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
        Route::put('/lowongan/{id}', [LowonganController::class, 'update'])->name('lowongan.update');
        
        // FITUR 5: Lihat Pelamar
        Route::get('/lowongan/{id}/pelamar', [LamaranController::class, 'pelamar'])->name('lowongan.pelamar');
        
        // FITUR 6: Pilih Pekerja (Terima/Tolak)
        Route::post('/lamaran/{id}/terima', [LamaranController::class, 'terimaPelamar'])->name('lamaran.terima');
        Route::post('/lamaran/{id}/tolak', [LamaranController::class, 'tolakPelamar'])->name('lamaran.tolak');
        
        // FITUR 7: Konfirmasi Pekerjaan Selesai
        Route::post('/pekerjaan/{id}/selesai', [PekerjaanController::class, 'konfirmasiSelesai'])->name('pekerjaan.selesai');
        
        // Pekerjaan Routes
        Route::get('/pekerjaan', [PekerjaanController::class, 'index'])->name('pekerjaan.index');
        Route::get('/pekerjaan/{id}', [PekerjaanController::class, 'show'])->name('pekerjaan.detail');
        Route::get('/profil-pelamar/{id}', [PemberiKerjaController::class, 'profilPelamar'])->name('profil-pelamar');
    });
    
    // Pekerja Routes
    Route::prefix('pekerja')->name('pekerja.')->group(function () {
        Route::get('/dashboard', [PekerjaController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengaturan', [PekerjaController::class, 'pengaturan'])->name('pengaturan');
        Route::get('/lamaran', [PekerjaController::class, 'lamaran'])->name('lamaran');
        Route::get('/profil', [PekerjaController::class, 'profil'])->name('profil');
        Route::get('/profil/{id}', [PekerjaController::class, 'profilPublik'])->name('profil.publik');
        Route::put('/profil', [PekerjaController::class, 'updateProfil'])->name('profil.update');
        Route::get('/cari-pekerjaan', [PekerjaController::class, 'cariPekerjaan'])->name('cari-pekerjaan');
        Route::get('/lowongan/{id}', [PekerjaController::class, 'detailLowongan'])->name('lowongan.detail');
        Route::post('/lowongan/{id}/lamar', [LamaranController::class, 'lamar'])->name('lowongan.lamar');
        Route::get('/lamaran-list', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::post('/keahlian', [PekerjaController::class, 'tambahKeahlian'])->name('keahlian.tambah');
    });
    
    // FITUR 8: Rating Routes (untuk kedua pihak)
    Route::post('/rating/beri', [RatingController::class, 'beriRating'])->name('rating.beri');
    Route::get('/rating', [RatingController::class, 'index'])->name('rating.index');
});