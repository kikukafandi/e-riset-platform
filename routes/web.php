<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenPermohonanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth User (Mahasiswa / Non-Mahasiswa)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
Route::post('/register', [AuthController::class, 'register'])->name('register');

/*
|--------------------------------------------------------------------------
| Auth Petugas
|--------------------------------------------------------------------------
*/
Route::get('/login-petugas', [PetugasController::class, 'loginPetugasView'])->name('login.petugas.view');
Route::post('/login-petugas', [PetugasController::class, 'loginPetugas'])->name('login.petugas');

/*
|--------------------------------------------------------------------------
| Dashboard User (Periset)
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboardPage');
    Route::get('/dashboard/pengajuan', [DashboardController::class, 'create'])->name('dashboardPengajuan');

    // Dokumen (CRUD)
    Route::get('/dokumen', [DokumenPermohonanController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/create', [DokumenPermohonanController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen', [DokumenPermohonanController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}', [DokumenPermohonanController::class, 'show'])->name('dokumen.show');
    Route::get('/dokumen/{id}/edit', [DokumenPermohonanController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenPermohonanController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{id}', [DokumenPermohonanController::class, 'destroy'])->name('dokumen.destroy');

    Route::get('/dokumen/status', [DokumenPermohonanController::class, 'status'])->name('dokumen.status');
});

/*
|--------------------------------------------------------------------------
| Dashboard Petugas
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:petugas'])->group(function () {
    Route::get('/dashboard-petugas', function () {
        return view('dashboard.petugas'); // nanti bikin view dashboard khusus petugas
    })->name('dashboard.petugas');

    Route::get('/manage-petugas', [PetugasController::class, 'index'])->name('manage.petugas');
});
