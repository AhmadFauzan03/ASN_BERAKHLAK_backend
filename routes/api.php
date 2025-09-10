<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\Status_BeritaController;
use App\Http\Controllers\Api\PeranController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\PoinController;
use App\Http\Controllers\Api\OpdController;
use App\Http\Controllers\Api\KriteriaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Form_OpdController;
use App\Http\Controllers\Api\SubKriteriaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AkumulasiTotalPoinController;
use App\Http\Controllers\Api\FormOpdController;


//ROUTE PUBLIK (tidak perlu login)
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/akumulasi-total-poin', [AkumulasiTotalPoinController::class, 'index']);
Route::get('/akumulasi-total-poin/{id_user}', [AkumulasiTotalPoinController::class, 'show']);

// Berita publik → hanya bisa lihat yang status "DI Posting"
Route::get('/berita', [BeritaController::class, 'index']);   // list berita publish
Route::get('/berita/{id}', [BeritaController::class, 'show']); // detail berita publish

Route::middleware(['auth:sanctum'])->group(function () {
//ROUTE YANG BUTUH LOGIN
// Super Admin → full akses master data + berita + verifikasi form OPD
Route::middleware('role:super admin')->group(function () {
    // Master Data
    Route::apiResource('/peran', PeranController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/opd', OpdController::class);
    Route::apiResource('/poin', PoinController::class);
    Route::apiResource('/status', StatusController::class);

    // Berita (punya admin)
    Route::apiResource('/berita', BeritaController::class)->except(['index','show']);
    Route::apiResource('/status_berita', Status_BeritaController::class);
    Route::put('/berita/{id}/status', [BeritaController::class, 'updateStatus']);
    Route::put('/berita/{id}/edit', [BeritaController::class, 'edit']);

    // Verifikasi Form OPD (punya tim verifikasi juga)
    Route::put('/form_opd/{id}/status', [Form_OpdController::class, 'updateStatus']);
});

// Admin → kelola berita (tapi super_admin juga bisa)
Route::middleware('role:admin')->group(function () {
    Route::apiResource('/berita', BeritaController::class)->except(['index','show']);
    Route::apiResource('/status_berita', Status_BeritaController::class);
    Route::put('/berita/{id}/status', [BeritaController::class, 'updateStatus']);
    Route::put('/berita/{id}/edit', [BeritaController::class, 'edit']);
});

// Tim Verifikasi → verifikasi form OPD (tapi super_admin juga bisa)
Route::middleware('role:tim verifikasi')->group(function () {
    Route::put('/form_opd/{id}/status', [Form_OpdController::class, 'updateStatus']);
});

Route::middleware('role:tim verifikasi,pengguna opd')->group(function(){
    Route::apiResource('/kriteria', KriteriaController::class);
    Route::apiResource('/subkriteria', SubKriteriaController::class);
});

// Pengguna OPD → input form OPD
Route::middleware('role:pengguna opd')->group(function () {
    Route::get('/form_opd', [Form_OpdController::class, 'index']);
    Route::get('/form_opd/bulan', [Form_OpdController::class, 'indexByBulan']);
    Route::post('/form_opd', [Form_OpdController::class, 'store']);
    Route::post('/form_opd/user/{id_user}/perbulan', [Form_OpdController::class, 'updateByUserPerBulan']);
});
Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/update-password', [UserController::class, 'updatePassword']);
});



Route::apiResource('form-opds', FormOpdController::class);