<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_bunga', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->unique(); // Pegawai / Umum (orang luar)
            $table->decimal('persen_bunga', 6, 3); // % per bulan
            $table->timestamps();
        });

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->string('kategori_debitur')->default('Pegawai')->after('tenor');
            $table->decimal('persentase_bunga', 6, 3)->default(0)->after('kategori_debitur');
            $table->bigInteger('total_bunga')->default(0)->after('persentase_bunga');
            $table->date('tanggal_pelunasan')->nullable()->after('tanggal_pengajuan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_bunga');

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['kategori_debitur', 'persentase_bunga', 'total_bunga', 'tanggal_pelunasan']);
        });
    }
};