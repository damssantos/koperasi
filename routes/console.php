<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Denda otomatis: jalankan sekali sehari (atau manual: php artisan koperasi:hitung-denda)
Artisan::command('koperasi:hitung-denda', function () {
    $count = 0;

    App\Models\Pinjaman::whereIn('status', ['Aktif', 'Menunggak'])
        ->with('anggota')
        ->chunkById(100, function ($loans) use (&$count) {
            foreach ($loans as $loan) {
                $before = $loan->toArray();
                $loan->sinkronDenda();

                if ($loan->wasChanged()) {
                    $count++;

                    App\Services\AuditService::catat(
                        'denda_otomatis',
                        $loan->fresh(),
                        $before,
                        $loan->fresh()->toArray(),
                        'Denda otomatis diperbarui untuk pinjaman #' . $loan->id . '.'
                    );
                }
            }
        });

    $this->info("Denda disinkronkan untuk {$count} pinjaman.");
})->purpose('Hitung denda keterlambatan dan status Menunggak secara otomatis');

Schedule::command('koperasi:hitung-denda')->dailyAt('00:05');
