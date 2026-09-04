<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_cicilan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pinjaman_id')->constrained('pinjaman')->restrictOnDelete();
            $table->date('tanggal_pembayaran');
            $table->unsignedBigInteger('nominal_pokok');
            $table->unsignedBigInteger('denda')->default(0);
            $table->string('metode_pembayaran', 30)->default('Tunai');
            $table->string('nomor_bukti')->unique();
            $table->string('bukti_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_cicilan');
    }
};
