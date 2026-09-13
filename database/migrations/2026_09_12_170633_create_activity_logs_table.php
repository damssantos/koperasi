<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Jenis aktivitas
            $table->string('aktivitas');

            // Keterangan aktivitas
            $table->text('deskripsi')->nullable();

            // Data sebelum perubahan
            $table->json('data_sebelum')->nullable();

            // Data setelah perubahan
            $table->json('data_sesudah')->nullable();

            // Model yang terkena perubahan
            $table->string('subject_type')->nullable();

            // ID data yang terkena perubahan
            $table->unsignedBigInteger('subject_id')->nullable();

            // IP address
            $table->string('ip_address', 45)->nullable();

            // User agent/browser
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Mempermudah pencarian berdasarkan objek
            $table->index([
                'subject_type',
                'subject_id'
            ]);

            // Mempermudah filter berdasarkan aktivitas
            $table->index('aktivitas');

            // Mempermudah filter berdasarkan user
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};