<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota_koperasi')->onDelete('cascade');
            $table->bigInteger('nominal_pinjaman');
            $table->integer('tenor'); // Tenor in months
            $table->integer('jumlah_cicilan_dibayar'); // How many installments paid
            $table->bigInteger('sisa_pinjaman');
            $table->date('tanggal_pengajuan');
            $table->string('status'); // Aktif, Menunggak, Lunas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
