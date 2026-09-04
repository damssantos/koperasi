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
        // Only add if column doesn't exist to prevent errors
        Schema::table('anggota_koperasi', function (Blueprint $table) {
            if (!Schema::hasColumn('anggota_koperasi', 'id_anggota')) {
                $table->string('id_anggota')->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('anggota_koperasi', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('anggota_koperasi', 'tanggal_join')) {
                $table->date('tanggal_join')->nullable()->after('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota_koperasi', function (Blueprint $table) {
            $table->dropColumn(['id_anggota', 'no_hp', 'tanggal_join']);
        });
    }
};
