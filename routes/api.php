<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\Status_BeritaController;
use App\Http\Controllers\Api\PeranController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\PoinController;
use App\Http\Controllers\Api\OpdController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FormOpdController; // <-- Pake ini
use App\Http\Controllers\Api\KriteriaController;
use App\Http\Controllers\Api\SubKriteriaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AkumulasiTotalPoinController;
use App\Http\Controllers\Api\FormOpdDetailController;

// =================== ROUTE PUBLIK ===================
// Login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Akumulasi Total Poin
Route::get('/akumulasi-total-poin', [AkumulasiTotalPoinController::class, 'index']);
Route::get('/akumulasi-total-poin/{id_user}', [AkumulasiTotalPoinController::class, 'show']);

// Berita publik → hanya bisa lihat yang status "DI Posting"
Route::get('/berita', [BeritaController::class, 'index']);   
Route::get('/berita/{id}', [BeritaController::class, 'show']); 

// =================== ROUTE YANG BUTUH LOGIN ===================
Route::middleware(['auth:sanctum'])->group(function () {

    // Super Admin → full akses master data + berita + verifikasi form OPD
    Route::middleware('role:super admin')->group(function () {
        // Master Data
        Route::apiResource('/peran', PeranController::class);
        Route::apiResource('/user', UserController::class);
        Route::apiResource('/opd', OpdController::class);
        Route::apiResource('/poin', PoinController::class);
        Route::apiResource('/status', StatusController::class);

        // Berita (punya admin juga)
        Route::apiResource('/berita', BeritaController::class)->except(['index','show']);
        Route::apiResource('/status_berita', Status_BeritaController::class);
        Route::put('/berita/{id}/status', [BeritaController::class, 'updateStatus']);
        Route::put('/berita/{id}/edit', [BeritaController::class, 'edit']);

    });

    // Admin → kelola berita
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('/berita', BeritaController::class)->except(['index','show']);
        Route::apiResource('/status_berita', Status_BeritaController::class);
        Route::put('/berita/{id}/status', [BeritaController::class, 'updateStatus']);
        Route::put('/berita/{id}/edit', [BeritaController::class, 'edit']);
    });

    // Tim Verifikasi → verifikasi form OPD
    Route::middleware('role:tim verifikasi')->group(function () {
       Route::put('/form-opd/{id}/update-status', [FormOpdDetailController::class, 'updateStatus'])
        ->name('form-opd.update-status');
        Route::get('/form-opd/all-data', [FormOpdController::class, 'get_all_data'])
        ->name('form-opd.get-all');
    });

    // Tim Verifikasi & Pengguna OPD → bisa akses kriteria
    Route::middleware('role:tim verifikasi,pengguna opd')->group(function(){
        Route::apiResource('/kriteria', KriteriaController::class);
    });

    // Pengguna OPD → input form OPD
    Route::middleware('role:pengguna opd')->group(function () {
        Route::get('/form_opd', [FormOpdController::class, 'index']);
        Route::get('/form_opd/bulan', [FormOpdController::class, 'indexByBulan']);
        Route::post('/form_opd', [FormOpdController::class, 'store']);
        Route::post('/form_opd/user/{id_user}/perbulan', [FormOpdController::class, 'updateByUserPerBulan']);
    });

    // Logout & Update password
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/update-password', [UserController::class, 'updatePassword']);
});

// CRUD Form OPD (akses umum sesuai policy role)
//Route::apiResource('form-opds', FormOpdController::class);