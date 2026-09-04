<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    public static function catat(string $aksi, Model $model, ?array $sebelum = null, ?array $sesudah = null): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'aksi' => $aksi,
            'subjek_tipe' => $model::class,
            'subjek_id' => $model->getKey(),
            'data_sebelum' => $sebelum,
            'data_sesudah' => $sesudah,
            'ip_address' => request()?->ip(),
        ]);
    }
}
