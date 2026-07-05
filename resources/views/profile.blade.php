@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Profil Saya')

@section('styles')
<style>
    .profile-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px !important;
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
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        border-color: rgba(47, 84, 237, 0.3);
        box-shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.3);
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
        border: 4px solid #1f243d;
        box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
        z-index: 10;
        position: relative;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .profile-card:hover .profile-avatar-circle {
        transform: scale(1.03);
        border-color: #2f54eb;
    }

    .profile-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px !important;
        row-gap: 24px !important;
        column-gap: 24px !important;
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
        flex-direction: column;
        gap: 8px !important;
        transition: border-color 0.3s ease;
    }

    .info-item:hover {
        border-color: rgba(143, 155, 179, 0.15);
    }

    .info-item-full {
        grid-column: 1 / -1;
    }

    .info-header-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-icon-container {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: rgba(47, 84, 237, 0.1);
        border: 1px solid rgba(47, 84, 237, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-icon {
        color: #2f54eb;
        width: 16px;
        height: 16px;
    }

    .info-label {
        font-size: 10px;
        font-weight: 700;
        color: #8f9bb3;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .input-wrapper {
        position: relative;
        width: 100%;
    }

    .info-input {
        width: 100%;
        background-color: #07080f;
        border: 1px solid #1f243d;
        border-radius: 8px;
        padding: 10px 14px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
    }

    .info-input:focus {
        outline: none;
        border-color: #2f54eb;
        box-shadow: 0 0 12px rgba(47, 84, 237, 0.25);
        background-color: rgba(7, 8, 15, 0.6);
    }

    .info-input[readonly],
    .info-input[disabled] {
        background-color: rgba(7, 8, 15, 0.25);
        color: #64748b;
        cursor: not-allowed;
        border-color: #1f243d;
        padding-right: 38px; /* Extra space for the lock icon */
    }

    .info-input[readonly]:focus,
    .info-input[disabled]:focus {
        border-color: #1f243d;
        box-shadow: none;
    }

    .lock-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: #475569;
        pointer-events: none;
    }

    .info-textarea {
        min-height: 100px;
        max-height: 180px;
        resize: vertical;
    }

    /* Light Mode Overrides */
    body.light .profile-card {
        background-color: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
    }

    body.light .profile-avatar-circle {
        border-color: #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.15);
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

    body.light .info-input {
        background-color: #ffffff;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    body.light .info-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
    }

    body.light .info-input[readonly],
    body.light .info-input[disabled] {
        background-color: #f1f5f9;
        color: #94a3b8;
        border-color: #cbd5e1;
    }

    body.light .lock-icon {
        color: #94a3b8;
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
                    <!-- Premium Styled Letter Avatar -->
                    <div class="w-full h-full flex items-center justify-center" style="background: radial-gradient(circle, #2f54eb 0%, #07080f 100%);">
                        <span class="text-white text-4xl font-extrabold tracking-tight" style="text-shadow: 0 4px 10px rgba(0, 0, 0, 0.4); font-family: 'Plus Jakarta Sans', sans-serif;">{{ $profileInitial }}</span>
                    </div>
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
            <div class="w-full mt-8 pt-6 border-t border-[#1f243d] space-y-4 text-left text-xs z-10" style="border-top: 1px solid #1f243d;">
                <div class="flex items-center justify-between" style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <span style="color: #8f9bb3;">NIK Anggota:</span>
                    <span style="color: #ffffff; font-weight: 600;" class="text-white">{{ $profileUser->nik }}</span>
                </div>
                <div class="flex items-center justify-between" style="display: flex; justify-content: space-between;">
                    <span style="color: #8f9bb3;">Bergabung Sejak:</span>
                    <span style="color: #ffffff; font-weight: 600;" class="text-white">{{ $profileUser->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Detailed Profile Information (FORM) -->
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

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Info Grid -->
                <div class="info-grid">
                    <!-- Nama Lengkap (READ-ONLY WITH LOCK) -->
                    <div class="info-item">
                        <div class="info-header-container">
                            <div class="info-icon-container">
                                <i data-lucide="user-check" class="info-icon"></i>
                            </div>
                            <label class="info-label">Nama Lengkap</label>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" class="info-input" value="{{ $profileUser->nama_lengkap }}" readonly disabled>
                            <i data-lucide="lock" class="lock-icon"></i>
                        </div>
                    </div>

                    <!-- NIK (READ-ONLY WITH LOCK) -->
                    <div class="info-item">
                        <div class="info-header-container">
                            <div class="info-icon-container">
                                <i data-lucide="credit-card" class="info-icon"></i>
                            </div>
                            <label class="info-label">NIK (Nomor Induk Kependudukan)</label>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" class="info-input" value="{{ $profileUser->nik }}" readonly disabled>
                            <i data-lucide="lock" class="lock-icon"></i>
                        </div>
                    </div>

                    <!-- Email (READ-ONLY WITH LOCK) -->
                    <div class="info-item">
                        <div class="info-header-container">
                            <div class="info-icon-container">
                                <i data-lucide="mail" class="info-icon"></i>
                            </div>
                            <label class="info-label">Alamat Email</label>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" class="info-input" value="{{ $profileUser->email }}" readonly disabled>
                            <i data-lucide="lock" class="lock-icon"></i>
                        </div>
                    </div>

                    <!-- No HP (EDITABLE) -->
                    <div class="info-item">
                        <div class="info-header-container">
                            <div class="info-icon-container">
                                <i data-lucide="phone" class="info-icon"></i>
                            </div>
                            <label class="info-label">Nomor HP <span class="text-blue-500 font-bold">*</span></label>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" name="no_hp" class="info-input" value="{{ old('no_hp', $profileUser->no_hp) }}" required>
                        </div>
                    </div>

                    <!-- Alamat Tinggal (EDITABLE, Full Width) -->
                    <div class="info-item info-item-full">
                        <div class="info-header-container">
                            <div class="info-icon-container">
                                <i data-lucide="map-pin" class="info-icon"></i>
                            </div>
                            <label class="info-label">Alamat Tinggal <span class="text-blue-500 font-bold">*</span></label>
                        </div>
                        <div class="input-wrapper">
                            <textarea name="alamat" class="info-input info-textarea" required>{{ old('alamat', $profileUser->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-8">
                    <button type="submit" class="px-6 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition duration-150 flex items-center gap-2 shadow-md shadow-blue-500/10">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
