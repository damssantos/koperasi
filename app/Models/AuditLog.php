<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['user_id', 'aksi', 'subjek_tipe', 'subjek_id', 'data_sebelum', 'data_sesudah', 'ip_address'];
    protected $casts = ['data_sebelum' => 'array', 'data_sesudah' => 'array'];
}
