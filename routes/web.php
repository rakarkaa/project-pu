<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihanController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


//Pelatihan Routes
Route::get('/master-pelatihan', [PelatihanController::class, 'index'])->name('pelatihan.index');
Route::get('/master-pelatihan/create', [PelatihanController::class, 'create'])->name('pelatihan.create');
Route::post('/master-pelatihan', [PelatihanController::class, 'store'])->name('pelatihan.store');
Route::get('/master-pelatihan/{id}/edit', [PelatihanController::class, 'edit'])->name('pelatihan.edit');
Route::put('/master-pelatihan/{id}', [PelatihanController::class, 'update'])->name('pelatihan.update');
Route::delete('/master-pelatihan/{id}', [PelatihanController::class, 'destroy'])->name('pelatihan.destroy');

