<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'deskripsi',
        'data_sebelum',
        'data_sesudah',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
    ];

    /**
     * User yang melakukan aktivitas
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Data/model yang terkena aktivitas
     */
    public function subject()
    {
        return $this->morphTo();
    }
}