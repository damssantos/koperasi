<?php

use App\Http\Controllers\Api\ApiTokenController;
use App\Http\Controllers\Api\BuktiController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PembayaranCicilanController;
use App\Http\Controllers\Api\PinjamanController;
use App\Http\Controllers\Api\SimpananController;
use App\Http\Middleware\ApiTokenAuthentication;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('tokens', [ApiTokenController::class, 'store']);
    Route::middleware(ApiTokenAuthentication::class)->group(function () {
        Route::get('simpanan', [SimpananController::class, 'index']);
        Route::post('simpanan', [SimpananController::class, 'store']);
        Route::post('simpanan/penarikan', [SimpananController::class, 'tarik']);
        Route::get('pinjaman', [PinjamanController::class, 'index']);
        Route::put('pinjaman/{pinjaman}', [PinjamanController::class, 'update']);
        Route::patch('pinjaman/{pinjaman}/batalkan', [PinjamanController::class, 'batalkan']);
        Route::get('pinjaman/{pinjaman}/cicilan', [PembayaranCicilanController::class, 'index']);
        Route::post('pinjaman/{pinjaman}/cicilan', [PembayaranCicilanController::class, 'store']);
        Route::put('cicilan/{pembayaran}', [PembayaranCicilanController::class, 'update']);
        Route::get('laporan', [LaporanController::class, 'index']);
        Route::get('laporan/export/{format}', [LaporanController::class, 'export']);
        Route::get('bukti/{jurnal}', [BuktiController::class, 'show']);
    });
});
