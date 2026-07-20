<?php

use App\Models\AnggotaKoperasi;
use App\Models\Pinjaman;
use App\Models\TransaksiSimpanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tables with foreign key constraints disabled
        Schema::disableForeignKeyConstraints();
        DB::table('transaksi_simpanan')->truncate();
        DB::table('pinjaman')->truncate();
        DB::table('anggota_koperasi')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed exactly 10 members (AGT-001 to AGT-010)
        $dataAnggota = [
            ['nama' => 'Heni Lusiani', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Ayu Mentari Savitri, SH', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 20575000, 'total_saldo' => 20700000],
            ['nama' => 'Reni Kusumawati, SE', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 20575000, 'total_saldo' => 20700000],
            ['nama' => 'Juniarti Eka Putri', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Saiful Bahri', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Saidah', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Yunistiasih', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Dina Arhatini', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Nurul Hikmah', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
            ['nama' => 'Adi Suryawan', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 4075000, 'total_saldo' => 4200000],
        ];

        $anggotaList = [];
        foreach ($dataAnggota as $index => $item) {
            $anggotaList[] = AnggotaKoperasi::create([
                'id_anggota' => 'AGT-' . str_pad((string) (1 + $index), 3, '0', STR_PAD_LEFT),
                'nama' => $item['nama'],
                'no_hp' => '+62 8' . str_pad((string) ($index + 1), 10, '0', STR_PAD_LEFT),
                'tanggal_join' => now()->subMonths(12 - $index)->toDateString(),
                'simpanan_pokok' => $item['simpanan_pokok'],
                'simpanan_wajib' => $item['simpanan_wajib'],
                'simpanan_sukarela' => $item['simpanan_sukarela'],
                'total_saldo' => $item['total_saldo'],
            ]);
        }

        // 2. Seed transactions for these 10 members
        foreach ($anggotaList as $anggota) {
            if ($anggota->simpanan_pokok > 0) {
                TransaksiSimpanan::create([
                    'anggota_id' => $anggota->id,
                    'jenis_simpanan' => 'Pokok',
                    'nominal' => $anggota->simpanan_pokok,
                    'status' => 'Lunas',
                    'tanggal_transaksi' => $anggota->tanggal_join,
                ]);
            }
            if ($anggota->simpanan_wajib > 0) {
                TransaksiSimpanan::create([
                    'anggota_id' => $anggota->id,
                    'jenis_simpanan' => 'Wajib',
                    'nominal' => $anggota->simpanan_wajib,
                    'status' => 'Lunas',
                    'tanggal_transaksi' => $anggota->tanggal_join,
                ]);
            }
            if ($anggota->simpanan_sukarela > 0) {
                TransaksiSimpanan::create([
                    'anggota_id' => $anggota->id,
                    'jenis_simpanan' => 'Sukarela',
                    'nominal' => $anggota->simpanan_sukarela,
                    'status' => 'Lunas',
                    'tanggal_transaksi' => $anggota->tanggal_join,
                ]);
            }
        }

        // 3. Seed exactly 20 loans distributed among these 10 members
        $loansData = [
            // Member 1
            ['member_idx' => 0, 'nominal' => 15000000, 'tenor' => 12, 'dibayar' => 6, 'status' => 'Aktif'],
            ['member_idx' => 0, 'nominal' => 10000000, 'tenor' => 10, 'dibayar' => 10, 'status' => 'Lunas'],
            
            // Member 2
            ['member_idx' => 1, 'nominal' => 20000000, 'tenor' => 12, 'dibayar' => 3, 'status' => 'Aktif'],
            ['member_idx' => 1, 'nominal' => 5000000, 'tenor' => 6, 'dibayar' => 6, 'status' => 'Lunas'],

            // Member 3
            ['member_idx' => 2, 'nominal' => 30000000, 'tenor' => 24, 'dibayar' => 12, 'status' => 'Aktif'],
            ['member_idx' => 2, 'nominal' => 12000000, 'tenor' => 12, 'dibayar' => 12, 'status' => 'Lunas'],

            // Member 4
            ['member_idx' => 3, 'nominal' => 15000000, 'tenor' => 12, 'dibayar' => 8, 'status' => 'Aktif'],
            ['member_idx' => 3, 'nominal' => 10000000, 'tenor' => 10, 'dibayar' => 10, 'status' => 'Lunas'],

            // Member 5
            ['member_idx' => 4, 'nominal' => 25000000, 'tenor' => 12, 'dibayar' => 5, 'status' => 'Aktif'],
            ['member_idx' => 4, 'nominal' => 8000000, 'tenor' => 8, 'dibayar' => 8, 'status' => 'Lunas'],

            // Member 6
            ['member_idx' => 5, 'nominal' => 12000000, 'tenor' => 12, 'dibayar' => 4, 'status' => 'Aktif'],
            ['member_idx' => 5, 'nominal' => 6000000, 'tenor' => 6, 'dibayar' => 6, 'status' => 'Lunas'],

            // Member 7
            ['member_idx' => 6, 'nominal' => 18000000, 'tenor' => 12, 'dibayar' => 7, 'status' => 'Aktif'],
            ['member_idx' => 6, 'nominal' => 10000000, 'tenor' => 10, 'dibayar' => 10, 'status' => 'Lunas'],

            // Member 8
            ['member_idx' => 7, 'nominal' => 15000000, 'tenor' => 12, 'dibayar' => 6, 'status' => 'Aktif'],
            ['member_idx' => 7, 'nominal' => 10000000, 'tenor' => 12, 'dibayar' => 12, 'status' => 'Lunas'],

            // Member 9
            ['member_idx' => 8, 'nominal' => 20000000, 'tenor' => 12, 'dibayar' => 2, 'status' => 'Menunggak'],
            ['member_idx' => 8, 'nominal' => 10000000, 'tenor' => 10, 'dibayar' => 10, 'status' => 'Lunas'],

            // Member 10
            ['member_idx' => 9, 'nominal' => 15000000, 'tenor' => 12, 'dibayar' => 1, 'status' => 'Menunggak'],
            ['member_idx' => 9, 'nominal' => 5000000, 'tenor' => 6, 'dibayar' => 6, 'status' => 'Lunas'],
        ];

        foreach ($loansData as $index => $item) {
            $anggota = $anggotaList[$item['member_idx']];
            $nominal = $item['nominal'];
            $sisa = $item['status'] === 'Lunas' ? 0 : round($nominal * (($item['tenor'] - $item['dibayar']) / $item['tenor']));

            Pinjaman::create([
                'anggota_id' => $anggota->id,
                'nominal_pinjaman' => $nominal,
                'tenor' => $item['tenor'],
                'jumlah_cicilan_dibayar' => $item['dibayar'],
                'sisa_pinjaman' => $sisa,
                'tanggal_pengajuan' => now()->subMonths(random_int(1, 12))->subDays(random_int(1, 28))->toDateString(),
                'status' => $item['status'],
            ]);
        }
    }
}
