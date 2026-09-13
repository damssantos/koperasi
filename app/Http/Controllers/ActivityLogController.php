<?php

namespace App\Http\Controllers;

use App\Exports\ActivityLogExport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

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
        if ($request->filled('aktivitas')) {
            $query->where('aktivitas', $request->aktivitas);
        }

        $logs = $query
            ->paginate(15)
            ->withQueryString();

        $aktivitas = ActivityLog::query()
            ->select('aktivitas')
            ->distinct()
            ->orderBy('aktivitas')
            ->pluck('aktivitas');

        return view('activity_logs.index', compact(
            'logs',
            'aktivitas'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(
            new ActivityLogExport(
                $request->input('search'),
                $request->input('aktivitas')
            ),
            'activity-log-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }
}