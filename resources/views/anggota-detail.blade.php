@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Detail Anggota')

@section('content')
    @php
        $formatRupiah = fn ($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
        $profileInitial = strtoupper(substr(trim($anggota->nama ?: 'A'), 0, 1));
    @endphp

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Detail Anggota</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Informasi lengkap dan rincian saldo simpanan anggota koperasi.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition duration-150 text-xs font-semibold">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Daftar</span>
            </a>
            <a href="{{ route('anggota.index') }}?edit={{ $anggota->id }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                <span>Ubah Anggota</span>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
        
        <!-- Left Column: Member Card -->
        <div class="xl:col-span-1 space-y-6">
            <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-6 flex flex-col items-center text-center relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
                <!-- Decorative Blur Background -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>

                <!-- Initial Avatar -->
                <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-xl shadow-blue-500/25 border-4 border-[#16192b] mt-4" style="background: linear-gradient(135deg, #2563eb, #4338ca);">
                    <span>{{ $profileInitial }}</span>
                </div>

                <div class="mt-5 space-y-1 z-10">
                    <h3 class="text-lg font-bold text-white tracking-tight">{{ $anggota->nama }}</h3>
                    <p class="text-xs font-semibold text-[#8f9bb3]">{{ $anggota->id_anggota ?? 'AGT-' . str_pad($anggota->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 text-emerald-400 text-[10px] font-bold tracking-wide rounded-full mt-2" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Anggota Aktif</span>
                    </div>
                </div>

                <!-- Info List -->
                <div class="w-full mt-8 pt-6 border-t border-[#1f243d] space-y-4 text-left text-xs">
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>Nomor HP:</span>
                        <span class="text-white font-semibold">{{ $anggota->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>Bergabung Pada:</span>
                        <span class="text-white font-semibold">{{ optional($anggota->tanggal_join ?? $anggota->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Savings Breakdown -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Savings Breakdown Card -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-6 space-y-6">
                <div class="flex items-center gap-3 border-b border-[#1f243d] pb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center border border-blue-500/20">
                        <i data-lucide="wallet" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Rincian Simpanan Koperasi</h3>
                        <p class="text-[10px] text-[#8f9bb3]">Pembagian saldo simpanan pokok, wajib, dan sukarela.</p>
                    </div>
                </div>

                <!-- Grid Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 space-y-1">
                        <p class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-wider">Simpanan Pokok</p>
                        <h4 class="text-lg font-bold text-white">{{ $formatRupiah($anggota->simpanan_pokok) }}</h4>
                    </div>
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 space-y-1">
                        <p class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-wider">Simpanan Wajib</p>
                        <h4 class="text-lg font-bold text-white">{{ $formatRupiah($anggota->simpanan_wajib) }}</h4>
                    </div>
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 space-y-1">
                        <p class="text-[9px] font-bold text-[#8f9bb3] uppercase tracking-wider">Simpanan Sukarela</p>
                        <h4 class="text-lg font-bold text-white">{{ $formatRupiah($anggota->simpanan_sukarela) }}</h4>
                    </div>
                </div>

                <!-- Total Balance Card -->
                <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 border border-blue-500/20 rounded-xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Akumulasi Saldo</p>
                        <h3 class="text-2xl font-black text-white">{{ $formatRupiah($anggota->total_saldo ?: ($anggota->simpanan_pokok + $anggota->simpanan_wajib + $anggota->simpanan_sukarela)) }}</h3>
                    </div>
                    <a href="{{ route('simpanan') }}" class="px-4 py-2 bg-[#2f54eb] hover:bg-blue-600 text-white rounded-lg text-xs font-bold transition duration-150 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Tambah Setoran Simpanan</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
