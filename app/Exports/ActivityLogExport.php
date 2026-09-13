<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActivityLogExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected ?string $search;
    protected ?string $aktivitas;

    public function __construct(
        ?string $search = null,
        ?string $aktivitas = null
    ) {
        $this->search = $search;
        $this->aktivitas = $aktivitas;
    }

    public function query(): Builder
    {
        $query = ActivityLog::with('user')
            ->latest();

        // Search
        if ($this->search) {
            $search = $this->search;

            $query->where(function ($q) use ($search) {
                $q->where('aktivitas', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter aktivitas
        if ($this->aktivitas) {
            $query->where('aktivitas', $this->aktivitas);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Waktu',
            'User',
            'Email',
            'Aktivitas',
            'Deskripsi',
            'Data',
            'Data Sebelum',
            'Data Sesudah',
            'IP Address',
            'User Agent',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,

            $log->created_at
                ? $log->created_at->format('Y-m-d H:i:s')
                : '-',

            $log->user?->nama_lengkap ?? 'Sistem',

            $log->user?->email ?? '-',

            ucwords(
                str_replace('_', ' ', $log->aktivitas)
            ),

            $log->deskripsi ?? '-',

            $log->subject_type && $log->subject_id
                ? class_basename($log->subject_type)
                    . ' #' . $log->subject_id
                : '-',

            $log->data_sebelum
                ? json_encode(
                    $log->data_sebelum,
                    JSON_UNESCAPED_UNICODE
                )
                : '-',

            $log->data_sesudah
                ? json_encode(
                    $log->data_sesudah,
                    JSON_UNESCAPED_UNICODE
                )
                : '-',

            $log->ip_address ?? '-',

            $log->user_agent ?? '-',
        ];
    }
}