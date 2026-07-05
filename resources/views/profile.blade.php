@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Profil Saya')

@section('styles')
<style>
    .profile-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        margin-top: 24px;
        width: 100%;
    }

    @media (min-width: 1024px) {
        .profile-container {
            grid-template-columns: 320px 1fr; /* Left panel 320px, Right panel takes the rest */
        }
    }

    .profile-card {
        background-color: #16192b;
        border: 1px solid #1f243d;
        border-radius: 16px;
        padding: 32px 24px;
        position: relative;
        overflow: hidden;
        transition: border-color 0.3s ease;
    }

    .profile-card:hover {
        border-color: rgba(143, 155, 179, 0.2);
    }

    .profile-avatar-circle {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid #16192b;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.25);
        background: linear-gradient(135deg, #2563eb, #4338ca);
        z-index: 10;
        position: relative;
    }

    .profile-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .info-item {
        background-color: rgba(7, 8, 15, 0.4);
        border: 1px solid #1f243d;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .info-item-full {
        grid-column: 1 / -1;
    }

    .info-icon-container {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background-color: rgba(47, 84, 237, 0.1);
        border: 1px solid rgba(47, 84, 237, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-icon {
        color: #2f54eb;
        width: 18px;
        height: 18px;
    }

    .info-label {
        display: block;
        font-size: 9px;
        font-weight: 700;
        color: #8f9bb3;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
    }

    /* Light Mode Overrides */
    body.light .profile-card {
        background-color: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
    }

    body.light .profile-avatar-circle {
        border-color: #ffffff;
    }

    body.light .info-item {
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }

    body.light .info-icon-container {
        background-color: rgba(37, 99, 235, 0.05);
        border-color: rgba(37, 99, 235, 0.15);
    }

    body.light .info-icon {
        color: #2563eb;
    }

    body.light .info-value {
        color: #1e293b;
    }

    body.light .info-label {
        color: #64748b;
    }
</style>
@endsection

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

    <!-- Main Profile Layout Container -->
    <div class="profile-container">
        
        <!-- Left Side: Profile Card & Quick Stats -->
        <div class="profile-card flex flex-col items-center text-center">
            <!-- Decorative Blur Background -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>

            <!-- Avatar Display -->
            <div class="profile-avatar-circle mt-4">
                @if($hasProfileAvatar)
                    <img src="{{ asset('storage/' . $profileAvatar) }}" alt="Avatar" class="profile-avatar-img">
                @else
                    <span class="text-white text-4xl font-bold">{{ $profileInitial }}</span>
                @endif
            </div>

            <div class="mt-6 space-y-1 z-10">
                <h3 class="text-lg font-bold text-white tracking-tight leading-tight">{{ $profileUser->nama_lengkap }}</h3>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 text-emerald-400 text-[10px] font-bold tracking-wide rounded-full mt-3" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
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

        <!-- Right Side: Detailed Profile Information -->
        <div class="profile-card">
            <div class="flex items-center gap-3 border-b border-[#1f243d] pb-5 mb-6">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center border border-blue-500/20">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Informasi Akun</h3>
                    <p class="text-[10px] text-[#8f9bb3]">Detail data diri Anda yang terdaftar pada sistem koperasi.</p>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <!-- Nama Lengkap -->
                <div class="info-item">
                    <div class="info-icon-container">
                        <i data-lucide="user-check" class="info-icon"></i>
                    </div>
                    <div>
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-value">{{ $profileUser->nama_lengkap }}</span>
                    </div>
                </div>

                <!-- NIK -->
                <div class="info-item">
                    <div class="info-icon-container">
                        <i data-lucide="credit-card" class="info-icon"></i>
                    </div>
                    <div>
                        <span class="info-label">NIK (Nomor Induk Kependudukan)</span>
                        <span class="info-value">{{ $profileUser->nik }}</span>
                    </div>
                </div>

                <!-- Email -->
                <div class="info-item">
                    <div class="info-icon-container">
                        <i data-lucide="mail" class="info-icon"></i>
                    </div>
                    <div>
                        <span class="info-label">Alamat Email</span>
                        <span class="info-value">{{ $profileUser->email }}</span>
                    </div>
                </div>

                <!-- No HP -->
                <div class="info-item">
                    <div class="info-icon-container">
                        <i data-lucide="phone" class="info-icon"></i>
                    </div>
                    <div>
                        <span class="info-label">Nomor HP</span>
                        <span class="info-value">{{ $profileUser->no_hp }}</span>
                    </div>
                </div>

                <!-- Alamat Tinggal (Full Width) -->
                <div class="info-item info-item-full">
                    <div class="info-icon-container">
                        <i data-lucide="map-pin" class="info-icon"></i>
                    </div>
                    <div>
                        <span class="info-label">Alamat Tinggal</span>
                        <span class="info-value" style="line-height: 1.6;">{{ $profileUser->alamat ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
