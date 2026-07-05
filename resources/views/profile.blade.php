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
        align-items: stretch;
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
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
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
        gap: 24px !important;
        row-gap: 24px !important;
        column-gap: 24px !important;
    }

    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 11px;
        font-weight: 600;
        color: #8f9bb3;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-input {
        width: 100%;
        background-color: #07080f;
        border: 1px solid #1f243d;
        border-radius: 10px;
        padding: 12px 16px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 500;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #2f54eb;
        box-shadow: 0 0 0 2px rgba(47, 84, 237, 0.15);
        background-color: #0d0f1a;
    }

    .form-input[readonly],
    .form-input[disabled] {
        background-color: rgba(7, 8, 15, 0.4);
        color: #64748b;
        cursor: not-allowed;
        border-color: #1f243d;
        opacity: 0.7;
    }

    .form-textarea {
        min-height: 120px;
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

    body.light .form-input {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    body.light .form-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        background-color: #ffffff;
    }

    body.light .form-input[readonly],
    body.light .form-input[disabled] {
        background-color: #f1f5f9;
        color: #94a3b8;
        border-color: #cbd5e1;
    }

    body.light .form-label {
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
        <div>
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

                <!-- Profile quick specs list (pushed to bottom using margin-top: auto) -->
                <div class="w-full mt-auto pt-6 border-t border-[#1f243d] space-y-4 text-left text-xs z-10" style="border-top: 1px solid #1f243d; margin-top: auto; padding-top: 24px;">
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

            <form action="{{ route('profile.update') }}" method="POST" style="flex-grow: 1; display: flex; flex-direction: column;">
                @csrf
                @method('PUT')

                <!-- Info Grid -->
                <div class="info-grid">
                    <!-- Nama Lengkap (READ-ONLY) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i data-lucide="user-check" class="w-3.5 h-3.5 text-[#8f9bb3]"></i>
                            <span>Nama Lengkap</span>
                            <i data-lucide="lock" class="w-3 h-3 text-[#8f9bb3]" title="Data ini terkunci"></i>
                        </label>
                        <input type="text" class="form-input" value="{{ $profileUser->nama_lengkap }}" readonly disabled>
                    </div>

                    <!-- NIK (READ-ONLY) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i data-lucide="credit-card" class="w-3.5 h-3.5 text-[#8f9bb3]"></i>
                            <span>NIK (Nomor Induk Kependudukan)</span>
                            <i data-lucide="lock" class="w-3 h-3 text-[#8f9bb3]" title="Data ini terkunci"></i>
                        </label>
                        <input type="text" class="form-input" value="{{ $profileUser->nik }}" readonly disabled>
                    </div>

                    <!-- Email (READ-ONLY) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-[#8f9bb3]"></i>
                            <span>Alamat Email</span>
                            <i data-lucide="lock" class="w-3 h-3 text-[#8f9bb3]" title="Data ini terkunci"></i>
                        </label>
                        <input type="text" class="form-input" value="{{ $profileUser->email }}" readonly disabled>
                    </div>

                    <!-- No HP (EDITABLE) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-blue-500"></i>
                            <span>Nomor HP</span>
                            <i data-lucide="edit-2" class="w-3 h-3 text-blue-400" title="Bisa diubah"></i>
                        </label>
                        <input type="text" name="no_hp" class="form-input" value="{{ old('no_hp', $profileUser->no_hp) }}" required placeholder="Masukkan nomor handphone aktif">
                    </div>

                    <!-- Alamat Tinggal (EDITABLE, Full Width) -->
                    <div class="form-group form-group-full">
                        <label class="form-label">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-500"></i>
                            <span>Alamat Tinggal</span>
                            <i data-lucide="edit-2" class="w-3 h-3 text-blue-400" title="Bisa diubah"></i>
                        </label>
                        <textarea name="alamat" class="form-input form-textarea" required placeholder="Masukkan alamat tinggal lengkap Anda">{{ old('alamat', $profileUser->alamat) }}</textarea>
                    </div>
                </div>

                <!-- Submit Button (pushed to bottom using margin-top: auto) -->
                <div class="flex justify-end mt-auto pt-8">
                    <button type="submit" class="px-6 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition duration-150 flex items-center gap-2 shadow-md shadow-blue-500/10">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
