<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Mencatat aktivitas user.
     */
    public static function catat(
        string $aktivitas,
        ?Model $subject = null,
        ?array $dataSebelum = null,
        ?array $dataSesudah = null,
        ?string $deskripsi = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),

            'aktivitas' => $aktivitas,

            'deskripsi' => $deskripsi,

            'data_sebelum' => $dataSebelum,

            'data_sesudah' => $dataSesudah,

            'subject_type' => $subject
                ? get_class($subject)
                : null,

            'subject_id' => $subject?->getKey(),

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),
        ]);
    }
}