<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\BalaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasKepemimpinanController;
use App\Http\Controllers\KelasFungsionalController;
use App\Http\Controllers\DaftarPantauController;
use App\Http\Controllers\DaftarPantauKepemimpinanController;
use App\Http\Controllers\DaftarPantauKepesertaanController;
use App\Http\Controllers\DaftarPantauPengajarController;
use App\Http\Controllers\DaftarPantauManajemenController;
use App\Http\Controllers\DaftarPantauFungsionalController;
use App\Http\Controllers\DaftarPantauKepesertaanFungController;
use App\Http\Controllers\DaftarPantauPengajarFungController;
use App\Http\Controllers\DaftarPantauManajemenFungController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\JenisPantauController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ------------------------------------------------------------------
    // DASHBOARD
    // ------------------------------------------------------------------
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);


    // ------------------------------------------------------------------
    // MASTER DATA (Pelatihan, Balai, Jenis Pantau)
    // ------------------------------------------------------------------
    Route::prefix('master-pelatihan')->group(function () {
        Route::get('/', [PelatihanController::class, 'index'])->name('pelatihan.index');
        Route::get('/create', [PelatihanController::class, 'create'])->name('pelatihan.create');
        Route::post('/', [PelatihanController::class, 'store'])->name('pelatihan.store');
        Route::get('/{id}/edit', [PelatihanController::class, 'edit'])->name('pelatihan.edit');
        Route::put('/{id}', [PelatihanController::class, 'update'])->name('pelatihan.update');
        Route::delete('/{id}', [PelatihanController::class, 'destroy'])->name('pelatihan.destroy');
    });

    Route::prefix('master-balai')->group(function () {
        Route::get('/', [BalaiController::class, 'index'])->name('balai.index');
        Route::get('/create', [BalaiController::class, 'create'])->name('balai.create');
        Route::post('/', [BalaiController::class, 'store'])->name('balai.store');
        Route::get('/{id}/edit', [BalaiController::class, 'edit'])->name('balai.edit');
        Route::put('/{id}', [BalaiController::class, 'update'])->name('balai.update');
        Route::delete('/{id}', [BalaiController::class, 'destroy'])->name('balai.destroy');
    });

    Route::prefix('master-jenis-pantau')->group(function () {
        Route::get('/', [JenisPantauController::class, 'index'])->name('jenis-pantau.index');
        Route::get('/create', [JenisPantauController::class, 'create'])->name('jenis-pantau.create');
        Route::post('/', [JenisPantauController::class, 'store'])->name('jenis-pantau.store');
        Route::get('/{id}/edit', [JenisPantauController::class, 'edit'])->name('jenis-pantau.edit');
        Route::put('/{id}', [JenisPantauController::class, 'update'])->name('jenis-pantau.update');
        Route::delete('/{id}', [JenisPantauController::class, 'destroy'])->name('jenis-pantau.destroy');
    });


    // ------------------------------------------------------------------
    // KELAS & DAFTAR PANTAU (Halaman Tampil)
    // ------------------------------------------------------------------
    
    // Kelas Kepemimpinan
    Route::prefix('kelas-kepemimpinan')->group(function () {
        Route::get('/', [KelasKepemimpinanController::class, 'index'])->name('kelas.kepemimpinan.index');
    });

    // Kelas Fungsional
    Route::prefix('kelas-fungsional')->group(function () {
        Route::get('/', [KelasFungsionalController::class, 'index'])->name('kelas.fungsional.index');
    });

    // Daftar Pantau (Menu Utama)
    Route::prefix('daftar-pantau')->group(function () {
        Route::get('/kepemimpinan', [DaftarPantauController::class, 'kepemimpinan'])->name('daftar-pantau.kepemimpinan');
        Route::get('/fungsional', [DaftarPantauController::class, 'fungsional'])->name('daftar-pantau.fungsional');
        
        // Daftar Pantau Kepemimpinan
        Route::get('/kepemimpinan-list', [DaftarPantauKepemimpinanController::class, 'index'])->name('daftar-pantau.kepemimpinan.index');
        Route::get('/kepemimpinan-list/{kelas}', [DaftarPantauKepemimpinanController::class, 'show'])->name('daftar-pantau.kepemimpinan.show');
        
        // Daftar Pantau Fungsional
        Route::get('/fungsional-list', [DaftarPantauFungsionalController::class, 'index'])->name('daftar-pantau.fungsional.index');
        Route::get('/fungsional-list/{kelas}', [DaftarPantauFungsionalController::class, 'show'])->name('daftar-pantau.fungsional.show');
    });


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY ROUTES (Manajemen Pengguna, Kelas & Input Daftar Pantau)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // Manajemen User
        Route::resource('users', AdminUserController::class);

        // CRUD Kelas Kepemimpinan
        Route::prefix('kelas-kepemimpinan')->group(function () {
            Route::get('/create', [KelasKepemimpinanController::class, 'create'])->name('kelas.kepemimpinan.create');
            Route::post('/', [KelasKepemimpinanController::class, 'store'])->name('kelas.kepemimpinan.store');
            Route::get('/{id}/edit', [KelasKepemimpinanController::class, 'edit'])->name('kelas.kepemimpinan.edit');
            Route::put('/{id}', [KelasKepemimpinanController::class, 'update'])->name('kelas.kepemimpinan.update');
            Route::delete('/{id}', [KelasKepemimpinanController::class, 'destroy'])->name('kelas.kepemimpinan.destroy');
        });

        // CRUD Kelas Fungsional
        Route::prefix('kelas-fungsional')->group(function () {
            Route::get('/create', [KelasFungsionalController::class, 'create'])->name('kelas.fungsional.create');
            Route::post('/', [KelasFungsionalController::class, 'store'])->name('kelas.fungsional.store');
            Route::get('/{id}/edit', [KelasFungsionalController::class, 'edit'])->name('kelas.fungsional.edit');
            Route::put('/{id}', [KelasFungsionalController::class, 'update'])->name('kelas.fungsional.update');
            Route::delete('/{id}', [KelasFungsionalController::class, 'destroy'])->name('kelas.fungsional.destroy');
        });

        // CRUD Daftar Pantau Kepemimpinan
        Route::prefix('daftar-pantau/kepemimpinan')->group(function () {
            // Kepesertaan
            Route::post('/{kelas}/kepesertaan', [DaftarPantauKepesertaanController::class, 'store'])->name('pantau.kepesertaan.store');
            Route::put('/kepesertaan/{id}', [DaftarPantauKepesertaanController::class, 'update'])->name('pantau.kepesertaan.update');
            Route::delete('/kepesertaan/{id}', [DaftarPantauKepesertaanController::class, 'destroy'])->name('pantau.kepesertaan.destroy');
            
            // Pengajar
            Route::post('/{kelas}/pengajar', [DaftarPantauPengajarController::class, 'store'])->name('pantau.pengajar.store');
            Route::put('/pengajar/{id}', [DaftarPantauPengajarController::class, 'update'])->name('pantau.pengajar.update'); // Baru ditambahkan
            Route::delete('/pengajar/{id}', [DaftarPantauPengajarController::class, 'destroy'])->name('pantau.pengajar.destroy');
            
            // Manajemen
            Route::post('/{kelas}/manajemen', [DaftarPantauManajemenController::class, 'store'])->name('pantau.manajemen.store');
            Route::put('/manajemen/{id}', [DaftarPantauManajemenController::class, 'update'])->name('pantau.manajemen.update'); // Baru ditambahkan
            Route::delete('/manajemen/{id}', [DaftarPantauManajemenController::class, 'destroy'])->name('pantau.manajemen.destroy');
            // Kepesertaan (Tambahkan route GET edit ini)
            Route::get('/kepesertaan/{id}/edit', [DaftarPantauKepesertaanController::class, 'edit'])->name('pantau.kepesertaan.edit');
            
            // Route lama yang sudah ada
            Route::post('/{kelas}/kepesertaan', [DaftarPantauKepesertaanController::class, 'store'])->name('pantau.kepesertaan.store');
            Route::put('/kepesertaan/{id}', [DaftarPantauKepesertaanController::class, 'update'])->name('pantau.kepesertaan.update');
            Route::delete('/kepesertaan/{id}', [DaftarPantauKepesertaanController::class, 'destroy'])->name('pantau.kepesertaan.destroy');
        });

        // CRUD Daftar Pantau Fungsional
        Route::prefix('daftar-pantau/fungsional')->group(function () {
            // Kepesertaan
            Route::post('/{kelas}/kepesertaan', [DaftarPantauKepesertaanFungController::class, 'store'])->name('pantau.fungsional.kepesertaan.store');
            Route::put('/kepesertaan/{id}', [DaftarPantauKepesertaanFungController::class, 'update'])->name('pantau.fungsional.kepesertaan.update'); // Tambahan baru
            Route::delete('/kepesertaan/{id}', [DaftarPantauKepesertaanFungController::class, 'destroy'])->name('pantau.fungsional.kepesertaan.destroy');
            
            // Pengajar
            Route::post('/{kelas}/pengajar', [DaftarPantauPengajarFungController::class, 'store'])->name('pantau.fungsional.pengajar.store');
            Route::put('/pengajar/{id}', [DaftarPantauPengajarFungController::class, 'update'])->name('pantau.fungsional.pengajar.update'); // Tambahan baru
            Route::delete('/pengajar/{id}', [DaftarPantauPengajarFungController::class, 'destroy'])->name('pantau.fungsional.pengajar.destroy');
            
            // Manajemen
            Route::post('/{kelas}/manajemen', [DaftarPantauManajemenFungController::class, 'store'])->name('pantau.fungsional.manajemen.store');
            Route::put('/manajemen/{id}', [DaftarPantauManajemenFungController::class, 'update'])->name('pantau.fungsional.manajemen.update'); // Tambahan baru
            Route::delete('/manajemen/{id}', [DaftarPantauManajemenFungController::class, 'destroy'])->name('pantau.fungsional.manajemen.destroy');
        
            // CRUD Daftar Pantau Fungsional
         Route::prefix('daftar-pantau/fungsional')->group(function () {
            // Kepesertaan
            Route::get('/kepesertaan/{id}/edit', [DaftarPantauKepesertaanFungController::class, 'edit'])->name('pantau.fungsional.kepesertaan.edit'); // <-- TAMBAHKAN INI
            
            Route::post('/{kelas}/kepesertaan', [DaftarPantauKepesertaanFungController::class, 'store'])->name('pantau.fungsional.kepesertaan.store');
            Route::put('/kepesertaan/{id}', [DaftarPantauKepesertaanFungController::class, 'update'])->name('pantau.fungsional.kepesertaan.update');
            Route::delete('/kepesertaan/{id}', [DaftarPantauKepesertaanFungController::class, 'destroy'])->name('pantau.fungsional.kepesertaan.destroy');
            
            // ... (route pengajar & manajemen biarkan saja) ...
            });
        });

    }); // End Admin Routes

}); // End Auth Routes