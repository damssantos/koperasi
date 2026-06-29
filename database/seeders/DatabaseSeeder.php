<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Seeder;
use App\Models\AnggotaKoperasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dataAnggota = [
            ['nama' => 'Heni Lusiani ', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Ayu Mentari Savitri, SH', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 16500000, 'total_saldo' => 20700000], 
            ['nama' => 'Reni Kusumawati, SE ', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 16500000, 'total_saldo' => 20700000], 
            ['nama' => 'Juniarti Eka Putri', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Saiful Bahri', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Saidah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Yunistiasih', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Dina Arhatini', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Afriyanita Rahim ', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Nurul Hikmah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Irti Nova Andraini. S.Pd', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Adi Suryawan', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Sri Istiarini', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Adi Sumarya', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Sanudin', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Rizky Siswaji Effendi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Sopandi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Zaenal Muttaqin', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Tika Pransiska,S.Pdi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Itsna Hartinah Rismaliyah ', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Nurlaila Hafiz ', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Raudhatun Nisa, S.Pd', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Fikri Tamami', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Dodi Lesmana', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Ruhiyat Z. Arifin', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Aslim', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4200000], 
            ['nama' => 'Masuti', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2950000], 
            ['nama' => 'Junaedi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2950000], 
            ['nama' => 'Sukandar', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2800000], 
            ['nama' => 'Fadilah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 2500000, 'total_saldo' => 5300000], 
            ['nama' => 'Aya Shofiyyah, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Candra Wahyudi, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Rizqo Utami, S.A.P', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Makrojah, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Hildan Amien', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Fitri', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Monica Gita Kusuma', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Qurratuaini Zhafirah', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Diah Wahyuni Nuraini, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Juju', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
            ['nama' => 'Alya Putri Havi', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 1750000], 
            ['nama' => 'Nurhamid ', 'simpanan_pokok' => 0 , 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 3875000], 
            ['nama' => 'Putri Inta Nabila, S.Si', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 125000], 
            ['nama' => 'Annisa Fitriani, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 125000], 
            ['nama' => 'Silvie Lestari Nurrahmat', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 125000], 
            ['nama' => 'Siti Nur Maulida, S.Pd', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 125000], 
            ['nama' => 'Wulan Sari Widyaningsih, S.Ag', 'simpanan_pokok' => 25000, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 125000], 
            ['nama' => 'Teguh Supriyadi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 4050000], 
            ['nama' => 'Maftuhatul Fahmiah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 3650000], 
            ['nama' => 'Fakhri Amrullah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 3450000], 
            ['nama' => 'Dian Anisa Fitri', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 1800000], 
            ['nama' => 'Prapti Wahyuni', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2100000], 
            ['nama' => 'Sriwidayanto Kaderi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 7500000, 'total_saldo' => 9600000], 
            ['nama' => 'Donni Efison, SE, MM', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 10000000, 'total_saldo' => 13900000], 
            ['nama' => 'Hernawi Fernando', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 5000000, 'total_saldo' => 8900000], 
            ['nama' => 'Sugeng Suryanto', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 17000000, 'total_saldo' => 20900000], 
            ['nama' => 'Achmad Suherman', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 3400000], 
            ['nama' => 'Moh. Hasyim', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2400000], 
            ['nama' => 'Effendi Abdillah', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2400000], 
            ['nama' => 'Rama Boedi', 'simpanan_pokok' => 0, 'simpanan_wajib' => 100000, 'simpanan_sukarela' => 0, 'total_saldo' => 2050000], 
        ];

        foreach ($dataAnggota as $anggota) {
            AnggotaKoperasi::create($anggota);
        }
    }
}
=======
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
>>>>>>> 815acd4e58dc0726bbd942149a6f6151b715c1f6
