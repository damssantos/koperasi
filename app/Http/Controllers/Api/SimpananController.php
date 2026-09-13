<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKoperasi;
use App\Models\TransaksiSimpanan;
use App\Services\AuditService;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    /**
     * Menampilkan daftar transaksi simpanan.
     */
    public function index(Request $request)
    {
        $query = TransaksiSimpanan::with(
            'anggota:id,id_anggota,nama'
        )
            ->latest('tanggal_transaksi')
            ->latest('id');

        foreach (['anggota_id', 'jenis_simpanan', 'arah'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->$field);
            }
        }

        if ($request->filled('dari')) {
            $query->whereDate(
                'tanggal_transaksi',
                '>=',
                $request->dari
            );
        }

        if ($request->filled('sampai')) {
            $query->whereDate(
                'tanggal_transaksi',
                '<=',
                $request->sampai
            );
        }

        return response()->json([
            'data' => $query->paginate(
                min(
                    (int) $request->input('per_page', 20),
                    100
                )
            )
        ]);
    }

    /**
     * Statistik transaksi simpanan.
     *
     * Periode yang tersedia:
     * - harian
     * - mingguan
     * - bulanan
     * - triwulan
     * - tahunan
     */
    public function statistik(Request $request)
    {
        $periode = $request->input('periode', 'bulanan');

        $periodeValid = [
            'harian',
            'mingguan',
            'bulanan',
            'triwulan',
            'tahunan',
        ];

        if (!in_array($periode, $periodeValid)) {
            return response()->json([
                'message' => 'Periode tidak valid.',
                'periode_valid' => $periodeValid,
            ], 422);
        }

        $query = TransaksiSimpanan::query();

        /*
        |--------------------------------------------------------------------------
        | Filter Jenis Simpanan
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jenis_simpanan')) {
            $query->where(
                'jenis_simpanan',
                $request->jenis_simpanan
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Arah Transaksi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('arah')) {
            $query->where(
                'arah',
                $request->arah
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal
        |--------------------------------------------------------------------------
        */

        if ($request->filled('dari')) {
            $query->whereDate(
                'tanggal_transaksi',
                '>=',
                $request->dari
            );
        }

        if ($request->filled('sampai')) {
            $query->whereDate(
                'tanggal_transaksi',
                '<=',
                $request->sampai
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pengelompokan Statistik
        |--------------------------------------------------------------------------
        */

        switch ($periode) {

            /*
            |--------------------------------------------------------------------------
            | HARIAN
            |--------------------------------------------------------------------------
            */

            case 'harian':

                $data = $query
                    ->selectRaw("
                        DATE(tanggal_transaksi) AS periode,

                        SUM(
                            CASE
                                WHEN arah = 'MASUK' THEN nominal
                                WHEN arah = 'KELUAR' THEN -nominal
                                ELSE 0
                            END
                        ) AS total
                    ")
                    ->groupByRaw(
                        'DATE(tanggal_transaksi)'
                    )
                    ->orderByRaw(
                        'DATE(tanggal_transaksi)'
                    )
                    ->get();

                break;


            /*
            |--------------------------------------------------------------------------
            | MINGGUAN
            |--------------------------------------------------------------------------
            */

            case 'mingguan':

                $data = $query
                    ->selectRaw("
                        YEAR(tanggal_transaksi) AS tahun,

                        WEEK(
                            tanggal_transaksi,
                            1
                        ) AS minggu,

                        SUM(
                            CASE
                                WHEN arah = 'MASUK' THEN nominal
                                WHEN arah = 'KELUAR' THEN -nominal
                                ELSE 0
                            END
                        ) AS total
                    ")
                    ->groupByRaw("
                        YEAR(tanggal_transaksi),
                        WEEK(tanggal_transaksi, 1)
                    ")
                    ->orderByRaw("
                        tahun,
                        minggu
                    ")
                    ->get();

                break;


            /*
            |--------------------------------------------------------------------------
            | BULANAN
            |--------------------------------------------------------------------------
            */

            case 'bulanan':

                $data = $query
                    ->selectRaw("
                        YEAR(tanggal_transaksi) AS tahun,

                        MONTH(tanggal_transaksi) AS bulan,

                        SUM(
                            CASE
                                WHEN arah = 'MASUK' THEN nominal
                                WHEN arah = 'KELUAR' THEN -nominal
                                ELSE 0
                            END
                        ) AS total
                    ")
                    ->groupByRaw("
                        YEAR(tanggal_transaksi),
                        MONTH(tanggal_transaksi)
                    ")
                    ->orderByRaw("
                        tahun,
                        bulan
                    ")
                    ->get();

                break;


            /*
            |--------------------------------------------------------------------------
            | TRIWULAN
            |--------------------------------------------------------------------------
            */

            case 'triwulan':

                $data = $query
                    ->selectRaw("
                        YEAR(tanggal_transaksi) AS tahun,

                        QUARTER(tanggal_transaksi) AS triwulan,

                        SUM(
                            CASE
                                WHEN arah = 'MASUK' THEN nominal
                                WHEN arah = 'KELUAR' THEN -nominal
                                ELSE 0
                            END
                        ) AS total
                    ")
                    ->groupByRaw("
                        YEAR(tanggal_transaksi),
                        QUARTER(tanggal_transaksi)
                    ")
                    ->orderByRaw("
                        tahun,
                        triwulan
                    ")
                    ->get();

                break;


            /*
            |--------------------------------------------------------------------------
            | TAHUNAN
            |--------------------------------------------------------------------------
            */

            case 'tahunan':

                $data = $query
                    ->selectRaw("
                        YEAR(tanggal_transaksi) AS tahun,

                        SUM(
                            CASE
                                WHEN arah = 'MASUK' THEN nominal
                                WHEN arah = 'KELUAR' THEN -nominal
                                ELSE 0
                            END
                        ) AS total
                    ")
                    ->groupByRaw("
                        YEAR(tanggal_transaksi)
                    ")
                    ->orderBy('tahun')
                    ->get();

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'periode' => $periode,
            'data' => $data,
        ]);
    }

    /**
     * Menyimpan transaksi setoran simpanan.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggota_koperasi,id'
            ],

            'jenis_simpanan' => [
                'required',
                'in:Pokok,Wajib,Sukarela'
            ],

            'nominal' => [
                'required',
                'integer',
                'min:1000'
            ],

            'tanggal_transaksi' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ]);

        return response()->json([
            'data' => $this->simpan(
                $data,
                'MASUK'
            )
        ], 201);
    }
/**
 * Customer melakukan setoran simpanan.
 */
public function customerStore(Request $request)
{
    // Ambil anggota berdasarkan akun Customer yang sedang login
    $anggota = auth()->user()->anggota;

    if (!$anggota) {
        return redirect()
            ->back()
            ->with('error', 'Data anggota belum terhubung dengan akun Anda.');
    }

    // Validasi data dari Customer
    $data = $request->validate([
        'jenis_simpanan' => [
            'required',
            'in:Pokok,Wajib,Sukarela'
        ],

        'nominal' => [
            'required',
            'integer',
            'min:1000'
        ],

        'tanggal_transaksi' => [
            'required',
            'date'
        ],

        'keterangan' => [
            'nullable',
            'string',
            'max:1000'
        ],
    ], [
        'jenis_simpanan.required' => 'Jenis simpanan wajib dipilih.',
        'jenis_simpanan.in' => 'Jenis simpanan tidak valid.',

        'nominal.required' => 'Nominal simpanan wajib diisi.',
        'nominal.integer' => 'Nominal simpanan harus berupa angka.',
        'nominal.min' => 'Minimal simpanan adalah Rp1.000.',

        'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
        'tanggal_transaksi.date' => 'Tanggal transaksi tidak valid.',
    ]);

    // Customer tidak boleh menentukan anggota_id sendiri.
    // Sistem mengambil anggota_id dari akun yang sedang login.
    $data['anggota_id'] = $anggota->id;

    // Gunakan proses simpan yang sudah ada.
    // Proses ini akan:
    // - menambah saldo
    // - membuat transaksi
    // - membuat nomor bukti
    // - mencatat Ledger
    // - mencatat Activity Log
    $this->simpan(
        $data,
        'MASUK'
    );

    // Kembali ke halaman Simpanan Customer
    return redirect()
        ->route('customer.simpanan')
        ->with(
            'success',
            'Setoran simpanan berhasil dicatat.'
        );
}


    /**
     * Menarik simpanan anggota.
     */
    public function tarik(Request $request)
    {
        $data = $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggota_koperasi,id'
            ],

            'jenis_simpanan' => [
                'required',
                'in:Pokok,Wajib,Sukarela'
            ],

            'nominal' => [
                'required',
                'integer',
                'min:1000'
            ],

            'tanggal_transaksi' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'required',
                'string',
                'max:1000'
            ],
        ]);

        $member = AnggotaKoperasi::findOrFail(
            $data['anggota_id']
        );

        $field = 'simpanan_' . strtolower(
            $data['jenis_simpanan']
        );

        if ($member->$field < $data['nominal']) {
            return response()->json([
                'message' => 'Saldo simpanan tidak mencukupi.'
            ], 422);
        }

        return response()->json([
            'data' => $this->simpan(
                $data,
                'KELUAR'
            )
        ], 201);
    }

    /**
     * Proses utama penyimpanan transaksi.
     */
    private function simpan(
        array $data,
        string $arah
    ): TransaksiSimpanan {

        return DB::transaction(
            function () use ($data, $arah) {

                /*
                |--------------------------------------------------------------------------
                | Ambil anggota dengan lock
                |--------------------------------------------------------------------------
                */

                $member = AnggotaKoperasi::lockForUpdate()
                    ->findOrFail(
                        $data['anggota_id']
                    );

                /*
                |--------------------------------------------------------------------------
                | Tentukan field simpanan
                |--------------------------------------------------------------------------
                */

                $field = 'simpanan_' . strtolower(
                    $data['jenis_simpanan']
                );

                /*
                |--------------------------------------------------------------------------
                | Validasi saldo ketika penarikan
                |--------------------------------------------------------------------------
                */

                if (
                    $arah === 'KELUAR'
                    &&
                    $member->$field < $data['nominal']
                ) {
                    abort(
                        422,
                        'Saldo simpanan tidak mencukupi.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Update saldo simpanan
                |--------------------------------------------------------------------------
                */

                $member->$field +=
                    $arah === 'MASUK'
                        ? $data['nominal']
                        : -$data['nominal'];

                /*
                |--------------------------------------------------------------------------
                | Hitung total saldo
                |--------------------------------------------------------------------------
                */

                $member->total_saldo =
                    $member->simpanan_pokok
                    + $member->simpanan_wajib
                    + $member->simpanan_sukarela;

                $member->save();

                /*
                |--------------------------------------------------------------------------
                | Buat transaksi
                |--------------------------------------------------------------------------
                */

                $tx = TransaksiSimpanan::create(
                    $data + [
                        'arah' => $arah,
                        'status' => 'Aktif'
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | Buat nomor bukti transaksi
                |--------------------------------------------------------------------------
                */

                $bukti =
                    ($arah === 'MASUK' ? 'SMP' : 'TRK')
                    . '-'
                    . now()->format('Ymd')
                    . '-'
                    . str_pad(
                        (string) $tx->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    );

                /*
                |--------------------------------------------------------------------------
                | Catat ke Ledger
                |--------------------------------------------------------------------------
                */

                LedgerService::catat(
                    $tx,
                    $arah === 'MASUK'
                        ? 'SETORAN_SIMPANAN'
                        : 'PENARIKAN_SIMPANAN',
                    $arah,
                    $tx->nominal,
                    $tx->anggota_id,
                    $bukti,
                    $tx->keterangan
                );

                /*
                |--------------------------------------------------------------------------
                | Audit Log
                |--------------------------------------------------------------------------
                */

                AuditService::catat(
                    $arah === 'MASUK'
                        ? 'catat_setoran_simpanan'
                        : 'catat_penarikan_simpanan',
                    $tx,
                    null,
                    $tx->toArray()
                );

                /*
                |--------------------------------------------------------------------------
                | Return transaksi terbaru
                |--------------------------------------------------------------------------
                */

                return $tx->fresh('anggota');
            }
        );
    }
}