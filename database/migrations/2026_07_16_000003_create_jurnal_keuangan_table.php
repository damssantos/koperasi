<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal_keuangan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('jenis');
            $table->string('arah', 12); // MASUK atau KELUAR
            $table->unsignedBigInteger('nominal');
            $table->string('referensi_tipe')->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->string('nomor_bukti')->nullable()->index();
            $table->text('keterangan')->nullable();
            $table->foreignId('anggota_id')->nullable()->constrained('anggota_koperasi')->nullOnDelete();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['referensi_tipe', 'referensi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_keuangan');
    }
};
