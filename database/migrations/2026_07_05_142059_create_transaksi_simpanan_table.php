<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_simpanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota_koperasi')->onDelete('cascade');
            $table->string('jenis_simpanan'); // Pokok, Wajib, Sukarela
            $table->integer('nominal');
            $table->string('status')->default('Aktif'); // Aktif, Lunas
            $table->date('tanggal_transaksi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Migrate existing member balances to transactions table
        $members = DB::table('anggota_koperasi')->get();
        foreach ($members as $member) {
            $date = $member->tanggal_join ?? $member->created_at ?? now();

            if ($member->simpanan_pokok > 0) {
                DB::table('transaksi_simpanan')->insert([
                    'anggota_id' => $member->id,
                    'jenis_simpanan' => 'Pokok',
                    'nominal' => $member->simpanan_pokok,
                    'status' => 'Lunas',
                    'tanggal_transaksi' => $date,
                    'keterangan' => 'Setoran awal Simpanan Pokok saat mendaftar.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($member->simpanan_wajib > 0) {
                DB::table('transaksi_simpanan')->insert([
                    'anggota_id' => $member->id,
                    'jenis_simpanan' => 'Wajib',
                    'nominal' => $member->simpanan_wajib,
                    'status' => 'Aktif',
                    'tanggal_transaksi' => $date,
                    'keterangan' => 'Setoran rutin bulanan Simpanan Wajib.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($member->simpanan_sukarela > 0) {
                DB::table('transaksi_simpanan')->insert([
                    'anggota_id' => $member->id,
                    'jenis_simpanan' => 'Sukarela',
                    'nominal' => $member->simpanan_sukarela,
                    'status' => 'Aktif',
                    'tanggal_transaksi' => $date,
                    'keterangan' => 'Setoran sukarela anggota.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_simpanan');
    }
};
