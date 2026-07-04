<?php

namespace Database\Seeders;

use App\Models\AnggotaKoperasi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dataAnggota = [
            ['nama' => 'Heni Lusiani', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Ayu Mentari Savitri, SH', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 16500000, 'total_saldo' => 20700000],
            ['nama' => 'Reni Kusumawati, SE', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 16500000, 'total_saldo' => 20700000],
            ['nama' => 'Juniarti Eka Putri', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Saiful Bahri', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Saidah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Yunistiasih', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Dina Arhatini', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Nurul Hikmah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Adi Suryawan', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Sri Istiarini', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Rizky Siswaji Effendi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000],
            ['nama' => 'Aya Shofiyyah, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000],
            ['nama' => 'Candra Wahyudi, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000],
            ['nama' => 'Diah Wahyuni Nuraini, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000],
            ['nama' => 'Sriwidayanto Kaderi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 7500000, 'total_saldo' => 9600000],
            ['nama' => 'Donni Efison, SE, MM', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 10000000, 'total_saldo' => 13900000],
            ['nama' => 'Sugeng Suryanto', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 17000000, 'total_saldo' => 20900000],
        ];

        foreach ($dataAnggota as $index => $anggota) {
            AnggotaKoperasi::updateOrCreate(
                ['id_anggota' => 'AGT-' . str_pad((string) (12089 + $index), 5, '0', STR_PAD_LEFT)],
                array_merge($anggota, [
                    'no_hp' => '+62 8' . str_pad((string) ($index + 1), 10, '0', STR_PAD_LEFT),
                    'tanggal_join' => now()->subDays($index)->toDateString(),
                ])
            );
        }
    }
}
