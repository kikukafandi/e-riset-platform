<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\DokumenPermohonanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchRequstController;

Route::get('/researchrequest',[ResearchRequstController::class,'index'])->name('researchrequest.index');
Route::get('/researchrequest/create', [ResearchRequstController::class, 'create'])->name('researchrequest.create');
Route::get('/researchrequest/{id}/edit', [ResearchRequstController::class, 'edit'])->name('researchrequest.edit');
Route::get('/researchrequest/{id}', [ResearchRequstController::class, 'show'])->name('researchrequest.show');
Route::post('/researchrequest', [ResearchRequstController::class, 'store'])->name('researchrequest.store');
Route::put('/researchrequest/{id}', [ResearchRequstController::class, 'update'])->name('researchrequest.update');
Route::delete('/researchrequest/{id}', [ResearchRequstController::class, 'destroy'])->name('researchrequest.destroy');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// login methdod
Route::get('/login',[AuthController::class,'loginPage'])->name('loginPage');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/login-petugas',[PetugasController::class,'loginPetugas'])->name('login_petugas');
Route::get('/login-petugas',[PetugasController::class,'loginPetugasView'])->name('login_petugas_view');

// register method
Route::get('/register',[AuthController::class,'registerPage'])->name('registerPage');
Route::post('/register',[AuthController::class,'register'])->name('register');



// Dashboard Method
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboardPage');
Route::get('/dashboard/pengajuan',[DashboardController::class,'create'])->name('dashboardPengajuan');


Route::post('/pengajuan',[DokumenPermohonanController::class,'store'])->name('dokumen.store');

Route::get('/dokumen', [DokumenPermohonanController::class, 'index'])->name('dokumen.index');
Route::get('/dokumen/{id}', [DokumenPermohonanController::class, 'show'])->name('dokumen.show');
Route::get('/dokumen/{id}/edit', [DokumenPermohonanController::class, 'edit'])->name('dokumen.edit');
Route::put('/dokumen/{id}', [DokumenPermohonanController::class, 'update'])->name('dokumen.update');
Route::delete('/dokumen/{id}', [DokumenPermohonanController::class, 'destroy'])->name('dokumen.destroy');
