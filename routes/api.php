<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Master\InstansiApiController;
use App\Http\Controllers\Api\Master\JabatanApiController;
use App\Http\Controllers\Api\Master\PangkatApiController;
use App\Http\Controllers\Api\Master\RhkPejabatApiController;
use App\Http\Controllers\Api\Master\RhkStaffApiController;
use App\Http\Controllers\Api\Master\UraianTugasApiController;
use App\Http\Controllers\Api\Master\UserApiController;

// ✅ Route login (public)
Route::post('/login', [AuthController::class, 'login'])->name('login');

// ✅ Route yang butuh token (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // 🔐 User profile check
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 🔹 INSTANSI
    Route::prefix('instansi')->name('instansi.')->controller(InstansiApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 JABATAN
    Route::prefix('jabatan')->name('jabatan.')->controller(JabatanApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 PANGKAT
    Route::prefix('pangkat')->name('pangkat.')->controller(PangkatApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 RHK PEJABAT
    Route::prefix('rhk-pejabat')->name('rhk-pejabat.')->controller(RhkPejabatApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 RHK STAFF
    Route::prefix('rhk-staff')->name('rhk-staff.')->controller(RhkStaffApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 URAIAN TUGAS
    Route::prefix('uraian-tugas')->name('uraian-tugas.')->controller(UraianTugasApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // 🔹 USERS
    Route::prefix('users')->name('users.')->controller(UserApiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});
