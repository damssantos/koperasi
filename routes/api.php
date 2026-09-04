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

    // API TOKEN
    Route::post('tokens', [ApiTokenController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | API yang membutuhkan token
    |--------------------------------------------------------------------------
    */
    Route::middleware(ApiTokenAuthentication::class)->group(function () {

        // =========================
        // SIMPANAN
        // =========================
        Route::get('simpanan', [SimpananController::class, 'index']);
        Route::post('simpanan', [SimpananController::class, 'store']);
        Route::post('simpanan/penarikan', [SimpananController::class, 'tarik']);


        // =========================
        // PINJAMAN
        // =========================

        // Tampilkan data pinjaman
        Route::get('pinjaman', [PinjamanController::class, 'index']);

        // Update data pinjaman
        Route::put('pinjaman/{pinjaman}', [PinjamanController::class, 'update']);

        // Ubah status pinjaman
        Route::patch(
            'pinjaman/{pinjaman}/status',
            [PinjamanController::class, 'updateStatus']
        );

        // Upload bukti transfer
        Route::post(
            'pinjaman/{pinjaman}/bukti',
            [PinjamanController::class, 'uploadBukti']
        );

        // Batalkan pinjaman
        Route::patch(
            'pinjaman/{pinjaman}/batalkan',
            [PinjamanController::class, 'batalkan']
        );


        // =========================
        // CICILAN
        // =========================

        Route::get(
            'pinjaman/{pinjaman}/cicilan',
            [PembayaranCicilanController::class, 'index']
        );

        Route::post(
            'pinjaman/{pinjaman}/cicilan',
            [PembayaranCicilanController::class, 'store']
        );

        Route::put(
            'cicilan/{pembayaran}',
            [PembayaranCicilanController::class, 'update']
        );


        // =========================
        // LAPORAN
        // =========================

        Route::get(
            'laporan',
            [LaporanController::class, 'index']
        );

        Route::get(
            'laporan/export/{format}',
            [LaporanController::class, 'export']
        );


        // =========================
        // BUKTI / JURNAL
        // =========================

        Route::get(
            'bukti/{jurnal}',
            [BuktiController::class, 'show']
        );
    });
});