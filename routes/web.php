<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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
    Route::prefix('master-pelatihan')->group(function () {
        Route::get('/', [PelatihanController::class, 'index'])->name('pelatihan.index');
        Route::get('/create', [PelatihanController::class, 'create'])->name('pelatihan.create');
        Route::post('/', [PelatihanController::class, 'store'])->name('pelatihan.store');
        Route::get('/{id}/edit', [PelatihanController::class, 'edit'])->name('pelatihan.edit');
        Route::put('/{id}', [PelatihanController::class, 'update'])->name('pelatihan.update');
        Route::delete('/{id}', [PelatihanController::class, 'destroy'])->name('pelatihan.destroy');
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
