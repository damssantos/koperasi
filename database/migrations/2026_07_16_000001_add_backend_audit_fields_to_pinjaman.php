<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('status');
            $table->string('status_persetujuan')->default('Disetujui')->after('status');
            $table->timestamp('tanggal_pencairan')->nullable()->after('tanggal_pengajuan');
            $table->timestamp('dibatalkan_pada')->nullable()->after('tanggal_pencairan');
            $table->text('alasan_pembatalan')->nullable()->after('dibatalkan_pada');
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('diperbarui_oleh')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dibuat_oleh');
            $table->dropConstrainedForeignId('diperbarui_oleh');
            $table->dropColumn(['keterangan', 'status_persetujuan', 'tanggal_pencairan', 'dibatalkan_pada', 'alasan_pembatalan']);
        });
    }
};
