<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->string('bukti_potongan')->nullable()->after('potongan_admin');
            $table->bigInteger('denda')->default(0)->after('total_bunga');
        });

        Schema::table('pengaturan_bunga', function (Blueprint $table) {
            $table->bigInteger('limit_nominal')->default(0)->after('persen_bunga');
            $table->decimal('denda_persen', 6, 3)->default(0)->after('limit_nominal');
        });
    }

    public function down(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['bukti_potongan', 'denda']);
        });

        Schema::table('pengaturan_bunga', function (Blueprint $table) {
            $table->dropColumn(['limit_nominal', 'denda_persen']);
        });
    }
};
