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

    /* Make the initial letter big and bold */
    .profile-avatar-circle span {
        font-size: 46px !important;
        font-weight: 800 !important;
        color: #ffffff !important;
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
        margin-top: 28px; /* Breathing room below the header line */
    }

    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .info-item {
        background-color: #1e2238; /* Soft navy slate */
        border: 1px solid #2a2f4c; /* Softer border */
        border-radius: 12px;
        padding: 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 12px !important;
    }

    .info-item-full {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 12px; /* Normal, legible label size */
        font-weight: 700;
        color: #8f9bb3;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-input {
        width: 100%;
        background-color: #111322; /* Soft input background */
        border: 1px solid #252b48; /* Softer input borders */
        border-radius: 8px;
        padding: 12px 16px;
        color: #ffffff;
        font-size: 14.5px; /* Normal, user-friendly font size */
        font-weight: 500;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .info-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .info-input[readonly],
    .info-input[disabled] {
        background-color: #161828; /* Softer readonly background */
        color: #828fa9; /* Legible readonly text */
        cursor: not-allowed;
        border-color: #1d2136;
    }

    .info-textarea {
        min-height: 100px;
        resize: vertical;
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
        background-color: #f1f5f9;
        border-color: #e2e8f0;
    }

    body.light .info-input {
        background-color: #ffffff;
        border-color: #cbd5e1;
        color: #334155;
    }

    body.light .info-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
    }

    body.light .info-input[readonly],
    body.light .info-input[disabled] {
        background-color: #f8fafc;
        color: #64748b;
        border-color: #e2e8f0;
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
        
        <!-- Left Side: Profile Card & Quick Stats & Help Card -->
        <div class="flex flex-col">
            <!-- Profile Overview Card -->
            <div class="profile-card flex flex-col items-center text-center">
                <!-- Decorative Blur Background -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>

                <!-- Avatar Display -->
                <div class="profile-avatar-circle mt-4">
                    @if($hasProfileAvatar)
                        <img src="{{ asset('storage/' . $profileAvatar) }}" alt="Avatar" class="profile-avatar-img">
                    @else
                        <span>{{ $profileInitial }}</span>
                    @endif
                </div>

                <div class="mt-6 space-y-1.5 z-10">
                    <h3 style="font-size: 20px;" class="font-bold text-white tracking-tight leading-tight">{{ $profileUser->nama_lengkap }}</h3>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 text-emerald-400 text-[10px] font-bold tracking-wide rounded-full mt-3" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Status Anggota Aktif</span>
                    </div>
                </div>

                <!-- Profile quick specs list -->
                <div class="w-full mt-8 pt-6 border-t border-[#1f243d] space-y-4 text-left z-10" style="border-top: 1px solid #1f243d; font-size: 13px;">
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

            <!-- Help & Guidance Card (Fills empty space beautifully) -->
            <div class="profile-card mt-6" style="margin-top: 24px; padding: 22px; border-color: rgba(47, 84, 237, 0.15); background: linear-gradient(135deg, rgba(22, 25, 43, 0.5), rgba(30, 34, 56, 0.3));">
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background-color: rgba(47, 84, 237, 0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(47, 84, 237, 0.2);">
                        <i data-lucide="shield-alert" style="color: #2f54eb; width: 16px; height: 16px;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #ffffff; margin: 0 0 6px 0;">Bantuan & Keamanan</h4>
                        <p style="font-size: 12px; color: #8f9bb3; line-height: 1.6; margin: 0;">Apabila terdapat ketidaksesuaian pada data <strong>Nama</strong>, <strong>NIK</strong>, atau <strong>Email</strong> Anda, silakan hubungi Administrator Koperasi untuk bantuan perubahan data.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Detailed Profile Information (FORM) -->
        <div class="profile-card">
            <!-- Information Card Header (Enlarged and with more space) -->
            <div class="flex flex-col gap-1.5 border-b border-[#1f243d] pb-6 mb-4">
                <h3 style="font-size: 16px; font-weight: 700;" class="text-white uppercase tracking-wider">Informasi Akun</h3>
                <p style="font-size: 12px;" class="text-[#8f9bb3]">Detail data diri Anda yang terdaftar pada sistem koperasi.</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Info Grid -->
                <div class="info-grid">
                    <!-- Nama Lengkap (READ-ONLY) -->
                    <div class="info-item">
                        <label class="info-label">Nama Lengkap</label>
                        <input type="text" class="info-input" value="{{ $profileUser->nama_lengkap }}" readonly disabled>
                    </div>

                    <!-- NIK (READ-ONLY) -->
                    <div class="info-item">
                        <label class="info-label">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" class="info-input" value="{{ $profileUser->nik }}" readonly disabled>
                    </div>

                    <!-- Email (READ-ONLY) -->
                    <div class="info-item">
                        <label class="info-label">Alamat Email</label>
                        <input type="text" class="info-input" value="{{ $profileUser->email }}" readonly disabled>
                    </div>

                    <!-- No HP (EDITABLE) -->
                    <div class="info-item">
                        <label class="info-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="info-input" value="{{ old('no_hp', $profileUser->no_hp) }}" required>
                    </div>

                    <!-- Alamat Tinggal (EDITABLE, Full Width) -->
                    <div class="info-item info-item-full">
                        <label class="info-label">Alamat Tinggal</label>
                        <textarea name="alamat" class="info-input info-textarea" required>{{ old('alamat', $profileUser->alamat) }}</textarea>
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
