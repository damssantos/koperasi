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
        
        $dbTransactions = App\Models\TransaksiSimpanan::with('anggota')
            ->orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->get();
            
        $transactions = $dbTransactions->map(function ($tx) {
            return [
                'id' => $tx->id,
                'memberDbId' => $tx->anggota_id,
                'date' => $tx->tanggal_transaksi->format('d M Y'),
                'rawDate' => $tx->tanggal_transaksi->toDateString(),
                'memberId' => optional($tx->anggota)->id_anggota ?? 'AGT-' . str_pad($tx->anggota_id, 5, '0', STR_PAD_LEFT),
                'name' => optional($tx->anggota)->nama ?? 'N/A',
                'type' => $tx->jenis_simpanan,
                'amount' => (int) $tx->nominal,
                'status' => $tx->status,
                'keterangan' => $tx->keterangan ?? '-',
            ];
        });

        $totalSimpanan = (int) App\Models\TransaksiSimpanan::sum('nominal');
        $totalPokok = (int) App\Models\TransaksiSimpanan::where('jenis_simpanan', 'Pokok')->sum('nominal');
        $totalWajib = (int) App\Models\TransaksiSimpanan::where('jenis_simpanan', 'Wajib')->sum('nominal');
        $totalSukarela = (int) App\Models\TransaksiSimpanan::where('jenis_simpanan', 'Sukarela')->sum('nominal');

        // Determine unit based on total amount
        $divisor = 1000000;
        $unitName = 'Juta';
        if ($totalSimpanan >= 1000000000) {
            $divisor = 1000000000;
            $unitName = 'Miliar';
        }

        // 1. Monthly Chart Data
        $currentYear = now()->year;
        $monthlyLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $monthlyData = [];
        $initialBeforeThisYear = (int) App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', '<', $currentYear)->sum('nominal');
        for ($m = 1; $m <= 12; $m++) {
            $sumThisYearUpToM = (int) App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', $currentYear)
                ->whereMonth('tanggal_transaksi', '<=', $m)
                ->sum('nominal');
            $monthlyData[] = round(($initialBeforeThisYear + $sumThisYearUpToM) / $divisor, 2);
        }

        // 2. Weekly Chart Data (for current month)
        $currentMonth = now()->month;
        $weeklyLabels = ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"];
        $weeklyData = [];
        $initialBeforeThisMonth = (int) App\Models\TransaksiSimpanan::where(function ($query) use ($currentYear, $currentMonth) {
            $query->whereYear('tanggal_transaksi', '<', $currentYear)
                  ->orWhere(function ($q) use ($currentYear, $currentMonth) {
                      $q->whereYear('tanggal_transaksi', $currentYear)
                        ->whereMonth('tanggal_transaksi', '<', $currentMonth);
                  });
        })->sum('nominal');

        $weekDays = [7, 14, 21, 31];
        foreach ($weekDays as $day) {
            $sumThisMonthUpToDay = (int) App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', $currentYear)
                ->whereMonth('tanggal_transaksi', $currentMonth)
                ->whereDay('tanggal_transaksi', '<=', $day)
                ->sum('nominal');
            $weeklyData[] = round(($initialBeforeThisMonth + $sumThisMonthUpToDay) / $divisor, 2);
        }

        // 3. Yearly Chart Data (last 4 years)
        $yearlyLabels = [];
        $yearlyData = [];
        for ($y = $currentYear - 3; $y <= $currentYear; $y++) {
            $yearlyLabels[] = (string) $y;
            $sumUpToYear = (int) App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', '<=', $y)->sum('nominal');
            $yearlyData[] = round($sumUpToYear / $divisor, 2);
        }

        $chartDataSets = [
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => $monthlyData,
            ],
            'weekly' => [
                'labels' => $weeklyLabels,
                'data' => $weeklyData,
            ],
            'yearly' => [
                'labels' => $yearlyLabels,
                'data' => $yearlyData,
            ],
            'unit' => $unitName
        ];

        return view('simpanan', [
            'anggota' => $anggota,
            'transactions' => $transactions->values(),
            'totalSimpanan' => $totalSimpanan,
            'totalPokok' => $totalPokok,
            'totalWajib' => $totalWajib,
            'totalSukarela' => $totalSukarela,
            'chartDataSets' => $chartDataSets,
        ]);
    })->name('simpanan');

    Route::post('/simpanan', function (Request $request) {
        $data = $request->validate([
            'anggota_id' => ['required', 'exists:anggota_koperasi,id'],
            'jenis_simpanan' => ['required', 'in:Pokok,Wajib,Sukarela'],
            'nominal' => ['required', 'integer', 'min:1000'],
            'tanggal_transaksi' => ['required', 'date'],
            'status' => ['required', 'in:Aktif,Lunas'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $member = AnggotaKoperasi::findOrFail($data['anggota_id']);
        $field = match ($data['jenis_simpanan']) {
            'Pokok' => 'simpanan_pokok',
            'Wajib' => 'simpanan_wajib',
            'Sukarela' => 'simpanan_sukarela',
        };

        // Update member balance
        $member->{$field} = (int) $member->{$field} + (int) $data['nominal'];
        $member->total_saldo = (int) $member->simpanan_pokok + (int) $member->simpanan_wajib + (int) $member->simpanan_sukarela;
        $member->save();

        // Create transaction record
        App\Models\TransaksiSimpanan::create([
            'anggota_id' => $data['anggota_id'],
            'jenis_simpanan' => $data['jenis_simpanan'],
            'nominal' => $data['nominal'],
            'status' => $data['status'],
            'tanggal_transaksi' => $data['tanggal_transaksi'],
            'keterangan' => $data['keterangan'],
        ]);

        return redirect()->route('simpanan')->with('success', 'Transaksi simpanan berhasil disimpan ke database.');
    })->name('simpanan.store');

    Route::get('/simpanan/{transaction}', function (App\Models\TransaksiSimpanan $transaction) {
        $dateNum = $transaction->tanggal_transaksi->format('Ymd');
        $formattedId = 'TX-' . $dateNum . '-' . str_pad($transaction->id, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'id' => $transaction->id,
            'formattedId' => $formattedId,
            'memberDbId' => $transaction->anggota_id,
            'date' => $transaction->tanggal_transaksi->format('d M Y'),
            'rawDate' => $transaction->tanggal_transaksi->toDateString(),
            'memberId' => optional($transaction->anggota)->id_anggota ?? 'AGT-' . str_pad($transaction->anggota_id, 5, '0', STR_PAD_LEFT),
            'name' => optional($transaction->anggota)->nama ?? 'N/A',
            'type' => $transaction->jenis_simpanan,
            'amount' => (int) $transaction->nominal,
            'status' => $transaction->status,
            'keterangan' => $transaction->keterangan ?? '-',
        ]);
    });

    Route::put('/simpanan/{transaction}', function (Request $request, App\Models\TransaksiSimpanan $transaction) {
        $data = $request->validate([
            'nominal' => ['required', 'integer', 'min:1000'],
            'tanggal_transaksi' => ['required', 'date'],
            'status' => ['required', 'in:Aktif,Lunas'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $member = AnggotaKoperasi::findOrFail($transaction->anggota_id);
        $field = match ($transaction->jenis_simpanan) {
            'Pokok' => 'simpanan_pokok',
            'Wajib' => 'simpanan_wajib',
            'Sukarela' => 'simpanan_sukarela',
        };

        // Revert old nominal, then add new nominal
        $member->{$field} = (int) $member->{$field} - (int) $transaction->nominal + (int) $data['nominal'];
        $member->total_saldo = (int) $member->simpanan_pokok + (int) $member->simpanan_wajib + (int) $member->simpanan_sukarela;
        $member->save();

        // Update transaction
        $transaction->update([
            'nominal' => $data['nominal'],
            'status' => $data['status'],
            'tanggal_transaksi' => $data['tanggal_transaksi'],
            'keterangan' => $data['keterangan'],
        ]);

        return redirect()->route('simpanan')->with('success', 'Transaksi simpanan berhasil diperbarui.');
    })->name('simpanan.update');

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

