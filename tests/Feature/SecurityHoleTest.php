<?php

namespace Tests\Feature;

use App\Models\AnggotaKoperasi;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHoleTest extends TestCase
{
    use RefreshDatabase;

    private function customer(string $email = 'cust@test.local', string $nik = '1234567890123456'): User
    {
        $user = User::create([
            'nama_lengkap' => 'Cust Test',
            'nik' => $nik,
            'email' => $email,
            'alamat' => 'Jl. Test No. 1',
            'no_hp' => '081234567890',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'customer',
        ]);
        AnggotaKoperasi::create([
            'user_id' => $user->id,
            'id_anggota' => 'AGT-' . str_pad((string) $user->id, 3, '0', STR_PAD_LEFT),
            'nama' => 'Cust Test',
            'nik' => $user->nik,
            'no_hp' => $user->no_hp,
            'tanggal_join' => now()->toDateString(),
        ]);
        return $user;
    }

    private function admin(): User
    {
        return User::create([
            'nama_lengkap' => 'Admin Test',
            'nik' => '1234567890123457',
            'email' => 'admin@test.local',
            'alamat' => 'Jl. Test No. 2',
            'no_hp' => '081234567891',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function customer_cannot_import_anggota(): void
    {
        $this->actingAs($this->customer())
            ->post('/anggota/import')
            ->assertForbidden();
    }

    /** @test */
    public function customer_cannot_open_simpanan_print_and_pdf(): void
    {
        $this->actingAs($this->customer('cust2@test.local', '1234567890123458'))
            ->get('/simpanan/print')
            ->assertForbidden();

        $this->actingAs($this->customer('cust3@test.local', '1234567890123459'))
            ->get('/simpanan/download-pdf')
            ->assertForbidden();
    }

    /** @test */
    public function api_customer_token_cannot_update_other_members_loan(): void
    {
        $customer = $this->customer();
        $other = AnggotaKoperasi::create([
            'id_anggota' => 'AGT-901',
            'nama' => 'Orang Lain',
            'no_hp' => '081299999999',
            'tanggal_join' => now()->toDateString(),
        ]);
        $loan = Pinjaman::create([
            'anggota_id' => $other->id,
            'nominal_pinjaman' => 1000000,
            'tenor' => 12,
            'jumlah_cicilan_dibayar' => 0,
            'sisa_pinjaman' => 1000000,
            'tanggal_pengajuan' => now()->toDateString(),
            'status' => 'Aktif',
            'status_persetujuan' => 'Disetujui',
        ]);

        $token = $this->postJson('/api/v1/tokens', [
            'email' => $customer->email,
            'password' => 'password',
        ])->json('data.token');

        $this->withToken($token)
            ->putJson("/api/v1/pinjaman/{$loan->id}", [
                'nominal_pinjaman' => 500000,
                'tenor' => 6,
                'tanggal_pengajuan' => now()->toDateString(),
                'status' => 'Lunas',
            ])
            ->assertForbidden();

        $this->withToken($token)
            ->patchJson("/api/v1/pinjaman/{$loan->id}/batalkan", [
                'alasan_pembatalan' => 'hack',
            ])
            ->assertForbidden();
    }

    /** @test */
    public function api_customer_token_cannot_create_payment_for_other_loan(): void
    {
        $customer = $this->customer();
        $other = AnggotaKoperasi::create([
            'id_anggota' => 'AGT-902',
            'nama' => 'Orang Lain Dua',
            'no_hp' => '081288888888',
            'tanggal_join' => now()->toDateString(),
        ]);
        $loan = Pinjaman::create([
            'anggota_id' => $other->id,
            'nominal_pinjaman' => 1000000,
            'tenor' => 12,
            'jumlah_cicilan_dibayar' => 0,
            'sisa_pinjaman' => 1000000,
            'tanggal_pengajuan' => now()->toDateString(),
            'status' => 'Aktif',
            'status_persetujuan' => 'Disetujui',
        ]);

        $token = $this->postJson('/api/v1/tokens', [
            'email' => $customer->email,
            'password' => 'password',
        ])->json('data.token');

        $this->withToken($token)
            ->postJson("/api/v1/pinjaman/{$loan->id}/cicilan", [
                'tanggal_pembayaran' => now()->toDateString(),
                'nominal_pokok' => 100000,
                'metode_pembayaran' => 'Transfer',
            ])
            ->assertForbidden();

        $this->withToken($token)
            ->postJson("/api/v1/simpanan/penarikan", [
                'anggota_id' => $other->id,
                'jenis_simpanan' => 'Sukarela',
                'nominal' => 1000,
                'tanggal_transaksi' => now()->toDateString(),
                'keterangan' => 'hack',
            ])
            ->assertForbidden();
    }

    /** @test */
    public function api_customer_token_cannot_approve_loans_or_read_all_laporan(): void
    {
        $customer = $this->customer();
        $loan = Pinjaman::create([
            'anggota_id' => $customer->anggota->id,
            'nominal_pinjaman' => 1000000,
            'tenor' => 12,
            'jumlah_cicilan_dibayar' => 0,
            'sisa_pinjaman' => 1000000,
            'tanggal_pengajuan' => now()->toDateString(),
            'status' => 'Pengajuan',
            'status_persetujuan' => 'Menunggu',
        ]);

        $token = $this->postJson('/api/v1/tokens', [
            'email' => $customer->email,
            'password' => 'password',
        ])->json('data.token');

        $this->withToken($token)
            ->postJson("/api/v1/pinjaman/{$loan->id}/approval", [
                'status_persetujuan' => 'Disetujui',
            ])
            ->assertForbidden();
    }
}
