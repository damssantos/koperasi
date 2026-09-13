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
        Schema::create('transaksi_kas_usaha', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('jenis_transaksi'); // PENERIMAAN, PENGELUARAN, MODAL
            $table->string('keterangan');
            $table->bigInteger('nominal');
            $table->timestamps();
        });

        // Seed initial 10 transactions from the design image
        $data = [
            [
                'tanggal' => '2023-10-16 09:10:00',
                'jenis_transaksi' => 'PENGELUARAN',
                'keterangan' => 'Biaya pemeliharaan rutin',
                'nominal' => 350000,
            ],
            [
                'tanggal' => '2023-10-17 11:20:00',
                'jenis_transaksi' => 'PENERIMAAN',
                'keterangan' => 'Bunga bank bulanan',
                'nominal' => 50000,
            ],
            [
                'tanggal' => '2023-10-18 14:00:00',
                'jenis_transaksi' => 'PENGELUARAN',
                'keterangan' => 'Biaya transportasi dinas',
                'nominal' => 150000,
            ],
            [
                'tanggal' => '2023-10-19 08:30:00',
                'jenis_transaksi' => 'PENERIMAAN',
                'keterangan' => 'Setoran awal pembukaan kas',
                'nominal' => 20000000,
            ],
            [
                'tanggal' => '2023-10-20 15:45:00',
                'jenis_transaksi' => 'PENGELUARAN',
                'keterangan' => 'Pembayaran tagihan listrik dan air',
                'nominal' => 1200000,
            ],
            [
                'tanggal' => '2023-10-21 10:15:00',
                'jenis_transaksi' => 'PENERIMAAN',
                'keterangan' => 'Penerimaan donasi sukarela',
                'nominal' => 5000000,
            ],
            [
                'tanggal' => '2023-10-22 16:30:00',
                'jenis_transaksi' => 'PENGELUARAN',
                'keterangan' => 'Biaya konsumsi rapat',
                'nominal' => 750000,
            ],
            [
                'tanggal' => '2023-10-23 09:00:00',
                'jenis_transaksi' => 'PENERIMAAN',
                'keterangan' => 'Setoran modal dari pusat',
                'nominal' => 10000000,
            ],
            [
                'tanggal' => '2023-10-24 11:45:00',
                'jenis_transaksi' => 'PENGELUARAN',
                'keterangan' => 'Operasional kantor harian',
                'nominal' => 450000,
            ],
            [
                'tanggal' => '2023-10-24 14:20:00',
                'jenis_transaksi' => 'PENERIMAAN',
                'keterangan' => 'Iuran bulanan anggota',
                'nominal' => 1500000,
            ],
        ];

        foreach ($data as $row) {
            DB::table('transaksi_kas_usaha')->insert(array_merge($row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas_usaha');
    }
};
