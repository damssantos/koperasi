<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();

            $table->string('email')->index();

            $table->string('code');

            $table->string('type');

            $table->timestamp('expires_at');

            $table->unsignedTinyInteger('attempts')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};