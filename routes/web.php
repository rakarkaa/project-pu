<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihanController;
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

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard (SATU SAJA)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Master Pelatihan (Admin & User boleh lihat)
    |--------------------------------------------------------------------------
    */
Route::middleware('auth')->group(function () {

    Route::prefix('master-pelatihan')->group(function () {
        Route::get('/', [PelatihanController::class, 'index'])->name('pelatihan.index');
        Route::get('/create', [PelatihanController::class, 'create'])->name('pelatihan.create');
        Route::post('/', [PelatihanController::class, 'store'])->name('pelatihan.store');
        Route::get('/{id}/edit', [PelatihanController::class, 'edit'])->name('pelatihan.edit');
        Route::put('/{id}', [PelatihanController::class, 'update'])->name('pelatihan.update');
        Route::delete('/{id}', [PelatihanController::class, 'destroy'])->name('pelatihan.destroy');
    });

});


    /*
    |--------------------------------------------------------------------------
    | MASTER USERS (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::resource('users', AdminUserController::class);
    });

});

    /*
    |--------------------------------------------------------------------------
    | KELAS KEPEMIMPINAN
    |--------------------------------------------------------------------------
    */
Route::middleware('auth')->prefix('kelas-kepemimpinan')->group(function () {

    // 🔹 semua user boleh lihat
    Route::get('/', [KelasKepemimpinanController::class, 'index'])
        ->name('kelas.kepemimpinan.index');

    // ADMIN ONLY
    Route::middleware('admin')->group(function () {

        Route::get('/create', [KelasKepemimpinanController::class, 'create'])
            ->name('kelas.kepemimpinan.create');

        Route::post('/', [KelasKepemimpinanController::class, 'store'])
            ->name('kelas.kepemimpinan.store');

        Route::get('/{id}/edit', [KelasKepemimpinanController::class, 'edit'])
            ->name('kelas.kepemimpinan.edit');

        Route::put('/{id}', [KelasKepemimpinanController::class, 'update'])
            ->name('kelas.kepemimpinan.update');

        Route::delete('/{id}', [KelasKepemimpinanController::class, 'destroy'])
            ->name('kelas.kepemimpinan.destroy');
    });

});

    /*
    |--------------------------------------------------------------------------
    | KELAS FUNGSIONAL
    |--------------------------------------------------------------------------
    */
    Route::prefix('kelas-fungsional')->group(function () {

        // ===== SEMUA USER =====
        Route::get('/',
            [KelasFungsionalController::class, 'index']
        )->name('kelas.fungsional.index');

        // ===== ADMIN ONLY =====
        Route::middleware(['auth', 'admin'])->group(function () {

            Route::get('/create',
                [KelasFungsionalController::class, 'create']
            )->name('kelas.fungsional.create');

            Route::post('/',
                [KelasFungsionalController::class, 'store']
            )->name('kelas.fungsional.store');

            Route::get('/{id}/edit',
                [KelasFungsionalController::class, 'edit']
            )->name('kelas.fungsional.edit');

            Route::put('/{id}',
                [KelasFungsionalController::class, 'update']
            )->name('kelas.fungsional.update');

            Route::delete('/{id}',
                [KelasFungsionalController::class, 'destroy']
            )->name('kelas.fungsional.destroy');
        });
    });


    /*|--------------------------------------------------------------------------
    | DAFTAR PANTAU
    |--------------------------------------------------------------------------*/
    Route::middleware(['auth'])->prefix('daftar-pantau')->group(function () {

    Route::get('/kepemimpinan',
        [DaftarPantauController::class, 'kepemimpinan']
    )->name('daftar-pantau.kepemimpinan');

    Route::get('/fungsional',
        [DaftarPantauController::class, 'fungsional']
    )->name('daftar-pantau.fungsional');

});


    //Halaman Awal Kepemimpinan
    Route::middleware(['auth'])->group(function () {

        Route::prefix('daftar-pantau/kepemimpinan')->group(function () {

            Route::get('/', 
                [DaftarPantauKepemimpinanController::class, 'index']
            )->name('daftar-pantau.kepemimpinan.index');

            Route::get('/{kelas}', 
                [DaftarPantauKepemimpinanController::class, 'show']
            )->name('daftar-pantau.kepemimpinan.show');

        //admin` only routes
            Route::middleware(['auth', 'admin'])->group(function () {
            Route::post(
                '/daftar-pantau/kepemimpinan/{kelas}/kepesertaan',
                [DaftarPantauKepesertaanController::class, 'store']
            )->name('pantau.kepesertaan.store');

            Route::delete(
                '/daftar-pantau/kepesertaan/{id}',
                [DaftarPantauKepesertaanController::class, 'destroy']
            )->name('pantau.kepesertaan.destroy');

            Route::middleware(['auth', 'admin'])->group(function () {

            Route::post(
                '/daftar-pantau/kepemimpinan/{kelas}/pengajar',
                [DaftarPantauPengajarController::class, 'store']
            )->name('pantau.pengajar.store');

            Route::delete(
                '/daftar-pantau/pengajar/{id}',
                [DaftarPantauPengajarController::class, 'destroy']
            )->name('pantau.pengajar.destroy');

            Route::middleware(['auth', 'admin'])->group(function () {

            Route::post(
                '/daftar-pantau/kepemimpinan/{kelas}/manajemen',
                [DaftarPantauManajemenController::class, 'store']
            )->name('pantau.manajemen.store');

            Route::delete(
                '/daftar-pantau/manajemen/{id}',
                [DaftarPantauManajemenController::class, 'destroy']
            )->name('pantau.manajemen.destroy');

        });

        });
        
        });

    });

    // =============================
// HALAMAN AWAL FUNGSIONAL
// =============================
Route::middleware(['auth'])->group(function () {

    Route::prefix('daftar-pantau/fungsional')->group(function () {

        Route::get('/',
            [DaftarPantauFungsionalController::class, 'index']
        )->name('daftar-pantau.fungsional.index');

        Route::get('/{kelas}',
            [DaftarPantauFungsionalController::class, 'show']
        )->name('daftar-pantau.fungsional.show');


        // =============================
        // ADMIN ONLY CRUD
        // =============================
        Route::middleware(['admin'])->group(function () {

            // --- Kepesertaan ---
            Route::post(
                '/daftar-pantau/fungsional/{kelas}/kepesertaan',
                [DaftarPantauKepesertaanFungController::class, 'store']
            )->name('pantau.kepesertaan.store');

            Route::delete(
                '/daftar-pantau/kepesertaan/{id}',
                [DaftarPantauKepesertaanFungController::class, 'destroy']
            )->name('pantau.kepesertaan.destroy');


            // --- Pengajar ---
            Route::post(
                '/daftar-pantau/fungsional/{kelas}/pengajar',
                [DaftarPantauPengajarFungController::class, 'store']
            )->name('pantau.pengajar.store');

            Route::delete(
                '/daftar-pantau/pengajar/{id}',
                [DaftarPantauPengajarFungController::class, 'destroy']
            )->name('pantau.pengajar.destroy');


            // --- Manajemen ---
            Route::post(
                '/daftar-pantau/fungsional/{kelas}/manajemen',
                [DaftarPantauManajemenFungController::class, 'store']
            )->name('pantau.manajemen.store');

            Route::delete(
                '/daftar-pantau/manajemen/{id}',
                [DaftarPantauManajemenFungController::class, 'destroy']
            )->name('pantau.manajemen.destroy');

        });

    });

});

});



