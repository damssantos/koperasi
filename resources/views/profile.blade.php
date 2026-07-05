@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Profil Saya')

@section('content')
    @php
        $profileUser = auth()->user();
        $profileAvatar = $profileUser->avatar;
        $hasProfileAvatar = $profileAvatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($profileAvatar);
        $profileInitial = strtoupper(substr(trim($profileUser->nama_lengkap ?: 'A'), 0, 1));
    @endphp
    
    <!-- Page Header Title -->
    <div class="flex flex-col gap-1 pb-6 border-b border-[#1f243d]">
        <h2 class="text-2xl font-bold text-white tracking-tight">Profil Saya</h2>
        <p class="text-xs text-[#8f9bb3]">Informasi detail akun keanggotaan Anda di Koperasi.</p>
    </div>

    <!-- Main Profile Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start mt-6">
        
        <!-- Left Side: Profile Card & Quick Stats -->
        <div class="lg:col-span-1">
            <!-- Profile Overview Card -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-8 flex flex-col items-center text-center relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
                <!-- Decorative Blur Background -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>

                <!-- Avatar Display -->
                <div class="relative mt-4 z-10">
                    @if($hasProfileAvatar)
                        <img src="{{ asset('storage/' . $profileAvatar) }}" alt="Avatar" class="w-28 h-28 rounded-full object-cover shadow-xl shadow-blue-500/25 border-4 border-[#16192b]">
                    @else
                        <div class="w-28 h-28 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-xl shadow-blue-500/25 border-4 border-[#16192b]" style="background: linear-gradient(135deg, #2563eb, #4338ca);">
                            <span>{{ $profileInitial }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-6 space-y-1.5 z-10">
                    <h3 class="text-lg font-bold text-white tracking-tight">{{ $profileUser->nama_lengkap }}</h3>
                    <p class="text-xs font-semibold text-[#8f9bb3]">Anggota Koperasi</p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 text-emerald-400 text-[10px] font-bold tracking-wide rounded-full mt-2" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Status Anggota Aktif</span>
                    </div>
                </div>

                <!-- Profile quick specs list -->
                <div class="w-full mt-8 pt-6 border-t border-[#1f243d] space-y-4 text-left text-xs z-10">
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>NIK Anggota:</span>
                        <span class="text-white font-semibold">{{ $profileUser->nik }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>Bergabung Sejak:</span>
                        <span class="text-white font-semibold">{{ $profileUser->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Detailed Profile Information -->
        <div class="lg:col-span-2">
            <!-- Information Card -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-8 space-y-6">
                <div class="flex items-center gap-3 border-b border-[#1f243d] pb-5">
                    <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center border border-blue-500/20">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Informasi Akun</h3>
                        <p class="text-[10px] text-[#8f9bb3]">Detail data diri Anda yang terdaftar pada sistem koperasi.</p>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-start gap-3">
                        <div class="text-[#8f9bb3] mt-0.5">
                            <i data-lucide="user-check" class="w-4 h-4 text-blue-500"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-1">Nama Lengkap</span>
                            <span class="text-sm font-semibold text-white">{{ $profileUser->nama_lengkap }}</span>
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-start gap-3">
                        <div class="text-[#8f9bb3] mt-0.5">
                            <i data-lucide="credit-card" class="w-4 h-4 text-blue-500"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-1">NIK (Nomor Induk Kependudukan)</span>
                            <span class="text-sm font-semibold text-white">{{ $profileUser->nik }}</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-start gap-3">
                        <div class="text-[#8f9bb3] mt-0.5">
                            <i data-lucide="mail" class="w-4 h-4 text-blue-500"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-1">Alamat Email</span>
                            <span class="text-sm font-semibold text-white">{{ $profileUser->email }}</span>
                        </div>
                    </div>

                    <!-- No HP -->
                    <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-start gap-3">
                        <div class="text-[#8f9bb3] mt-0.5">
                            <i data-lucide="phone" class="w-4 h-4 text-blue-500"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-1">Nomor HP</span>
                            <span class="text-sm font-semibold text-white">{{ $profileUser->no_hp }}</span>
                        </div>
                    </div>
                </div>

                <!-- Alamat Tinggal (Full Width) -->
                <div class="bg-[#07080f]/40 border border-[#1f243d] rounded-xl p-4 flex items-start gap-3">
                    <div class="text-[#8f9bb3] mt-0.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-1">Alamat Tinggal</span>
                        <span class="text-sm font-semibold text-white leading-relaxed">{{ $profileUser->alamat ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
