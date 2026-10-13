@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Pengaturan Bunga')

@section('content')

<div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
            <i data-lucide="percent" class="w-6 h-6 text-white" stroke="white"></i>
        </div>
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Pengaturan Bunga</h1>
            <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Atur persentase bunga per bulan untuk setiap kategori debitur (flat per bulan).</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white border border-[#E2E8F0] rounded-2xl shadow-sm overflow-hidden mt-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Kategori Debitur</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Bunga per Bulan</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Terakhir Diubah</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E2E8F0]">
                @forelse($pengaturan as $item)
                    <tr class="hover:bg-[#F8FAFC] transition duration-150">
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-[#0F172A]">{{ $item->kategori }}</div>
                            <div class="text-[11px] font-medium text-[#64748B] mt-0.5">
                                {{ $item->kategori === 'Pegawai' ? 'Pegawai / anggota internal' : 'Orang luar / umum' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('pengaturan-bunga.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="persen_bunga" value="{{ $item->persen_bunga }}" min="0" max="100" step="0.01" required
                                    class="w-28 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs font-medium text-[#0F172A] focus:outline-none focus:border-[#2563EB] focus:bg-white transition">
                                <span class="text-xs font-bold text-[#64748B]">% / bulan</span>
                                <button type="submit" onclick="return confirm('Simpan perubahan bunga kategori {{ $item->kategori }}?')"
                                    class="px-3 py-2 text-xs font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] rounded-xl transition duration-150 shadow-sm">
                                    Simpan
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-[#64748B]">
                            {{ optional($item->updated_at)->format('d M Y H:i') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-[#64748B]">
                            Berlaku untuk pinjaman baru
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-xs text-[#64748B]">
                            Belum ada pengaturan bunga. Jalankan seeder/migrasi untuk membuat data awal.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection