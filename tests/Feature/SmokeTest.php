<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    // Runs against the real MySQL DB but RefreshDatabase rolls back every test
    // in a transaction, so nothing persists. Read checks only touch live data safely.
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    /** @test */
    public function guest_pages_render(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
        $this->get('/forgot-password')->assertOk();
        $this->get('/captcha')->assertOk();
        $this->get('/')->assertRedirect('/login');
    }

    /** @test */
    public function protected_pages_require_login(): void
    {
        foreach (['/dashboard', '/anggota', '/simpanan', '/pinjaman', '/customer/dashboard', '/pengawas', '/pelunasan'] as $url) {
            $this->get($url)->assertRedirect();
        }
    }

    /** @test */
    public function admin_pages_render_for_admin(): void
    {
        $this->actingAs($this->user('admin'));
        foreach (['/dashboard', '/anggota', '/simpanan', '/pinjaman', '/laporan'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    /** @test */
    public function customer_pages_render_for_customer(): void
    {
        $u = $this->user('customer');
        $u->anggota()->create(['nama' => 'QA Smoke', 'no_hp' => '0800000000', 'tanggal_join' => now()]);
        $this->actingAs($u->fresh());
        foreach (['/customer/dashboard', '/customer/simpanan', '/customer/pinjaman', '/customer/riwayat', '/customer/profil'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    /** @test */
    public function pengawas_pages_render_for_pengawas(): void
    {
        $this->actingAs($this->user('pengawas'));
        foreach (['/pengawas', '/pengawas/laporan', '/pengawas/laporan/simpanan', '/pengawas/laporan/pinjaman', '/pengawas/laporan/kas-usaha'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    /** @test */
    public function customer_cannot_access_admin_pages(): void
    {
        $this->actingAs($this->user('customer'));
        foreach (['/dashboard', '/anggota', '/simpanan', '/pinjaman'] as $url) {
            $this->get($url)->assertForbidden();
        }
    }

    /** @test */
    public function admin_cannot_access_customer_dashboard(): void
    {
        $this->actingAs($this->user('admin'));
        $this->get('/customer/dashboard')->assertForbidden();
    }

    /** @test */
    public function customer_can_submit_loan_application(): void
    {
        $u = $this->user('customer');
        $u->anggota()->create(['nama' => 'QA Smoke', 'no_hp' => '0800000000', 'tanggal_join' => now()]);

        $this->actingAs($u->fresh())
            ->post('/customer/pinjaman', [
                'nominal_pinjaman' => '1.500.000',
                'tenor' => 12,
                'keterangan' => 'smoke test',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pinjaman', [
            'anggota_id' => $u->anggota->id,
            'nominal_pinjaman' => 1500000,
            'status' => 'Pengajuan',
            'status_persetujuan' => 'Menunggu',
        ]);
    }

    /** @test */
    public function admin_can_create_simpanan_and_balance_updates(): void
    {
        $u = $this->user('admin');
        $anggota = $u->anggota()->create([
            'nama' => 'QA Smoke', 'no_hp' => '0800000000', 'tanggal_join' => now(),
            'simpanan_pokok' => 0, 'simpanan_wajib' => 0, 'simpanan_sukarela' => 0, 'total_saldo' => 0,
        ]);

        $this->actingAs($u->fresh())
            ->post('/simpanan', [
                'anggota_id' => $anggota->id,
                'jenis_simpanan' => 'Sukarela',
                'nominal' => 250000,
                'tanggal_transaksi' => now()->toDateString(),
                'status' => 'Aktif',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('transaksi_simpanan', ['anggota_id' => $anggota->id, 'nominal' => 250000]);
        $this->assertDatabaseHas('anggota_koperasi', ['id' => $anggota->id, 'total_saldo' => 250000]);
    }
}
