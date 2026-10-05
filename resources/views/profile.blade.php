@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Profil Saya')

@section('styles')
<style>
    .profile-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-top: 24px;
        width: 100%;
        align-items: stretch;
    }

    @media (min-width: 1024px) {
        .profile-container {
            grid-template-columns: 320px 1fr;
        }
    }

    .profile-left-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        height: 100%;
    }

    .profile-card {
        background-color: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 28px 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        border-color: #BFDBFE;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.06);
    }

    @media (min-width: 1024px) {
        .profile-left-column .profile-card-fill {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    }

    .profile-avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid #FFFFFF;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
        background: #2563EB;
        position: relative;
    }

    .profile-avatar-circle span {
        font-size: 42px;
        font-weight: 800;
        color: #FFFFFF;
    }

    .profile-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 18px;
        margin-top: 20px;
    }

    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .info-item {
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-item-full {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-input {
        width: 100%;
        background-color: #FFFFFF;
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        padding: 10px 14px;
        color: #0F172A;
        font-size: 13.5px;
        font-weight: 600;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .info-input:focus {
        outline: none;
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .info-input[readonly],
    .info-input[disabled] {
        background-color: #F1F5F9;
        color: #64748B;
        cursor: not-allowed;
        border-color: #E2E8F0;
    }

    .info-textarea {
        min-height: 90px;
        resize: vertical;
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
    
    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="user" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Profil Saya</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Informasi akun dan data keanggotaan Anda di Koperasi.</p>
            </div>
        </div>
    </div>

    <!-- Main Profile Layout Container -->
    <div class="profile-container">
        
        <!-- Left Side: Profile Card & Account Status Card -->
        <div class="profile-left-column">
            <!-- Profile Overview Card -->
            <div class="profile-card flex flex-col items-center text-center">
                <div class="profile-avatar-circle mt-2">
                    @if($hasProfileAvatar)
                        <img src="{{ asset('storage/' . $profileAvatar) }}" alt="Avatar" class="profile-avatar-img">
                    @else
                        <span>{{ $profileInitial }}</span>
                    @endif
                </div>

                <div class="mt-4 space-y-1">
                    <h3 class="text-lg font-bold text-[#0F172A] tracking-tight leading-tight">{{ $profileUser->nama_lengkap }}</h3>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-bold tracking-wide rounded-full mt-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Akun Admin Aktif</span>
                    </div>
                </div>

                <!-- Profile quick specs list -->
                <div class="w-full mt-6 pt-5 border-t border-[#E2E8F0] space-y-3 text-left text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[#64748B] font-medium">NIK Pengelola:</span>
                        <span class="text-[#0F172A] font-bold">{{ $profileUser->nik ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#64748B] font-medium">Bergabung Sejak:</span>
                        <span class="text-[#0F172A] font-bold">{{ $profileUser->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Status Card -->
            <div class="profile-card profile-card-fill">
                <!-- Header -->
                <div class="flex items-center gap-3 border-b border-[#E2E8F0] pb-4 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#2563EB] flex items-center justify-center border border-blue-100 shrink-0">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-[#0F172A]">Status & Keamanan Akun</h4>
                    </div>
                </div>
                <!-- Content list -->
                <div class="text-xs space-y-3 flex-grow flex flex-col justify-center">
                    <div class="flex justify-between">
                        <span class="text-[#64748B] font-medium">Tipe Akun:</span>
                        <span class="text-[#0F172A] font-bold">Administrator Koperasi</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B] font-medium">Status Akun:</span>
                        <span class="text-emerald-600 font-bold">Aktif</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B] font-medium">Keamanan Sandi:</span>
                        <span class="text-[#0F172A] font-bold">Terlindungi (Enkripsi)</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B] font-medium">Terakhir Diperbarui:</span>
                        <span class="text-[#0F172A] font-bold">{{ $profileUser->updated_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Detailed Profile Information (FORM) -->
        <div class="profile-card">
            <!-- Information Card Header -->
            <div class="flex flex-col gap-1 border-b border-[#E2E8F0] pb-5 mb-4">
                <h3 class="text-base font-bold text-[#0F172A] tracking-tight">Informasi Akun</h3>
                <p class="text-xs text-[#64748B]">Detail data diri Anda yang terdaftar pada sistem koperasi.</p>
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

                    <!-- Nama Bank (EDITABLE) -->
                    <div class="info-item">
                        <label class="info-label">Nama Bank</label>
                        <select name="nama_bank" class="info-input">
                            <option value="">-- Pilih Bank --</option>
                            @foreach(['Bank Central Asia (BCA)', 'Bank Negara Indonesia (BNI)', 'Bank Rakyat Indonesia (BRI)', 'Bank Mandiri', 'Bank Tabungan Negara (BTN)', 'Bank Syariah Indonesia (BSI)', 'CIMB Niaga', 'Bank Danamon', 'Bank Permata', 'Bank OCBC', 'Bank Mega', 'Bank Panin', 'Maybank Indonesia', 'Bank Jago', 'SeaBank Indonesia', 'Bank Muamalat Indonesia', 'Bank Sinarmas', 'Bank BTPN / SMBC Indonesia', 'Bank Neo Commerce', 'Bank Raya Indonesia', 'Bank Aladin Syariah', 'Bank Victoria', 'Bank Woori Saudara'] as $bank)
                                <option value="{{ $bank }}" {{ old('nama_bank', $profileUser->nama_bank) == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                            @endforeach
                        </select>
                        @error('nama_bank')
                            <span class="text-rose-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nomor Rekening (EDITABLE) -->
                    <div class="info-item">
                        <label class="info-label">Nomor Rekening</label>
                        <input type="text" name="no_rekening" class="info-input" value="{{ old('no_rekening', $profileUser->no_rekening) }}" placeholder="Masukkan nomor rekening" inputmode="numeric">
                        @error('no_rekening')
                            <span class="text-rose-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alamat Tinggal (EDITABLE, Full Width) -->
                    <div class="info-item info-item-full">
                        <label class="info-label">Alamat Tinggal</label>
                        <textarea name="alamat" class="info-input info-textarea" required>{{ old('alamat', $profileUser->alamat) }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-5 py-2.5 bg-[#2563EB] hover:bg-[#1D4ED8] active:bg-blue-800 text-white rounded-xl text-xs font-bold transition duration-150 flex items-center gap-2 shadow-md shadow-blue-600/25 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
