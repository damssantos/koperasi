<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Services\AuditService;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PinjamanController extends Controller
{
    /**
     * Menampilkan daftar pinjaman.
     */
    public function index(Request $request)
    {
        $query = Pinjaman::with([
            'anggota:id,id_anggota,nama'
        ])
        ->latest('tanggal_pengajuan')
        ->latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
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
     * Membuat pengajuan pinjaman baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggota_koperasi,id'
            ],

            'nominal_pinjaman' => [
                'required',
                'integer',
                'min:1000'
            ],

            'tenor' => [
                'required',
                'integer',
                'min:1',
                'max:360'
            ],

            'tanggal_pengajuan' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ]);

        $pinjaman = Pinjaman::create([
    'anggota_id' => $data['anggota_id'],
    'nominal_pinjaman' => $data['nominal_pinjaman'],
    'tenor' => $data['tenor'],
    'jumlah_cicilan_dibayar' => 0,
    'sisa_pinjaman' => $data['nominal_pinjaman'],
    'tanggal_pengajuan' => $data['tanggal_pengajuan'],
    'status' => 'Pengajuan',
    'status_persetujuan' => 'Menunggu',
    'keterangan' => $data['keterangan'] ?? null,
]);

        AuditService::catat(
            'buat_pengajuan_pinjaman',
            $pinjaman,
            null,
            $pinjaman->toArray()
        );

        return response()->json([
            'message' => 'Pengajuan pinjaman berhasil dibuat.',
            'data' => $pinjaman->fresh('anggota'),
        ], 201);
    }


    /**
     * Mengubah data/status pinjaman.
     */
    public function update(Request $request, Pinjaman $pinjaman)
    {
        $data = $request->validate([
            'nominal_pinjaman' => [
                'required',
                'integer',
                'min:1000'
            ],

            'tenor' => [
                'required',
                'integer',
                'min:1',
                'max:360'
            ],

            'tanggal_pengajuan' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'status' => [
                'required',
                'in:Pengajuan,Disetujui,Ditolak,Aktif,Menunggak,Lunas,Dibatalkan'
            ],
        ]);

        /**
         * Pinjaman yang sudah dicicil
         * tidak boleh mengubah nominal / tenor.
         */
        if (
            $pinjaman->jumlah_cicilan_dibayar > 0 &&
            (
                $data['nominal_pinjaman'] != $pinjaman->nominal_pinjaman ||
                $data['tenor'] != $pinjaman->tenor
            )
        ) {
            return response()->json([
                'message' => 'Pinjaman yang telah dicicil tidak dapat diubah nominal atau tenor.'
            ], 422);
        }

        $before = $pinjaman->toArray();

        DB::transaction(function () use ($pinjaman, $data) {

            $oldStatus = $pinjaman->status;
            $newStatus = $data['status'];

            $updateData = [
                'nominal_pinjaman' => $data['nominal_pinjaman'],
                'tenor' => $data['tenor'],
                'tanggal_pengajuan' => $data['tanggal_pengajuan'],
                'keterangan' => $data['keterangan'] ?? null,
                'status' => $newStatus,
            ];

            /**
             * Jika disetujui menjadi Aktif,
             * pastikan sisa pinjaman sesuai nominal.
             */
            if (
                $newStatus === 'Aktif' &&
                $oldStatus !== 'Aktif'
            ) {
                $updateData['sisa_pinjaman'] =
                    $data['nominal_pinjaman'];
            }

            $pinjaman->update($updateData);

            /**
             * Catat pencairan hanya ketika
             * status berubah menjadi Aktif.
             */
            if (
                $newStatus === 'Aktif' &&
                $oldStatus !== 'Aktif'
            ) {
                LedgerService::catat(
                    $pinjaman,
                    'PENCAIRAN_PINJAMAN',
                    'KELUAR',
                    $pinjaman->nominal_pinjaman,
                    $pinjaman->anggota_id,
                    'PJC-' . str_pad(
                        (string) $pinjaman->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    ),
                    $pinjaman->keterangan
                );
            }
        });

        AuditService::catat(
            'ubah_pinjaman',
            $pinjaman,
            $before,
            $pinjaman->fresh()->toArray()
        );

        return response()->json([
            'data' => $pinjaman->fresh('anggota')
        ]);
    }

/**
 * Menyetujui atau menolak pengajuan pinjaman.
 */
public function approval(Request $request, Pinjaman $pinjaman)
{
    $data = $request->validate([
        'status_persetujuan' => [
            'required',
            'in:Disetujui,Ditolak',
        ],
        'keterangan' => [
            'nullable',
            'string',
            'max:1000',
        ],
    ]);

    // Approval hanya boleh dilakukan pada pinjaman yang masih diajukan
    if ($pinjaman->status !== 'Pengajuan') {
        return response()->json([
            'message' => 'Pinjaman ini tidak sedang dalam status pengajuan.',
        ], 422);
    }

    $before = $pinjaman->toArray();

    DB::transaction(function () use ($pinjaman, $data) {

        $pinjaman->update([
            'status_persetujuan' => $data['status_persetujuan'],
            'keterangan' => $data['keterangan'] ?? $pinjaman->keterangan,
            'diperbarui_oleh' => auth()->id(),
        ]);

    });

    AuditService::catat(
        'approval_pinjaman',
        $pinjaman,
        $before,
        $pinjaman->fresh()->toArray()
    );

    return response()->json([
        'message' => $data['status_persetujuan'] === 'Disetujui'
            ? 'Pengajuan pinjaman berhasil disetujui.'
            : 'Pengajuan pinjaman berhasil ditolak.',
        'data' => $pinjaman->fresh('anggota'),
    ]);
}
    /**
     * Upload bukti transfer / pencairan.
     */
    public function uploadBuktiTransfer(
        Request $request,
        Pinjaman $pinjaman
    ) {
        $request->validate([
            'bukti_transfer' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ], [
            'bukti_transfer.required' =>
                'Bukti transfer wajib diunggah.',

            'bukti_transfer.image' =>
                'File harus berupa gambar.',

            'bukti_transfer.mimes' =>
                'Bukti transfer harus berupa JPG, JPEG, atau PNG.',

            'bukti_transfer.max' =>
                'Ukuran bukti transfer maksimal 2MB.',
        ]);

        /**
         * Hapus bukti lama jika ada.
         */
        if ($pinjaman->bukti_transfer) {
            Storage::disk('public')
                ->delete($pinjaman->bukti_transfer);
        }

        /**
         * Simpan bukti baru.
         */
        $path = $request
            ->file('bukti_transfer')
            ->store('bukti-transfer', 'public');

        $pinjaman->update([
            'bukti_transfer' => $path,
        ]);

        return response()->json([
            'message' => 'Bukti transfer berhasil diunggah.',
            'data' => $pinjaman->fresh('anggota'),
        ]);
    }


    /**
     * Membatalkan pinjaman.
     */
    public function batalkan(
        Request $request,
        Pinjaman $pinjaman
    ) {
        $data = $request->validate([
            'alasan_pembatalan' => [
                'required',
                'string',
                'max:1000'
            ]
        ]);

        if ($pinjaman->jumlah_cicilan_dibayar > 0) {
            return response()->json([
                'message' =>
                    'Pinjaman yang telah memiliki pembayaran tidak dapat dibatalkan.'
            ], 422);
        }

        $before = $pinjaman->toArray();

        $pinjaman->update([
            'status' => 'Dibatalkan',
            'dibatalkan_pada' => now(),
            'alasan_pembatalan' =>
                $data['alasan_pembatalan'],
        ]);

        AuditService::catat(
            'batalkan_pinjaman',
            $pinjaman,
            $before,
            $pinjaman->fresh()->toArray()
        );

        return response()->json([
            'data' => $pinjaman->fresh()
        ]);
    }
}