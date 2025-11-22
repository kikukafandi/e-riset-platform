<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenPermohonanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\TopikRisetController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\KantorBeaCukaiController;
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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Auth Petugas
|--------------------------------------------------------------------------
*/
Route::get('/login-petugas', [PetugasController::class, 'loginPetugasView'])->name('login.petugas.view');
Route::post('/login-petugas', [PetugasController::class, 'loginPetugas'])->name('login.petugas');
Route::post('/logout-petugas', [PetugasController::class, 'logoutPetugas'])->name('logout.petugas');

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
    
    // Research completion features
    Route::post('/dokumen/{id}/complete-research', [DokumenPermohonanController::class, 'updateResearchCompletion'])->name('dokumen.complete.research');
    Route::get('/check-eligibility/{userId}', [DokumenPermohonanController::class, 'checkResearcherEligibility'])->name('check.eligibility');
});

/*
|--------------------------------------------------------------------------
| Dashboard Petugas
|--------------------------------------------------------------------------
*/
Route::middleware(['CekLogin:petugas'])->group(function () {
    Route::get('/dashboard-petugas', [DashboardController::class, 'dashboardPetugas'])->name('dashboard.petugas');

    Route::get('/manage-petugas', [PetugasController::class, 'index'])->name('manage.petugas');
    Route::get('/manage-petugas/create', [PetugasController::class, 'create'])->name('manage.petugas.create');
    Route::post('/manage-petugas', [PetugasController::class, 'store'])->name('manage.petugas.store');
    Route::get('/manage-petugas/{id}/edit', [PetugasController::class, 'edit'])->name('manage.petugas.edit');
    Route::put('/manage-petugas/{id}', [PetugasController::class, 'update'])->name('manage.petugas.update');
    Route::delete('/manage-petugas/{id}', [PetugasController::class, 'destroy'])->name('manage.petugas.destroy');

    Route::get('/petugas/permohonan/total', [DokumenPermohonanController::class, 'total'])->name('permohonan.total');
    Route::get('/petugas/permohonan/pending', [DokumenPermohonanController::class, 'pending'])->name('permohonan.pending');
    Route::get('/petugas/permohonan/disetujui', [DokumenPermohonanController::class, 'disetujui'])->name('permohonan.disetujui');
    Route::get('/petugas/permohonan/ditolak', [DokumenPermohonanController::class, 'ditolak'])->name('permohonan.ditolak');

    Route::put('/petugas/permohonan/{id}/status', [DokumenPermohonanController::class, 'updateStatus'])->name('permohonan.updateStatus');
    Route::get('/dokumen/{id}', [DokumenPermohonanController::class, 'show'])->name('dokumen.show');
    Route::get('/petugas/statistik-permohonan', [DashboardController::class, 'getStatistikPermohonan'])->name('petugas.statistik');


    //   Topik Riset (CRUD)
    Route::get('/manage-topik', [TopikRisetController::class, 'index'])->name('manage.topik.index');
    Route::get('/manage-topik/create', [TopikRisetController::class, 'create'])->name('manage.topik.create');
    Route::post('/manage-topik', [TopikRisetController::class, 'store'])->name('manage.topik.store');
    Route::get('/manage-topik/{id}/edit', [TopikRisetController::class, 'edit'])->name('manage.topik.edit');
    Route::put('/manage-topik/{id}', [TopikRisetController::class, 'update'])->name('manage.topik.update');
    Route::delete('/manage-topik/{id}', [TopikRisetController::class, 'destroy'])->name('manage.topik.destroy');

    // Kantor Bea Cukai Management
    Route::get('/manage-kantor', [KantorBeaCukaiController::class, 'index'])->name('manage.kantor.index');
    Route::get('/manage-kantor/create', [KantorBeaCukaiController::class, 'create'])->name('manage.kantor.create');
    Route::post('/manage-kantor', [KantorBeaCukaiController::class, 'store'])->name('manage.kantor.store');
    Route::get('/manage-kantor/{kantor}/edit', [KantorBeaCukaiController::class, 'edit'])->name('manage.kantor.edit');
    Route::put('/manage-kantor/{kantor}', [KantorBeaCukaiController::class, 'update'])->name('manage.kantor.update');
    Route::delete('/manage-kantor/{kantor}', [KantorBeaCukaiController::class, 'destroy'])->name('manage.kantor.destroy');

    // Statistics Routes
    Route::get('/statistics/dashboard', [StatisticsController::class, 'statisticsDashboard'])->name('statistics.dashboard');
    Route::get('/statistics/applicant-types', [StatisticsController::class, 'getApplicantTypeStats'])->name('statistics.applicant.types');
    Route::get('/statistics/period-stats', [StatisticsController::class, 'getPeriodStats'])->name('statistics.period');
    Route::get('/statistics/topic-usage', [StatisticsController::class, 'getTopicUsageStats'])->name('statistics.topic.usage');
    Route::get('/statistics/office-destinations', [StatisticsController::class, 'getOfficeDestinationStats'])->name('statistics.office.destinations');
    Route::get('/statistics/research-completion', [StatisticsController::class, 'getResearchCompletionStats'])->name('statistics.research.completion');
    
    // Research completion dashboard
    Route::get('/research-completion-dashboard', [DokumenPermohonanController::class, 'researchCompletionDashboard'])->name('research.completion.dashboard');
    
    // Update overdue research (can be scheduled as cron job)
    Route::post('/update-overdue-research', [StatisticsController::class, 'updateOverdueResearch'])->name('update.overdue.research');

    // API endpoints
    Route::get('/api/kantor-options', [KantorBeaCukaiController::class, 'getKantorOptions'])->name('api.kantor.options');
});
