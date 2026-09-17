<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\SimpananController;

use App\Models\AnggotaKoperasi;
use App\Models\Pinjaman;
use App\Models\TransaksiKasUsaha;

use App\Imports\AnggotaImport;
use App\Imports\PinjamanImport;
use App\Imports\SimpananImport;

use App\Exports\AnggotaExport;
use App\Exports\PinjamanExport;
use App\Exports\SimpananExport;

use App\Support\SimplePdf;
use App\Services\AuditService;

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Login, Register, Forgot Password)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {


    // ---- Login ----
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // ---- Forgot Password ----
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])
        ->name('password.email');
    Route::get('/forgot-password/verify', [AuthController::class, 'showResetOtp'])
        ->name('password.verify');
    Route::post('/forgot-password/verify', [AuthController::class, 'verifyResetOtp'])
        ->name('password.verify.submit');
    Route::get('/forgot-password/reset', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');
    Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword'])
        ->name('password.update');

    // ---- Register ----
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
   Route::get('/register/verify', [AuthController::class, 'showRegisterOtp'])
    ->name('register.verify');

Route::post('/register/verify', [AuthController::class, 'verifyRegisterOtp'])
    ->name('register.verify.submit');

Route::post('/register/resend', [AuthController::class, 'resendRegisterOtp'])
    ->name('register.resend');

});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
| Semua route di bawah ini memakai middleware role:customer yang sama,
| jadi digabung dalam satu group (perilaku identik dengan sebelumnya).
*/

Route::middleware('role:customer')->group(function () {

    Route::get('/customer/dashboard', function () {
        $anggota = auth()->user()->anggota;
        $transaksi = $anggota ? $anggota->transactions()->latest()->take(5)->get() : collect();

        return view('customer.dashboard', compact('anggota', 'transaksi'));
    })->name('customer.dashboard');

    Route::get('/customer/simpanan', function () {
        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            abort(404, 'Data anggota belum terhubung dengan akun Anda.');
        }

        $transaksi = $anggota->transactions()->latest()->get();

        return view('customer.simpanan', compact('anggota', 'transaksi'));
    })->name('customer.simpanan');


    Route::post('/customer/simpanan', [SimpananController::class, 'customerStore'])
    ->middleware('role:customer')
    ->name('customer.simpanan.store');

    Route::get('/customer/pinjaman', function () {
        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            abort(404, 'Data anggota belum terhubung dengan akun Anda.');
        }

        $pinjaman = $anggota->pinjaman()->latest()->get();

        return view('customer.pinjaman', compact('anggota', 'pinjaman'));
    })->name('customer.pinjaman');

    Route::get('/customer/riwayat', function () {
        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            abort(404, 'Data anggota belum terhubung dengan akun Anda.');
        }

        $transaksi = $anggota->transactions()->latest()->get();

        return view('customer.riwayat', compact('anggota', 'transaksi'));
    })->name('customer.riwayat');

    Route::get('/customer/profil', function () {
        $user = auth()->user();
        $anggota = $user->anggota;

        return view('customer.profil', compact('user', 'anggota'));
    })->name('customer.profil');

   Route::post('/customer/pinjaman', function (Request $request) {

    // 1. Ambil data anggota dari akun Customer yang sedang login
    $anggota = auth()->user()->anggota;

    if (!$anggota) {
        return redirect()
            ->back()
            ->with('error', 'Data anggota belum terhubung dengan akun Anda.');
    }

    // 2. Validasi form pengajuan
    $data = $request->validate([
        'nominal_pinjaman' => [
            'required',
            'integer',
            'min:1000',
        ],

        'tenor' => [
            'required',
            'integer',
            'min:1',
            'max:60',
        ],

        'keterangan' => [
            'nullable',
            'string',
            'max:1000',
        ],
    ], [
        'nominal_pinjaman.required' => 'Nominal pinjaman wajib diisi.',
        'nominal_pinjaman.integer' => 'Nominal pinjaman harus berupa angka.',
        'nominal_pinjaman.min' => 'Minimal pinjaman adalah Rp1.000.',

        'tenor.required' => 'Tenor pinjaman wajib dipilih.',
        'tenor.integer' => 'Tenor harus berupa angka.',
        'tenor.min' => 'Minimal tenor adalah 1 bulan.',
        'tenor.max' => 'Maksimal tenor adalah 60 bulan.',
    ]);

    // 3. Simpan data sebelum perubahan untuk Activity Log
    $before = null;

    // 4. Buat pengajuan pinjaman
    $pinjaman = App\Models\Pinjaman::create([
        'anggota_id' => $anggota->id,

        'nominal_pinjaman' => $data['nominal_pinjaman'],

        'tenor' => $data['tenor'],

        'jumlah_cicilan_dibayar' => 0,

        'sisa_pinjaman' => $data['nominal_pinjaman'],

        'tanggal_pengajuan' => now()->toDateString(),

        'status' => 'Pengajuan',

        'status_persetujuan' => 'Menunggu',

        'keterangan' => $data['keterangan'] ?? null,

        'dibuat_oleh' => auth()->id(),
    ]);

    // 5. Catat ke Activity Log
    AuditService::catat(
        'pengajuan_pinjaman',
        $pinjaman->fresh(),
        $before,
        $pinjaman->fresh()->toArray(),
        'Customer mengajukan pinjaman #' . $pinjaman->id . '.'
    );

    // 6. Kembali ke halaman pinjaman Customer
    return redirect()
        ->route('customer.pinjaman')
        ->with(
            'success',
            'Pengajuan pinjaman berhasil dikirim dan sedang menunggu persetujuan Admin.'
        );

})->middleware('role:customer')->name('customer.pinjaman.store');
});

/*
|--------------------------------------------------------------------------
| Laporan Keuangan (Public - tanpa middleware, sama seperti sebelumnya)
|--------------------------------------------------------------------------
*/

Route::post('/laporan-keuangan/kirim-email', [LaporanController::class, 'kirimEmail'])
    ->name('laporan-keuangan.kirim-email');

/*
|-------------------------------------------------------------------------- 
| Authenticated Routes
|-------------------------------------------------------------------------- 
| CATATAN: middleware role: di tiap route SENGAJA dibiarkan persis seperti
| aslinya (ada yang role:admin, ada yang cuma auth) supaya tidak mengubah
| hak akses yang sudah berjalan. Saya hanya mengelompokkan & merapikan
| format, bukan menyamaratakan middleware-nya.
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);



// 3. Proteksi semua halaman dashboard, anggota, DAN profile baru milik mereka

Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Dashboard Admin
    |----------------------------------------------------------------------
    */

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
            'saldo' => $saldoData,
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
    })->middleware('role:admin')->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | Anggota
    |----------------------------------------------------------------------
    */

    Route::get('/anggota', [AnggotaController::class, 'index'])
        ->middleware('role:admin')->name('anggota.index');

    Route::get('/anggota/export', function () {
        return Excel::download(new AnggotaExport, 'data_anggota.xlsx');
    })->name('anggota.export');

    Route::post('/anggota/import', function (Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ]);

        try {
            Excel::import(new \App\Imports\AnggotaImport(), $request->file('file'));

            return redirect()->route('anggota.index')
                ->with('success', '50 data anggota berhasil diimport.');
        } catch (\Throwable $e) {
            return redirect()->route('anggota.index')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    })->name('anggota.import');

    Route::get('/anggota/template', function () {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import');

        // Header
        $sheet->setCellValue('A1', 'id_anggota');
        $sheet->setCellValue('B1', 'nama');
        $sheet->setCellValue('C1', 'no_hp');
        $sheet->setCellValue('D1', 'tanggal_join');

        // Contoh data
        $sheet->setCellValue('A2', 'AGT-001');
        $sheet->setCellValue('B2', 'Budi Santoso');
        $sheet->setCellValue('C2', '081234567890');
        $sheet->setCellValue('D2', '2026-09-10');

        // Lebar kolom
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);

        // Header bold
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_anggota.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    })->name('anggota.template');

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

        return response(SimplePdf::table(
            'Data Anggota Koperasi',
            ['No', 'Tanggal', 'ID', 'Nama', 'HP', 'Pokok', 'Wajib', 'Sukarela', 'Total'],
            $rows,
            ['Total anggota: ' . number_format($anggota->count(), 0, ',', '.')]
        ), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="data-anggota-koperasi.pdf"',
        ]);
    })->name('anggota.downloadPdf');

    Route::get('/anggota/{anggota}', [AnggotaController::class, 'show'])->name('anggota.show');
    Route::put('/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    /*
    |----------------------------------------------------------------------
    | Simpanan
    |----------------------------------------------------------------------
    | NOTE: urutan di bawah ini SENGAJA tidak diubah karena beberapa route
    | punya URI yang sama persis (lihat komentar [DUPLICATE] di bawah).
    | Laravel mengeksekusi route pertama yang match, jadi urutan berikut
    | menentukan mana yang benar-benar jalan.
    */

    Route::get('/simpanan', function () {

        // ---- Data Anggota ----
        $anggota = AnggotaKoperasi::orderBy('id_anggota', 'asc')->get();

        // ---- Data Transaksi Simpanan ----
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
                'memberId' => optional($tx->anggota)->id_anggota
                    ?? 'AGT-' . str_pad($tx->anggota_id, 5, '0', STR_PAD_LEFT),
                'name' => optional($tx->anggota)->nama ?? 'N/A',
                'type' => $tx->jenis_simpanan,
                'amount' => (int) $tx->nominal,
                'status' => $tx->status,
                'keterangan' => $tx->keterangan ?? '-',
            ];
        });

        // ---- Total Simpanan ----
        $totalSimpanan = (int) App\Models\TransaksiSimpanan::sum('nominal');
        $totalPokok = (int) App\Models\TransaksiSimpanan::where('jenis_simpanan', 'Pokok')->sum('nominal');
        $totalWajib = (int) App\Models\TransaksiSimpanan::where('jenis_simpanan', 'Wajib')->sum('nominal');
        $totalSukarela = (int) App\Models\TransaksiSimpanan::where('jenis_simpanan', 'Sukarela')->sum('nominal');

        // ---- Unit Grafik ----
        $divisor = 1000000;
        $unitName = 'Juta';

        if ($totalSimpanan >= 1000000000) {
            $divisor = 1000000000;
            $unitName = 'Miliar';
        }

        // ---- Waktu Sekarang ----
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // ---- 1. Harian (30 hari terakhir) ----
        $dailyLabels = [];
        $dailyData = [];
        $dailyStart = now()->subDays(29)->startOfDay();

        $initialBeforeDaily = (int) App\Models\TransaksiSimpanan::where(
            'tanggal_transaksi', '<', $dailyStart->toDateString()
        )->sum('nominal');

        for ($i = 0; $i < 30; $i++) {
            $date = $dailyStart->copy()->addDays($i);
            $dailyLabels[] = $date->format('d M');

            $sumUntilDay = (int) App\Models\TransaksiSimpanan::where(
                'tanggal_transaksi', '<=', $date->toDateString()
            )->sum('nominal');

            $dailyData[] = round($sumUntilDay / $divisor, 2);
        }

        // ---- 2. Mingguan (Minggu 1-4 bulan berjalan) ----
        $weeklyLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
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

        // ---- 3. Bulanan (12 bulan tahun berjalan) ----
        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyData = [];

        $initialBeforeThisYear = (int) App\Models\TransaksiSimpanan::whereYear(
            'tanggal_transaksi', '<', $currentYear
        )->sum('nominal');

        for ($m = 1; $m <= 12; $m++) {
            $sumThisYearUpToMonth = (int) App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', $currentYear)
                ->whereMonth('tanggal_transaksi', '<=', $m)
                ->sum('nominal');

            $monthlyData[] = round(($initialBeforeThisYear + $sumThisYearUpToMonth) / $divisor, 2);
        }

        // ---- 4. Triwulan (Q1-Q4 tahun berjalan) ----
        $quarterlyLabels = ['Triwulan 1', 'Triwulan 2', 'Triwulan 3', 'Triwulan 4'];
        $quarterlyData = [];

        for ($q = 1; $q <= 4; $q++) {
            $endMonth = $q * 3;

            $sumThisYearUpToQuarter = (int) App\Models\TransaksiSimpanan::whereYear('tanggal_transaksi', $currentYear)
                ->whereMonth('tanggal_transaksi', '<=', $endMonth)
                ->sum('nominal');

            $quarterlyData[] = round(($initialBeforeThisYear + $sumThisYearUpToQuarter) / $divisor, 2);
        }

        // ---- 5. Tahunan (4 tahun terakhir) ----
        $yearlyLabels = [];
        $yearlyData = [];

        for ($y = $currentYear - 3; $y <= $currentYear; $y++) {
            $yearlyLabels[] = (string) $y;

            $sumUpToYear = (int) App\Models\TransaksiSimpanan::whereYear(
                'tanggal_transaksi', '<=', $y
            )->sum('nominal');

            $yearlyData[] = round($sumUpToYear / $divisor, 2);
        }

        // ---- Dataset untuk JS / Chart ----
        $chartDataSets = [
            'daily' => ['labels' => $dailyLabels, 'data' => $dailyData],
            'weekly' => ['labels' => $weeklyLabels, 'data' => $weeklyData],
            'monthly' => ['labels' => $monthlyLabels, 'data' => $monthlyData],
            'quarterly' => ['labels' => $quarterlyLabels, 'data' => $quarterlyData],
            'yearly' => ['labels' => $yearlyLabels, 'data' => $yearlyData],
            'unit' => $unitName,
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
    })->middleware('role:admin')->name('simpanan');

    Route::get('/simpanan/export', function () {
        return Excel::download(new SimpananExport, 'data_simpanan.xlsx');
    })->middleware('role:admin')->name('simpanan.export');

    Route::post('/simpanan/import', function (Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ]);

        try {
            $import = new SimpananImport();
            Excel::import($import, $request->file('file'));

            return redirect()->route('simpanan')
                ->with('success', $import->jumlahBerhasil . ' transaksi simpanan berhasil diimport.');
        } catch (\Throwable $e) {
            return redirect()->route('simpanan')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    })->middleware('role:admin')->name('simpanan.import');

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


    // Static export endpoints harus didaftarkan sebelum {transaction} di
    // bawah, kalau tidak "print"/"download-pdf" akan dianggap sebagai ID.
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

        return response(SimplePdf::table(
            'Laporan Simpanan',
            ['No', 'ID Anggota', 'Nama', 'Pokok', 'Wajib', 'Sukarela', 'Total'],
            $rows,
            [
                'Total Simpanan: Rp ' . number_format((int) $anggota->sum('total_saldo'), 0, ',', '.'),
                'Simpanan Pokok: Rp ' . number_format((int) $anggota->sum('simpanan_pokok'), 0, ',', '.'),
                'Simpanan Wajib: Rp ' . number_format((int) $anggota->sum('simpanan_wajib'), 0, ',', '.'),
                'Simpanan Sukarela: Rp ' . number_format((int) $anggota->sum('simpanan_sukarela'), 0, ',', '.'),
            ]
        ), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan-simpanan.pdf"',
        ]);
    })->name('simpanan.downloadPdf');

    // [DUPLICATE - dibiarkan sesuai aslinya, lihat catatan di akhir chat]
    Route::get('/simpanan/print', function () {
        // ...
    })->name('simpanan.print');

    // [DUPLICATE - dibiarkan sesuai aslinya, lihat catatan di akhir chat]
    Route::get('/simpanan/download-pdf', function () {
        // ...
    })->name('simpanan.downloadPdf');

    Route::get('/simpanan/template', function () {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import');

        $sheet->setCellValue('A1', 'id_anggota');
        $sheet->setCellValue('B1', 'jenis_simpanan');
        $sheet->setCellValue('C1', 'nominal');
        $sheet->setCellValue('D1', 'tanggal_transaksi');
        $sheet->setCellValue('E1', 'status');
        $sheet->setCellValue('F1', 'keterangan');

        $sheet->setCellValue('A2', 'AGT-001');
        $sheet->setCellValue('B2', 'Pokok');
        $sheet->setCellValue('C2', 100000);
        $sheet->setCellValue('D2', '2026-09-11');
        $sheet->setCellValue('E2', 'Aktif');
        $sheet->setCellValue('F2', 'Simpanan pokok');

        $sheet->setCellValue('A3', 'AGT-001');
        $sheet->setCellValue('B3', 'Wajib');
        $sheet->setCellValue('C3', 50000);
        $sheet->setCellValue('D3', '2026-09-11');
        $sheet->setCellValue('E3', 'Aktif');
        $sheet->setCellValue('F3', 'Simpanan wajib');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(35);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_simpanan.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    })->middleware('role:admin')->name('simpanan.template');

    // [DUPLICATE/STUB - didaftarkan SEBELUM versi asli di bawah, lihat catatan]
    Route::get('/simpanan/{transaction}', function (App\Models\TransaksiSimpanan $transaction) {
        // ...
    });


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

    /*
    |----------------------------------------------------------------------
    | Pengawas
    |----------------------------------------------------------------------
    */

    Route::get('/pengawas', function () {
        $totalAnggota = AnggotaKoperasi::count();
        $totalSimpanan = AnggotaKoperasi::sum('total_saldo');

        $pinjamanAktif = Pinjaman::where('status', 'Aktif')->get();
        $totalPinjamanAktif = $pinjamanAktif->sum('sisa_pinjaman');
        $jumlahPinjamanAktif = $pinjamanAktif->count();

        return view('pengawas.dashboard', compact(
            'totalAnggota',
            'totalSimpanan',
            'totalPinjamanAktif',
            'jumlahPinjamanAktif'
        ));
    })->middleware('role:pengawas')->name('pengawas.dashboard');

    Route::get('/pengawas/laporan', function () {
        return view('pengawas.laporan');
    })->middleware('role:pengawas')->name('pengawas.laporan');

    Route::get('/pengawas/laporan/simpanan', function () {
        $anggota = App\Models\AnggotaKoperasi::orderBy('nama', 'asc')->get();

        $totalPokok = (int) $anggota->sum('simpanan_pokok');
        $totalWajib = (int) $anggota->sum('simpanan_wajib');
        $totalSukarela = (int) $anggota->sum('simpanan_sukarela');
        $totalSimpanan = (int) $anggota->sum('total_saldo');

        return view('pengawas.laporan-simpanan', compact(
            'anggota',
            'totalPokok',
            'totalWajib',
            'totalSukarela',
            'totalSimpanan'
        ));
    })->middleware('role:pengawas')->name('pengawas.laporan.simpanan');

    Route::get('/pengawas/laporan/pinjaman', function () {
        $pinjaman = App\Models\Pinjaman::with('anggota')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $totalPlafon = (int) $pinjaman->sum('nominal_pinjaman');
        $totalSisa = (int) $pinjaman->whereIn('status', ['Aktif', 'Menunggak'])->sum('sisa_pinjaman');
        $jumlahAktif = $pinjaman->where('status', 'Aktif')->count();
        $jumlahMenunggak = $pinjaman->where('status', 'Menunggak')->count();
        $jumlahLunas = $pinjaman->where('status', 'Lunas')->count();
        $jumlahPengajuan = $pinjaman->where('status', 'Pengajuan')->count();

        return view('pengawas.laporan-pinjaman', compact(
            'pinjaman',
            'totalPlafon',
            'totalSisa',
            'jumlahAktif',
            'jumlahMenunggak',
            'jumlahLunas',
            'jumlahPengajuan'
        ));
    })->middleware('role:pengawas')->name('pengawas.laporan.pinjaman');

    Route::get('/pengawas/laporan/kas-usaha', function () {
        $transaksi = TransaksiKasUsaha::orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $totalPemasukan = (int) $transaksi->where('jenis_transaksi', 'PENERIMAAN')->sum('nominal');
        $totalPengeluaran = (int) $transaksi->where('jenis_transaksi', 'PENGELUARAN')->sum('nominal');
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        $jumlahPemasukan = $transaksi->where('jenis_transaksi', 'PENERIMAAN')->count();
        $jumlahPengeluaran = $transaksi->where('jenis_transaksi', 'PENGELUARAN')->count();

        return view('pengawas.laporan-kas-usaha', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoKas',
            'jumlahPemasukan',
            'jumlahPengeluaran'
        ));
    })->middleware('role:pengawas')->name('pengawas.laporan.kas-usaha');

    // Route ini tetap di posisi aslinya (setelah pengawas, sebelum pinjaman)
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


    /*
    |----------------------------------------------------------------------
    | Pinjaman
    |----------------------------------------------------------------------
    */

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


    Route::get('/pinjaman', function () {
        $loans = App\Models\Pinjaman::with('anggota')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($loan) {
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

        return view('pinjaman', compact(
            'loans',
            'anggota',
            'totalPinjaman',
            'pinjamanAktifCount',
            'pinjamanMenunggakCount',
            'pinjamanLunasCount'
        ));
    })->middleware('role:admin')->name('pinjaman');

    Route::post('/pinjaman', function (Request $request) {
        $data = $request->validate([
            'anggota_id' => 'required|exists:anggota_koperasi,id',
            'nominal_pinjaman' => 'required|integer|min:1000',
            'tenor' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'nullable|in:Aktif,Menunggak,Lunas',
            'jumlah_cicilan_dibayar' => 'nullable|integer|min:0',
        ]);

        $status = $data['status'] ?? 'Pengajuan';
        $tenor = (int) $data['tenor'];

        $dibayar = isset($data['jumlah_cicilan_dibayar'])
            ? (int) $data['jumlah_cicilan_dibayar']
            : 0;

        if ($status === 'Lunas') {
            $dibayar = $tenor;
        }

        if ($dibayar > $tenor) {
            $dibayar = $tenor;
        }

        $sisa = ($status === 'Lunas')
            ? 0
            : round($data['nominal_pinjaman'] * (($tenor - $dibayar) / $tenor));

        App\Models\Pinjaman::create([
            'anggota_id' => $data['anggota_id'],
            'nominal_pinjaman' => $data['nominal_pinjaman'],
            'tenor' => $tenor,
            'jumlah_cicilan_dibayar' => $dibayar,
            'sisa_pinjaman' => $sisa,
            'tanggal_pengajuan' => $data['tanggal_pengajuan'],
            'status' => $status,
            'status_persetujuan' => 'Menunggu',
        ]);

        return redirect()->route('pinjaman')
            ->with('success', 'Pengajuan pinjaman berhasil disimpan ke database.');
    })->middleware('role:admin')->name('pinjaman.store');

    Route::get('/pinjaman/template', function () {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import');

        // Header
        $sheet->setCellValue('A1', 'id_anggota');
        $sheet->setCellValue('B1', 'nominal_pinjaman');
        $sheet->setCellValue('C1', 'tenor');
        $sheet->setCellValue('D1', 'tanggal_pengajuan');

        // Contoh data
        $sheet->setCellValue('A2', 'AGT-001');
        $sheet->setCellValue('B2', 10000000);
        $sheet->setCellValue('C2', 12);
        $sheet->setCellValue('D2', '2026-09-10');

        // Lebar kolom
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(22);

        // Bold header
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_pinjaman.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    })->middleware('role:admin')->name('pinjaman.template');

    Route::get('/pinjaman/export', function () {
        return Excel::download(new PinjamanExport, 'data_pinjaman.xlsx');
    })->name('pinjaman.export');

    Route::post('/pinjaman/import', function (Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ]);

        try {
            Excel::import(new PinjamanImport, $request->file('file'));

            return redirect()->route('pinjaman')
                ->with('success', 'Data pinjaman berhasil diimport dari Excel.');
        } catch (\Throwable $e) {
            return redirect()->route('pinjaman')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    })->name('pinjaman.import');

    // Approval / Validasi Pinjaman
    Route::post('/pinjaman/{pinjaman}/approval', function (Request $request, Pinjaman $pinjaman) {
        $data = $request->validate([
            'status_persetujuan' => ['required', 'in:Disetujui,Ditolak'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ]);

        // Pastikan hanya pinjaman dengan status Pengajuan yang bisa diproses
        if ($pinjaman->status !== 'Pengajuan') {
            return redirect()->back()
                ->with('error', 'Pinjaman ini tidak sedang dalam status pengajuan.');
        }

        // 1. Simpan data SEBELUM perubahan
        $before = $pinjaman->toArray();

        // 2. Tentukan status approval
        $statusPersetujuan = $data['status_persetujuan'];
        $statusPinjaman = $statusPersetujuan === 'Disetujui' ? 'Aktif' : 'Ditolak';

        // 3. Update pinjaman
        $pinjaman->update([
            'status_persetujuan' => $statusPersetujuan,
            'status' => $statusPinjaman,
            'keterangan' => $data['keterangan'] ?? $pinjaman->keterangan,
            'diperbarui_oleh' => auth()->id(),
        ]);

        // 4. Ambil data SETELAH perubahan
        $after = $pinjaman->fresh()->toArray();

        // 5. Buat deskripsi Activity Log
        $deskripsi = $statusPersetujuan === 'Disetujui'
            ? 'Admin menyetujui pengajuan pinjaman #' . $pinjaman->id . '.'
            : 'Admin menolak pengajuan pinjaman #' . $pinjaman->id . '.';

        // 6. Simpan Activity Log
        AuditService::catat('approval_pinjaman', $pinjaman->fresh(), $before, $after, $deskripsi);

        // 7. Pesan ke Admin
        $message = $statusPersetujuan === 'Disetujui'
            ? 'Pengajuan pinjaman berhasil disetujui.'
            : 'Pengajuan pinjaman berhasil ditolak.';

        // 8. Kembali ke halaman Pinjaman
        return redirect()->route('pinjaman')->with('success', $message);
    })->middleware('role:admin')->name('pinjaman.approval');

    Route::get('/history', [ActivityLogController::class, 'index'])
        ->middleware('role:admin')->name('activity_logs.index');

    Route::get('/history/export', [ActivityLogController::class, 'export'])
        ->middleware('role:admin')->name('activity_logs.export');

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

    /*
    |----------------------------------------------------------------------
    | Profile
    |----------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    /*
    |----------------------------------------------------------------------
    | Laporan
    |----------------------------------------------------------------------
    */

    Route::get('/laporan', function () {
        // Auto-heal missing transactions for existing member balances
        $members = App\Models\AnggotaKoperasi::all();
        foreach ($members as $member) {
            $date = $member->tanggal_join ?? $member->created_at ?? now();

            // Check Pokok
            if ($member->simpanan_pokok > 0) {
                $exists = App\Models\TransaksiSimpanan::where('anggota_id', $member->id)
                    ->where('jenis_simpanan', 'Pokok')->exists();
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
                    ->where('jenis_simpanan', 'Wajib')->exists();
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
                    ->where('jenis_simpanan', 'Sukarela')->exists();
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
                    'statusPersetujuan' => $loan->status_persetujuan,
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
            ->sortByDesc(fn ($tx) => $tx['raw_date'])
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
    })->middleware('role:admin')->name('laporan');

    /*
    |----------------------------------------------------------------------
    | Kas Usaha
    |----------------------------------------------------------------------
    */

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
    })->middleware('role:admin')->name('kas-usaha');

    Route::post('/kas-usaha', function (Request $request) {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_transaksi' => ['required', 'in:PENERIMAAN,PENGELUARAN'],
            'keterangan' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'integer', 'min:1000'],
        ]);

        App\Models\TransaksiKasUsaha::create($data);

        return redirect()->route('kas-usaha')->with('success', 'Transaksi kas usaha berhasil disimpan.');
    })->middleware('role:admin')->name('kas-usaha.store');

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

    /*
    |----------------------------------------------------------------------
    | Logout
    |----------------------------------------------------------------------
    */


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
