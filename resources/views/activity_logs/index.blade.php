@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="history" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">History Aktivitas</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Riwayat aktivitas dan audit trail perubahan data yang dilakukan oleh pengguna.</p>
            </div>
        </div>

        <a href="{{ route('activity_logs.export', request()->query()) }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 text-white px-4 py-2 text-xs font-bold hover:bg-emerald-700 transition shadow-md shadow-emerald-600/20">
            <i data-lucide="file-down" class="w-4 h-4"></i>
            <span>Export Excel</span>
        </a>
    </div>

    <!-- FILTER CARD (Customer Style) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 shadow-sm">
        <form method="GET" action="{{ route('activity_logs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-[#64748B] mb-2 uppercase tracking-wider">Cari aktivitas</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas, deskripsi, user..."
                       class="w-full rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] text-[#0F172A] placeholder-[#64748B] px-4 py-2.5 text-xs font-medium focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#64748B] mb-2 uppercase tracking-wider">Jenis aktivitas</label>
                <select name="aktivitas" class="w-full rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] text-[#0F172A] px-4 py-2.5 text-xs font-semibold focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                    <option value="">Semua aktivitas</option>
                    @foreach ($aktivitas as $item)
                        <option value="{{ $item }}" @selected(request('aktivitas') === $item)>
                            {{ ucwords(str_replace('_', ' ', $item)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 rounded-xl bg-[#2563EB] text-white px-4 py-2.5 text-xs font-bold hover:bg-[#1D4ED8] transition shadow-md shadow-blue-600/20">
                    Cari
                </button>
                <a href="{{ route('activity_logs.index') }}" class="rounded-xl border border-[#E2E8F0] bg-white px-4 py-2.5 text-xs font-bold text-[#0F172A] hover:bg-[#F8FAFC] transition shadow-sm">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- TABLE CARD (Customer Style) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
                    <tr>
                        <th class="text-left px-5 py-4 text-xs font-bold text-[#64748B] uppercase tracking-wider">Waktu</th>
                        <th class="text-left px-5 py-4 text-xs font-bold text-[#64748B] uppercase tracking-wider">User</th>
                        <th class="text-left px-5 py-4 text-xs font-bold text-[#64748B] uppercase tracking-wider">Aktivitas</th>
                        <th class="text-left px-5 py-4 text-xs font-bold text-[#64748B] uppercase tracking-wider">Deskripsi</th>
                        <th class="text-right px-5 py-4 text-xs font-bold text-[#64748B] uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-[#F8FAFC] transition">
                            {{-- WAKTU --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-[#0F172A] font-bold text-xs">
                                    {{ $log->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs font-semibold text-[#64748B] mt-0.5">
                                    {{ $log->created_at->format('H:i:s') }}
                                </div>
                            </td>

                            {{-- USER --}}
                            <td class="px-5 py-4">
                                @if ($log->user)
                                    <div class="text-[#0F172A] font-bold text-xs">
                                        {{ $log->user->nama_lengkap }}
                                    </div>
                                    <div class="text-xs text-[#64748B]">
                                        {{ $log->user->email }}
                                    </div>
                                @else
                                    <span class="text-[#64748B] text-xs font-semibold">
                                        Sistem
                                    </span>
                                @endif
                            </td>

                            {{-- AKTIVITAS --}}
                            <td class="px-5 py-4">
                                @php
                                    $labelAktivitas = ucwords(str_replace('_', ' ', $log->aktivitas));
                                @endphp
                                <span class="inline-flex items-center rounded-xl bg-blue-50 border border-blue-200 px-3 py-1.5 text-xs font-bold text-[#2563EB]">
                                    {{ $labelAktivitas }}
                                </span>
                            </td>

                            {{-- DESKRIPSI --}}
                            <td class="px-5 py-4">
                                <div class="text-[#0F172A] font-medium text-xs max-w-md">
                                    {{ $log->deskripsi ?? '-' }}
                                </div>
                                @if ($log->subject_type && $log->subject_id)
                                    <div class="text-xs font-semibold text-[#64748B] mt-0.5">
                                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                    </div>
                                @endif
                            </td>

                            {{-- DETAIL --}}
                            <td class="px-5 py-4 text-right">
                                <button type="button" onclick="showActivityDetail({{ $log->id }})"
                                    class="w-8 h-8 rounded-lg bg-[#F8FAFC] text-[#64748B] border border-[#E2E8F0] inline-flex items-center justify-center hover:bg-white hover:text-[#0F172A] transition shadow-sm"
                                    title="Lihat Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>

                        <script>
                            window.activityLogs = window.activityLogs || {};
                            window.activityLogs[{{ $log->id }}] = {
                                id: @json($log->id),
                                waktu: @json($log->created_at->format('d M Y H:i:s')),
                                user: @json($log->user?->nama_lengkap ?? 'Sistem'),
                                email: @json($log->user?->email ?? '-'),
                                aktivitas: @json(ucwords(str_replace('_', ' ', $log->aktivitas))),
                                deskripsi: @json($log->deskripsi ?? '-'),
                                subject: @json($log->subject_type && $log->subject_id ? class_basename($log->subject_type) . ' #' . $log->subject_id : '-'),
                                sebelum: @json($log->data_sebelum),
                                sesudah: @json($log->data_sesudah),
                                ip: @json($log->ip_address ?? '-'),
                                userAgent: @json($log->user_agent ?? '-')
                            };
                        </script>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="text-sm font-bold text-[#0F172A]">Belum ada aktivitas.</div>
                                <div class="text-xs text-[#64748B] mt-1">Aktivitas yang tercatat akan muncul di sini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="px-5 py-4 border-t border-[#E2E8F0] bg-[#F8FAFC]">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>

<!-- MODAL DETAIL AKTIVITAS -->
<div id="activityDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4 py-6">
    <div class="w-full max-w-5xl max-h-[92vh] overflow-hidden bg-white border border-[#E2E8F0] rounded-2xl shadow-2xl flex flex-col">
        <!-- MODAL HEADER -->
        <div class="px-6 py-5 border-b border-[#E2E8F0] shrink-0">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB]">
                            <i data-lucide="history" class="w-5 h-5"></i>
                        </div>
                        <h2 class="text-lg font-extrabold text-[#0F172A]">Detail Aktivitas</h2>
                    </div>
                    <p id="detailTime" class="text-xs font-semibold text-[#64748B] mt-1 sm:ml-12">-</p>
                </div>

                <button type="button" onclick="closeActivityDetail()"
                    class="text-[#64748B] hover:text-[#0F172A] p-1.5 rounded-lg hover:bg-[#F8FAFC] transition-colors" aria-label="Tutup">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- MODAL CONTENT -->
        <div class="overflow-y-auto">
            <div class="p-6 space-y-6">
                <!-- INFORMASI UTAMA -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- USER -->
                    <div class="rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="user" class="w-4 h-4 text-[#64748B]"></i>
                            <span class="text-xs font-bold text-[#64748B]">User</span>
                        </div>
                        <div id="detailUser" class="text-sm font-extrabold text-[#0F172A]">-</div>
                        <div id="detailEmail" class="text-xs text-[#64748B] mt-0.5 truncate">-</div>
                    </div>

                    <!-- AKTIVITAS -->
                    <div class="rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="activity" class="w-4 h-4 text-[#64748B]"></i>
                            <span class="text-xs font-bold text-[#64748B]">Aktivitas</span>
                        </div>
                        <div id="detailActivity" class="text-sm font-extrabold text-[#0F172A]">-</div>
                    </div>

                    <!-- DATA -->
                    <div class="rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="database" class="w-4 h-4 text-[#64748B]"></i>
                            <span class="text-xs font-bold text-[#64748B]">Data</span>
                        </div>
                        <div id="detailSubject" class="text-sm font-extrabold text-[#0F172A]">-</div>
                    </div>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <div class="text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Deskripsi</div>
                    <div id="detailDescription" class="rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] px-4 py-3.5 text-xs font-medium text-[#0F172A] leading-relaxed">-</div>
                </div>

                <!-- PERUBAHAN DATA -->
                <div>
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div>
                            <h3 class="text-sm font-extrabold text-[#0F172A]">Perubahan Data</h3>
                            <p class="text-xs text-[#64748B] mt-0.5">Menampilkan data yang benar-benar mengalami perubahan.</p>
                        </div>
                        <div id="changeCount" class="shrink-0 text-[10px] font-bold px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[#2563EB]">
                            0 perubahan
                        </div>
                    </div>
                    <div id="detailChanges" class="rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] overflow-hidden">
                    </div>
                </div>

                <!-- INFORMASI DATA -->
                <div>
                    <div class="mb-3">
                        <h3 class="text-sm font-extrabold text-[#0F172A]">Informasi Data</h3>
                        <p class="text-xs text-[#64748B] mt-0.5">Ringkasan informasi setelah aktivitas dilakukan.</p>
                    </div>
                    <div id="detailCurrentData" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    </div>
                </div>

                <!-- INFORMASI TEKNIS -->
                <details class="group rounded-xl border border-[#E2E8F0] bg-[#F8FAFC]">
                    <summary class="cursor-pointer list-none px-4 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white border border-[#E2E8F0] flex items-center justify-center text-[#64748B]">
                                <i data-lucide="server" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-[#0F172A]">Informasi Teknis</div>
                                <div class="text-[11px] text-[#64748B] mt-0.5">Informasi sistem dan akses</div>
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-[#64748B] transition-transform duration-200 group-open:rotate-180"></i>
                    </summary>
                    <div class="border-t border-[#E2E8F0] px-4 py-4 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white">
                        <div>
                            <div class="text-[10px] uppercase tracking-wider font-bold text-[#64748B] mb-1">IP Address</div>
                            <div id="detailIp" class="text-xs text-[#0F172A] font-mono font-semibold">-</div>
                        </div>
                        <div>
                            <div class="text-[10px] uppercase tracking-wider font-bold text-[#64748B] mb-1">User Agent</div>
                            <div id="detailUserAgent" class="text-xs text-[#0F172A] break-all font-medium">-</div>
                        </div>
                    </div>
                </details>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="px-6 py-4 border-t border-[#E2E8F0] flex justify-end shrink-0 bg-[#F8FAFC]">
            <button type="button" onclick="closeActivityDetail()"
                class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition duration-150">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    const activityFieldLabels = {
        id: 'ID',
        anggota_id: 'ID Anggota',
        nominal_pinjaman: 'Nominal Pinjaman',
        tenor: 'Tenor',
        jumlah_cicilan_dibayar: 'Cicilan Dibayar',
        sisa_pinjaman: 'Sisa Pinjaman',
        tanggal_pengajuan: 'Tanggal Pengajuan',
        tanggal_pencairan: 'Tanggal Pencairan',
        status: 'Status',
        status_persetujuan: 'Status Persetujuan',
        keterangan: 'Keterangan',
        bukti_transfer: 'Bukti Transfer',
        dibatalkan_pada: 'Dibatalkan Pada',
        alasan_pembatalan: 'Alasan Pembatalan',
        dibuat_oleh: 'Dibuat Oleh',
        diperbarui_oleh: 'Diperbarui Oleh',
        created_at: 'Dibuat Pada',
        updated_at: 'Diperbarui Pada',
        user_id: 'User ID',
        nama: 'Nama',
        id_anggota: 'ID Anggota',
        no_hp: 'No. HP',
        tanggal_join: 'Tanggal Bergabung',
        simpanan_pokok: 'Simpanan Pokok',
        simpanan_wajib: 'Simpanan Wajib',
        simpanan_sukarela: 'Simpanan Sukarela',
        total_saldo: 'Total Saldo'
    };

    const hiddenAuditFields = [
        'id',
        'created_at',
        'updated_at',
        'tanggal_pencairan',
        'dibatalkan_pada',
        'dibuat_oleh',
        'diperbarui_oleh'
    ];

    const preferredInformationFields = [
        'nominal_pinjaman',
        'tenor',
        'jumlah_cicilan_dibayar',
        'sisa_pinjaman',
        'status',
        'status_persetujuan',
        'simpanan_pokok',
        'simpanan_wajib',
        'simpanan_sukarela',
        'total_saldo',
        'tanggal_pengajuan',
        'tanggal_join',
        'no_hp',
        'nama'
    ];

    function getActivityFieldLabel(field) {
        if (activityFieldLabels[field]) {
            return activityFieldLabels[field];
        }
        return field.replaceAll('_', ' ').replace(/\b\w/g, char => char.toUpperCase());
    }

    function escapeActivityHtml(value) {
        if (value === null || value === undefined) return '-';
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatActivityRupiah(value) {
        if (value === null || value === undefined || value === '') return '-';
        const number = Number(value);
        if (Number.isNaN(number)) return String(value);
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(number);
    }

    function formatActivityDate(value) {
        if (value === null || value === undefined || value === '') return '-';
        let dateString = String(value).replace(/\.(\d{3})\d+/, '.$1');
        const date = new Date(dateString);
        if (Number.isNaN(date.getTime())) return String(value);
        return date.toLocaleString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function formatActivityValue(field, value) {
        if (value === null || value === undefined || value === '') return '-';

        const rupiahFields = [
            'nominal_pinjaman',
            'sisa_pinjaman',
            'simpanan_pokok',
            'simpanan_wajib',
            'simpanan_sukarela',
            'total_saldo'
        ];

        if (rupiahFields.includes(field)) return formatActivityRupiah(value);
        if (field === 'tenor') return `${value} bulan`;
        if (field === 'jumlah_cicilan_dibayar') return `${value} kali`;
        if (field.includes('tanggal') || field.includes('_pada') || field.includes('_at')) return formatActivityDate(value);
        if (value === null || value === 'null') return '-';

        return String(value);
    }

    function auditValuesEqual(before, after) {
        if (before === null || before === undefined) before = null;
        if (after === null || after === undefined) after = null;
        return JSON.stringify(before) === JSON.stringify(after);
    }

    function renderActivityChanges(before, after) {
        const container = document.getElementById('detailChanges');
        const count = document.getElementById('changeCount');
        if (!container) return;

        container.innerHTML = '';
        before = before || {};
        after = after || {};

        const fields = new Set([...Object.keys(before), ...Object.keys(after)]);
        const changes = [];

        fields.forEach(field => {
            if (hiddenAuditFields.includes(field)) return;
            const beforeValue = before[field] ?? null;
            const afterValue = after[field] ?? null;
            if (!auditValuesEqual(beforeValue, afterValue)) {
                changes.push({ field: field, before: beforeValue, after: afterValue });
            }
        });

        if (changes.length === 0) {
            container.innerHTML = `
                <div class="px-5 py-7 text-center bg-white">
                    <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center mb-3">
                        <i data-lucide="check" class="w-5 h-5 text-[#64748B]"></i>
                    </div>
                    <div class="text-sm font-bold text-[#0F172A]">Tidak ada perubahan data.</div>
                    <div class="text-xs text-[#64748B] mt-0.5">Aktivitas ini tidak mengubah nilai data.</div>
                </div>
            `;
            if (count) count.textContent = '0 perubahan';
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        if (count) count.textContent = `${changes.length} perubahan`;

        changes.forEach((change, index) => {
            const fieldLabel = getActivityFieldLabel(change.field);
            const beforeValue = formatActivityValue(change.field, change.before);
            const afterValue = formatActivityValue(change.field, change.after);

            const row = document.createElement('div');
            row.className = `px-5 py-4 bg-white ${index < changes.length - 1 ? 'border-b border-[#E2E8F0]' : ''}`;
            row.innerHTML = `
                <div class="text-xs font-bold text-[#0F172A] mb-2.5">
                    ${escapeActivityHtml(fieldLabel)}
                </div>
                <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-3 items-center">
                    <div class="rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] px-3.5 py-2.5">
                        <div class="text-[10px] uppercase tracking-wider font-bold text-[#64748B] mb-1">Sebelum</div>
                        <div class="text-xs font-medium text-[#64748B] break-words">${escapeActivityHtml(beforeValue)}</div>
                    </div>
                    <div class="hidden md:flex w-7 h-7 rounded-full bg-slate-100 border border-slate-200 items-center justify-center text-[#64748B]">
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </div>
                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-3.5 py-2.5">
                        <div class="text-[10px] uppercase tracking-wider font-bold text-emerald-700 mb-1">Sesudah</div>
                        <div class="text-xs font-bold text-emerald-700 break-words">${escapeActivityHtml(afterValue)}</div>
                    </div>
                </div>
            `;
            container.appendChild(row);
        });

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function renderActivityCurrentData(data) {
        const container = document.getElementById('detailCurrentData');
        if (!container) return;

        container.innerHTML = '';
        if (!data) return;

        const availableFields = preferredInformationFields.filter(field =>
            Object.prototype.hasOwnProperty.call(data, field)
        );

        availableFields.forEach(field => {
            const value = formatActivityValue(field, data[field]);
            const card = document.createElement('div');
            card.className = 'rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] px-4 py-3';
            card.innerHTML = `
                <div class="text-[10px] font-bold text-[#64748B] mb-1 uppercase tracking-wider">
                    ${escapeActivityHtml(getActivityFieldLabel(field))}
                </div>
                <div class="text-xs font-bold text-[#0F172A] break-words">
                    ${escapeActivityHtml(value)}
                </div>
            `;
            container.appendChild(card);
        });

        if (availableFields.length === 0) {
            container.innerHTML = `
                <div class="sm:col-span-2 lg:col-span-4 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] px-4 py-6 text-center">
                    <div class="text-xs font-semibold text-[#64748B]">Tidak ada informasi tambahan.</div>
                </div>
            `;
        }
    }

    function showActivityDetail(id) {
        const log = window.activityLogs?.[id];
        if (!log) return;

        document.getElementById('detailTime').textContent = log.waktu || '-';
        document.getElementById('detailUser').textContent = log.user || 'Sistem';
        document.getElementById('detailEmail').textContent = log.email || '-';
        document.getElementById('detailActivity').textContent = log.aktivitas || '-';
        document.getElementById('detailSubject').textContent = log.subject || '-';
        document.getElementById('detailDescription').textContent = log.deskripsi || '-';

        renderActivityChanges(log.sebelum, log.sesudah);
        renderActivityCurrentData(log.sesudah);

        document.getElementById('detailIp').textContent = log.ip || '-';
        document.getElementById('detailUserAgent').textContent = log.userAgent || '-';

        const modal = document.getElementById('activityDetailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function closeActivityDetail() {
        const modal = document.getElementById('activityDetailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    const activityModal = document.getElementById('activityDetailModal');
    if (activityModal) {
        activityModal.addEventListener('click', function(event) {
            if (event.target === this) closeActivityDetail();
        });
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('activityDetailModal');
            if (modal && !modal.classList.contains('hidden')) closeActivityDetail();
        }
    });
</script>

@endsection