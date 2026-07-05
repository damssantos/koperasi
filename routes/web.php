<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Models\AnggotaKoperasi;
use App\Support\SimplePdf;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
}); 

// 3. Proteksi semua halaman dashboard, anggota, DAN profile baru milik mereka
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/print', [AnggotaController::class, 'print'])->name('anggota.print');
    Route::get('/anggota/download-pdf', function () {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();
        $rows = $anggota->map(fn ($item, $index) => [
            $index + 1,
            optional($item->tanggal_join ?? $item->created_at)->format('d M Y'),
            $item->id_anggota ?? 'AGT-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
            $item->nama,
            $item->no_hp ?? '-',
            'Rp ' . number_format((int) $item->simpanan_pokok, 0, ',', '.'),
            'Rp ' . number_format((int) $item->simpanan_wajib, 0, ',', '.'),
            'Rp ' . number_format((int) $item->simpanan_sukarela, 0, ',', '.'),
            'Rp ' . number_format((int) $item->total_saldo, 0, ',', '.'),
        ])->all();

        return response(SimplePdf::table('Data Anggota Koperasi', ['No', 'Tanggal', 'ID', 'Nama', 'HP', 'Pokok', 'Wajib', 'Sukarela', 'Total'], $rows, [
            'Total anggota: ' . number_format($anggota->count(), 0, ',', '.'),
        ]), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="data-anggota-koperasi.pdf"',
        ]);
    })->name('anggota.downloadPdf');
    Route::get('/anggota/{anggota}', [AnggotaController::class, 'show'])->name('anggota.show');
    Route::put('/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    Route::get('/simpanan', function () {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();
        $transactions = collect();

        foreach ($anggota as $member) {
            foreach ([
                'Pokok' => 'simpanan_pokok',
                'Wajib' => 'simpanan_wajib',
                'Sukarela' => 'simpanan_sukarela',
            ] as $type => $field) {
                $amount = (int) $member->{$field};

                if ($amount <= 0) {
                    continue;
                }

                $date = $member->tanggal_join ?? $member->updated_at ?? $member->created_at ?? now();
                $transactions->push([
                    'id' => $member->id . '-' . strtolower($type),
                    'memberDbId' => $member->id,
                    'date' => $date->format('d M Y'),
                    'rawDate' => $date->toDateString(),
                    'memberId' => $member->id_anggota ?? 'AGT-' . str_pad($member->id, 5, '0', STR_PAD_LEFT),
                    'name' => $member->nama,
                    'type' => $type,
                    'amount' => $amount,
                    'status' => 'Aktif',
                ]);
            }
        }

        return view('simpanan', [
            'anggota' => $anggota,
            'transactions' => $transactions->sortByDesc('rawDate')->values(),
            'totalSimpanan' => $anggota->sum('total_saldo'),
            'totalPokok' => $anggota->sum('simpanan_pokok'),
            'totalWajib' => $anggota->sum('simpanan_wajib'),
            'totalSukarela' => $anggota->sum('simpanan_sukarela'),
        ]);
    })->name('simpanan');

    Route::post('/simpanan', function (Request $request) {
        $data = $request->validate([
            'anggota_id' => ['required', 'exists:anggota_koperasi,id'],
            'jenis_simpanan' => ['required', 'in:Pokok,Wajib,Sukarela'],
            'nominal' => ['required', 'integer', 'min:1000'],
        ]);

        $member = AnggotaKoperasi::findOrFail($data['anggota_id']);
        $field = match ($data['jenis_simpanan']) {
            'Pokok' => 'simpanan_pokok',
            'Wajib' => 'simpanan_wajib',
            'Sukarela' => 'simpanan_sukarela',
        };

        $member->{$field} = (int) $member->{$field} + (int) $data['nominal'];
        $member->total_saldo = (int) $member->simpanan_pokok + (int) $member->simpanan_wajib + (int) $member->simpanan_sukarela;
        $member->save();

        return redirect()->route('simpanan')->with('success', 'Transaksi simpanan berhasil disimpan ke database.');
    })->name('simpanan.store');

    Route::get('/simpanan/print', function () {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();

        return view('exports.simpanan-pdf', compact('anggota'));
    })->name('simpanan.print');

    Route::get('/simpanan/download-pdf', function () {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();
        $rows = $anggota->map(fn ($item, $index) => [
            $index + 1,
            $item->id_anggota ?? 'AGT-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
            $item->nama,
            'Rp ' . number_format((int) $item->simpanan_pokok, 0, ',', '.'),
            'Rp ' . number_format((int) $item->simpanan_wajib, 0, ',', '.'),
            'Rp ' . number_format((int) $item->simpanan_sukarela, 0, ',', '.'),
            'Rp ' . number_format((int) $item->total_saldo, 0, ',', '.'),
        ])->all();

        return response(SimplePdf::table('Laporan Simpanan', ['No', 'ID Anggota', 'Nama', 'Pokok', 'Wajib', 'Sukarela', 'Total'], $rows, [
            'Total Simpanan: Rp ' . number_format((int) $anggota->sum('total_saldo'), 0, ',', '.'),
            'Simpanan Pokok: Rp ' . number_format((int) $anggota->sum('simpanan_pokok'), 0, ',', '.'),
            'Simpanan Wajib: Rp ' . number_format((int) $anggota->sum('simpanan_wajib'), 0, ',', '.'),
            'Simpanan Sukarela: Rp ' . number_format((int) $anggota->sum('simpanan_sukarela'), 0, ',', '.'),
        ]), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan-simpanan.pdf"',
        ]);
    })->name('simpanan.downloadPdf');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

