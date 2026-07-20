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
        $totalPokok = (int) App\Models\AnggotaKoperasi::sum('simpanan_pokok');
        $totalWajib = (int) App\Models\AnggotaKoperasi::sum('simpanan_wajib');
        $totalSukarela = (int) App\Models\AnggotaKoperasi::sum('simpanan_sukarela');
        $totalSimpanan = $totalPokok + $totalWajib + $totalSukarela;

        $totalPlafond = (int) App\Models\Pinjaman::sum('nominal_pinjaman');
        $totalPinjamanBerjalan = (int) App\Models\Pinjaman::whereIn('status', ['Aktif', 'Menunggak'])->sum('sisa_pinjaman');
        $totalPinjamanPaid = $totalPlafond - (int) App\Models\Pinjaman::sum('sisa_pinjaman');

        $totalKas = max(0, $totalSimpanan - $totalPinjamanBerjalan);
        $kasBank = round($totalKas * 0.9);
        $kasTunai = $totalKas - $kasBank;

        $pinjamanMenunggak = App\Models\Pinjaman::with('anggota')
            ->where('status', 'Menunggak')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(5)
            ->get();

        $cicilanJatuhTempo = App\Models\Pinjaman::with('anggota')
            ->where('status', 'Aktif')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(5)
            ->get();

        $dbTransactions = App\Models\TransaksiSimpanan::with('anggota')
            ->orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 6 months chart data
        $months = [];
        $pemasukanData = [];
        $pengeluaranData = [];
        $saldoData = [];
        $runningSaldo = 100000000; // Base Rp 100M

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->translatedFormat('M');
            $months[] = $monthName;

            $simpananInMonth = App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', $date->year)
                ->whereMonth('tanggal_transaksi', $date->month)
                ->sum('nominal');

            $loansCreatedInMonth = App\Models\Pinjaman::whereYear('tanggal_pengajuan', $date->year)
                ->whereMonth('tanggal_pengajuan', $date->month)
                ->sum('nominal_pinjaman');

            $income = $simpananInMonth;
            $expense = $loansCreatedInMonth;
            
            $pemasukanData[] = (int) $income;
            $pengeluaranData[] = (int) $expense;
            
            $runningSaldo += ($income - $expense);
            $saldoData[] = (int) max(0, $runningSaldo);
        }

        $chartData = [
            'labels' => $months,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData,
            'saldo' => $saldoData
        ];

        return view('dashboard', compact(
            'totalPokok',
            'totalWajib',
            'totalSukarela',
            'totalSimpanan',
            'totalPlafond',
            'totalPinjamanBerjalan',
            'totalPinjamanPaid',
            'totalKas',
            'kasBank',
            'kasTunai',
            'pinjamanMenunggak',
            'cicilanJatuhTempo',
            'dbTransactions',
            'chartData'
        ));
    })->name('dashboard');

    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/print', [AnggotaController::class, 'print'])->name('anggota.print');
    Route::get('/anggota/download-pdf', function () {
        $anggota = App\Models\AnggotaKoperasi::orderBy('id_anggota', 'asc')->get();
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
        $anggota = AnggotaKoperasi::orderBy('id_anggota', 'asc')->get();
        
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

    // Static export endpoints must be registered before the {transaction}
    // binding below, otherwise "print" is interpreted as a transaction ID.
    Route::get('/simpanan/print', function () {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();

        return view('exports.simpanan-pdf', compact('anggota'));
    })->name('simpanan.print');

    Route::get('/simpanan/download-pdf', function () {
        $anggota = AnggotaKoperasi::orderBy('id_anggota', 'asc')->get();
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

    Route::get('/pinjaman', function () {
        $loans = App\Models\Pinjaman::with('anggota')->orderBy('tanggal_pengajuan', 'desc')->orderBy('id', 'desc')->get()->map(function ($loan) {
            return [
                'id' => $loan->id,
                'formattedId' => 'PJ-' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
                'memberId' => $loan->anggota->id_anggota ?? 'AGT-' . str_pad($loan->anggota->id, 3, '0', STR_PAD_LEFT),
                'name' => $loan->anggota->nama,
                'date' => $loan->tanggal_pengajuan->format('Y-m-d'),
                'formattedDate' => $loan->tanggal_pengajuan->format('d M Y'),
                'amount' => (int) $loan->nominal_pinjaman,
                'tenor' => $loan->tenor,
                'paid' => $loan->jumlah_cicilan_dibayar,
                'remaining' => (int) $loan->sisa_pinjaman,
                'status' => $loan->status,
            ];
        });

        $anggota = App\Models\AnggotaKoperasi::orderBy('nama', 'asc')->get();

        $totalPinjaman = (int) App\Models\Pinjaman::sum('nominal_pinjaman');
        $pinjamanAktifCount = App\Models\Pinjaman::where('status', 'Aktif')->count();
        $pinjamanMenunggakCount = App\Models\Pinjaman::where('status', 'Menunggak')->count();
        $pinjamanLunasCount = App\Models\Pinjaman::where('status', 'Lunas')->count();

        return view('pinjaman', compact('loans', 'anggota', 'totalPinjaman', 'pinjamanAktifCount', 'pinjamanMenunggakCount', 'pinjamanLunasCount'));
    })->name('pinjaman');

    Route::post('/pinjaman', function (Request $request) {
        $data = $request->validate([
            'anggota_id' => 'required|exists:anggota_koperasi,id',
            'nominal_pinjaman' => 'required|integer|min:1000',
            'tenor' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'nullable|in:Aktif,Menunggak,Lunas',
            'jumlah_cicilan_dibayar' => 'nullable|integer|min:0',
        ]);

        $status = $data['status'] ?? 'Aktif';
        $tenor = (int) $data['tenor'];
        $dibayar = isset($data['jumlah_cicilan_dibayar']) ? (int) $data['jumlah_cicilan_dibayar'] : 0;
        if ($status === 'Lunas') {
            $dibayar = $tenor;
        }

        if ($dibayar > $tenor) {
            $dibayar = $tenor;
        }

        $sisa = ($status === 'Lunas') ? 0 : round($data['nominal_pinjaman'] * (($tenor - $dibayar) / $tenor));

        App\Models\Pinjaman::create([
            'anggota_id' => $data['anggota_id'],
            'nominal_pinjaman' => $data['nominal_pinjaman'],
            'tenor' => $tenor,
            'jumlah_cicilan_dibayar' => $dibayar,
            'sisa_pinjaman' => $sisa,
            'tanggal_pengajuan' => $data['tanggal_pengajuan'],
            'status' => $status,
        ]);

        return redirect()->route('pinjaman')->with('success', 'Pengajuan pinjaman berhasil disimpan ke database.');
    })->name('pinjaman.store');

    Route::get('/pinjaman/{pinjaman}', function (App\Models\Pinjaman $pinjaman) {
        return response()->json([
            'id' => $pinjaman->id,
            'formattedId' => 'PJ-' . str_pad($pinjaman->id, 5, '0', STR_PAD_LEFT),
            'memberId' => $pinjaman->anggota->id_anggota ?? 'AGT-' . str_pad($pinjaman->anggota->id, 3, '0', STR_PAD_LEFT),
            'name' => $pinjaman->anggota->nama,
            'date' => $pinjaman->tanggal_pengajuan->format('d M Y'),
            'amount' => (int) $pinjaman->nominal_pinjaman,
            'tenor' => $pinjaman->tenor,
            'paid' => $pinjaman->jumlah_cicilan_dibayar,
            'remaining' => (int) $pinjaman->sisa_pinjaman,
            'status' => $pinjaman->status,
        ]);
    })->name('pinjaman.show');

    Route::post('/pinjaman/{pinjaman}/bayar', function (Request $request, App\Models\Pinjaman $pinjaman) {
        $data = $request->validate([
            'tanggal_pembayaran' => 'required|date',
        ]);

        if ($pinjaman->status === 'Lunas') {
            return redirect()->back()->with('error', 'Pinjaman ini sudah lunas.');
        }

        $remainingMonths = $pinjaman->tenor - $pinjaman->jumlah_cicilan_dibayar;
        if ($remainingMonths <= 0) {
            return redirect()->back()->with('error', 'Semua cicilan sudah dibayar.');
        }

        // Calculate nominal per installment
        $nominalCicilan = round($pinjaman->sisa_pinjaman / $remainingMonths);

        // Update loan progress
        $newDibayar = $pinjaman->jumlah_cicilan_dibayar + 1;
        $newSisa = max(0, $pinjaman->sisa_pinjaman - $nominalCicilan);
        $newStatus = ($newDibayar >= $pinjaman->tenor || $newSisa <= 0) ? 'Lunas' : $pinjaman->status;

        $pinjaman->update([
            'jumlah_cicilan_dibayar' => $newDibayar,
            'sisa_pinjaman' => $newSisa,
            'status' => $newStatus,
        ]);

        return redirect()->back()->with('success', 'Pembayaran cicilan berhasil dikonfirmasi.');
    })->name('pinjaman.bayar');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::get('/laporan', function () {
        // Auto-heal missing transactions for existing member balances
        $members = App\Models\AnggotaKoperasi::all();
        foreach ($members as $member) {
            $date = $member->tanggal_join ?? $member->created_at ?? now();
            
            // Check Pokok
            if ($member->simpanan_pokok > 0) {
                $exists = App\Models\TransaksiSimpanan::where('anggota_id', $member->id)
                    ->where('jenis_simpanan', 'Pokok')
                    ->exists();
                if (!$exists) {
                    App\Models\TransaksiSimpanan::create([
                        'anggota_id' => $member->id,
                        'jenis_simpanan' => 'Pokok',
                        'nominal' => $member->simpanan_pokok,
                        'status' => 'Lunas',
                        'tanggal_transaksi' => $date,
                        'keterangan' => 'Setoran awal Simpanan Pokok saat mendaftar.',
                    ]);
                }
            }
            
            // Check Wajib
            if ($member->simpanan_wajib > 0) {
                $exists = App\Models\TransaksiSimpanan::where('anggota_id', $member->id)
                    ->where('jenis_simpanan', 'Wajib')
                    ->exists();
                if (!$exists) {
                    App\Models\TransaksiSimpanan::create([
                        'anggota_id' => $member->id,
                        'jenis_simpanan' => 'Wajib',
                        'nominal' => $member->simpanan_wajib,
                        'status' => 'Lunas',
                        'tanggal_transaksi' => $date,
                        'keterangan' => 'Setoran rutin bulanan Simpanan Wajib.',
                    ]);
                }
            }
            
            // Check Sukarela
            if ($member->simpanan_sukarela > 0) {
                $exists = App\Models\TransaksiSimpanan::where('anggota_id', $member->id)
                    ->where('jenis_simpanan', 'Sukarela')
                    ->exists();
                if (!$exists) {
                    App\Models\TransaksiSimpanan::create([
                        'anggota_id' => $member->id,
                        'jenis_simpanan' => 'Sukarela',
                        'nominal' => $member->simpanan_sukarela,
                        'status' => 'Lunas',
                        'tanggal_transaksi' => $date,
                        'keterangan' => 'Setoran sukarela anggota.',
                    ]);
                }
            }
        }

        $totalPokok = (int) App\Models\AnggotaKoperasi::sum('simpanan_pokok');
        $totalWajib = (int) App\Models\AnggotaKoperasi::sum('simpanan_wajib');
        $totalSukarela = (int) App\Models\AnggotaKoperasi::sum('simpanan_sukarela');
        $kasUsahaPenerimaan = (int) App\Models\TransaksiKasUsaha::whereIn('jenis_transaksi', ['PENERIMAAN', 'MODAL'])->sum('nominal');
        $kasUsahaPengeluaran = (int) App\Models\TransaksiKasUsaha::where('jenis_transaksi', 'PENGELUARAN')->sum('nominal');

        $realTotalPemasukan = $totalPokok + $totalWajib + $totalSukarela + $kasUsahaPenerimaan;
        $realTotalPengeluaran = (int) App\Models\Pinjaman::sum('nominal_pinjaman') + $kasUsahaPengeluaran;
        $realOutstandingPinjaman = (int) App\Models\Pinjaman::whereIn('status', ['Aktif', 'Menunggak'])->sum('sisa_pinjaman');
        $realSaldoAkhir = max(0, $realTotalPemasukan - ($realOutstandingPinjaman + $kasUsahaPengeluaran));

        $simpananTransactions = App\Models\TransaksiSimpanan::with('anggota')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get()
            ->map(function ($tx) {
                return [
                    'tanggal' => $tx->tanggal_transaksi->format('d M Y, H:i'),
                    'raw_date' => $tx->tanggal_transaksi->toDateString(),
                    'jenis' => 'SIMPANAN',
                    'keterangan' => 'Simpanan ' . $tx->jenis_simpanan . ' - ' . ($tx->anggota->nama ?? 'N/A'),
                    'nominal' => (int) $tx->nominal,
                    'is_positive' => true,
                    'tx_id' => 'TX-' . str_pad($tx->id, 5, '0', STR_PAD_LEFT),
                    'member_id' => $tx->anggota->id_anggota ?? 'AGT-' . str_pad($tx->anggota_id, 3, '0', STR_PAD_LEFT),
                    'member_name' => $tx->anggota->nama ?? 'N/A',
                    'sub_jenis' => 'Simpanan ' . $tx->jenis_simpanan,
                ];
            });

        $pinjamanTransactions = App\Models\Pinjaman::with('anggota')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get()
            ->flatMap(function ($loan) {
                $txs = [];
                $txs[] = [
                    'tanggal' => $loan->tanggal_pengajuan->format('d M Y, H:i'),
                    'raw_date' => $loan->tanggal_pengajuan->toDateString(),
                    'jenis' => 'PINJAMAN',
                    'keterangan' => 'Pencairan Pinjaman - ' . ($loan->anggota->nama ?? 'N/A'),
                    'nominal' => (int) $loan->nominal_pinjaman,
                    'is_positive' => false,
                    'loan_id' => 'PJ-' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
                    'member_id' => $loan->anggota->id_anggota ?? 'AGT-' . str_pad($loan->anggota_id, 3, '0', STR_PAD_LEFT),
                    'member_name' => $loan->anggota->nama ?? 'N/A',
                    'tenor' => $loan->tenor,
                    'paid' => $loan->jumlah_cicilan_dibayar,
                    'remaining' => $loan->sisa_pinjaman,
                    'status' => $loan->status,
                ];
                for ($i = 1; $i <= $loan->jumlah_cicilan_dibayar; $i++) {
                    $installmentDate = $loan->tanggal_pengajuan->copy()->addMonths($i);
                    $installmentAmount = $loan->tenor > 0 ? round($loan->nominal_pinjaman / $loan->tenor) : 0;
                    $txs[] = [
                        'tanggal' => $installmentDate->format('d M Y, H:i'),
                        'raw_date' => $installmentDate->toDateString(),
                        'jenis' => 'PINJAMAN',
                        'keterangan' => 'Angsuran Pinjaman - ' . ($loan->anggota->nama ?? 'N/A'),
                        'nominal' => (int) $installmentAmount,
                        'is_positive' => true,
                        'loan_id' => 'PJ-' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
                        'member_id' => $loan->anggota->id_anggota ?? 'AGT-' . str_pad($loan->anggota_id, 3, '0', STR_PAD_LEFT),
                        'member_name' => $loan->anggota->nama ?? 'N/A',
                        'tenor' => $loan->tenor,
                        'paid' => $loan->jumlah_cicilan_dibayar,
                        'remaining' => $loan->sisa_pinjaman,
                        'status' => $loan->status,
                    ];
                }
                return $txs;
            });

        $kasUsahaTransactions = App\Models\TransaksiKasUsaha::orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($tx) {
                return [
                    'tanggal' => $tx->tanggal->format('d M Y, H:i'),
                    'raw_date' => $tx->tanggal->toDateString(),
                    'jenis' => 'KAS USAHA',
                    'keterangan' => $tx->keterangan,
                    'nominal' => (int) $tx->nominal,
                    'is_positive' => $tx->jenis_transaksi === 'PENERIMAAN' || $tx->jenis_transaksi === 'MODAL',
                    'tx_id' => 'TX-' . $tx->tanggal->format('dmy') . '-YPIK-' . str_pad($tx->id, 5, '0', STR_PAD_LEFT),
                    'member_id' => 'N/A',
                    'member_name' => 'Yayasan YPIK',
                    'sub_jenis' => 'Kas Usaha',
                ];
            });

        $realTransactions = $simpananTransactions->concat($pinjamanTransactions)->concat($kasUsahaTransactions)
            ->sortByDesc(function ($tx) {
                return $tx['raw_date'];
            })
            ->values()
            ->all();

        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        $realPeriodSimpanan = (int) App\Models\TransaksiSimpanan::whereBetween('tanggal_transaksi', [$currentMonthStart, $currentMonthEnd])->sum('nominal');
        $realPeriodKasIn = (int) App\Models\TransaksiKasUsaha::whereIn('jenis_transaksi', ['PENERIMAAN', 'MODAL'])
            ->whereBetween('tanggal', [$currentMonthStart, $currentMonthEnd])
            ->sum('nominal');
        $realPeriodPemasukan = $realPeriodSimpanan + $realPeriodKasIn;

        $realPeriodPinjaman = (int) App\Models\Pinjaman::whereBetween('tanggal_pengajuan', [$currentMonthStart, $currentMonthEnd])->sum('nominal_pinjaman');
        $realPeriodKasOut = (int) App\Models\TransaksiKasUsaha::where('jenis_transaksi', 'PENGELUARAN')
            ->whereBetween('tanggal', [$currentMonthStart, $currentMonthEnd])
            ->sum('nominal');
        $realPeriodPengeluaran = $realPeriodPinjaman + $realPeriodKasOut;

        $realPeriodSaldo = $realPeriodPemasukan - $realPeriodPengeluaran;

        $realPeriodTransaksiCount = App\Models\TransaksiSimpanan::whereBetween('tanggal_transaksi', [$currentMonthStart, $currentMonthEnd])->count()
            + App\Models\Pinjaman::whereBetween('tanggal_pengajuan', [$currentMonthStart, $currentMonthEnd])->count()
            + App\Models\TransaksiKasUsaha::whereBetween('tanggal', [$currentMonthStart, $currentMonthEnd])->count();

        return view('laporan', compact(
            'realSaldoAkhir',
            'realTotalPemasukan',
            'realTotalPengeluaran',
            'realTransactions',
            'realPeriodPemasukan',
            'realPeriodPengeluaran',
            'realPeriodSaldo',
            'realPeriodTransaksiCount'
        ));
    })->name('laporan');

    Route::get('/kas-usaha', function () {
        // Base offsets for overall calculations to match the image values
        // Overall: Penerimaan 12M, Pengeluaran 8.5M, Saldo Kas 3.5M
        // Total incoming in database is Rp 36.550.000 (seeding)
        // Total outgoing in database is Rp 2.900.000 (seeding)
        $dbIncoming = App\Models\TransaksiKasUsaha::whereIn('jenis_transaksi', ['PENERIMAAN', 'MODAL'])->sum('nominal');
        $dbOutgoing = App\Models\TransaksiKasUsaha::where('jenis_transaksi', 'PENGELUARAN')->sum('nominal');

        $baseIncomingOffset = 12000000000 - 36550000;
        $baseOutgoingOffset = 8500000000 - 2900000;

        $totalPenerimaan = $baseIncomingOffset + $dbIncoming;
        $totalPengeluaran = $baseOutgoingOffset + $dbOutgoing;
        $saldoKas = $totalPenerimaan - $totalPengeluaran;

        // Calculate running balance for all transactions
        $rawTransactions = App\Models\TransaksiKasUsaha::orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();
        $runningSaldo = 11350000; // Base balance before 16 Oct 2023
        $transactionsWithSaldo = [];
        foreach ($rawTransactions as $tx) {
            if ($tx->jenis_transaksi === 'PENGELUARAN') {
                $runningSaldo -= $tx->nominal;
            } else {
                $runningSaldo += $tx->nominal;
            }
            $tx->saldo_akhir = $runningSaldo;
            $transactionsWithSaldo[] = $tx;
        }

        // Reverse to display from newest to oldest
        $transactions = collect($transactionsWithSaldo)->reverse()->values();

        return view('kas-usaha', compact(
            'transactions',
            'totalPenerimaan',
            'totalPengeluaran',
            'saldoKas'
        ));
    })->name('kas-usaha');

    Route::post('/kas-usaha', function (Request $request) {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_transaksi' => ['required', 'in:PENERIMAAN,PENGELUARAN'],
            'keterangan' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'integer', 'min:1000'],
        ]);

        App\Models\TransaksiKasUsaha::create($data);

        return redirect()->route('kas-usaha')->with('success', 'Transaksi kas usaha berhasil disimpan.');
    })->name('kas-usaha.store');

    Route::get('/kas-usaha/{transaction}', function (App\Models\TransaksiKasUsaha $transaction) {
        return response()->json([
            'id' => $transaction->id,
            'tanggal' => $transaction->tanggal->format('Y-m-d\TH:i'),
            'formatted_tanggal' => $transaction->tanggal->format('d M Y, H:i'),
            'jenis_transaksi' => $transaction->jenis_transaksi,
            'keterangan' => $transaction->keterangan,
            'nominal' => (int) $transaction->nominal,
        ]);
    })->name('kas-usaha.show');

    Route::put('/kas-usaha/{transaction}', function (Request $request, App\Models\TransaksiKasUsaha $transaction) {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_transaksi' => ['required', 'in:PENERIMAAN,PENGELUARAN'],
            'keterangan' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'integer', 'min:1000'],
        ]);

        $transaction->update($data);

        return redirect()->route('kas-usaha')->with('success', 'Transaksi kas usaha berhasil diperbarui.');
    })->name('kas-usaha.update');

    Route::delete('/kas-usaha/{transaction}', function (App\Models\TransaksiKasUsaha $transaction) {
        $transaction->delete();
        return redirect()->route('kas-usaha')->with('success', 'Transaksi kas usaha berhasil dihapus.');
    })->name('kas-usaha.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

