@extends('customer.layouts.app')

@section('title', 'Profil')

@section('page-title', 'Profil Saya')

@section('page-description', 'Informasi akun dan data keanggotaan Anda')

@section('content')

    <style>
        .profile-section {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.03);
        }

        .profile-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .profile-item {
            background: #F8FAFC;
            padding: 16px 18px;
            border-radius: 12px;
            border: 1px solid #F1F5F9;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-item.full-width {
            grid-column: 1 / -1;
        }

        .profile-item span {
            display: block;
            color: #64748B;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-item strong {
            font-size: 15px;
            font-weight: 700;
            color: #1F2937;
        }

        .profile-input {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            font-size: 14px;
            font-weight: 600;
            color: #1F2937;
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            font-family: inherit;
        }

        textarea.profile-input {
            height: auto;
            min-height: 85px;
            padding: 12px 14px;
            resize: vertical;
        }

        .profile-input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .profile-input[readonly] {
            background-color: #F1F5F9;
            color: #64748B;
            cursor: not-allowed;
            border-color: #E2E8F0;
        }

        .btn-submit {
            background-color: #2563EB;
            color: #FFFFFF;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s, transform 0.1s;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:hover {
            background-color: #1D4ED8;
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        @media (max-width: 700px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    {{-- DATA AKUN --}}

    <div class="profile-section">

        <h2>
            <i data-lucide="user-check" style="width: 20px; height: 20px; color: #2563EB;"></i>
            <span>Informasi Akun</span>
        </h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="profile-grid">

                {{-- Row 1: Nama Lengkap & Email --}}
                <div class="profile-item">
                    <span>Nama Lengkap</span>
                    <input type="text" class="profile-input" value="{{ $user->nama_lengkap ?? '-' }}" readonly>
                </div>

                <div class="profile-item">
                    <span>Email</span>
                    <input type="text" class="profile-input" value="{{ $user->email ?? '-' }}" readonly>
                </div>

                {{-- Row 2: NIK & No. HP --}}
                <div class="profile-item">
                    <span>NIK (Nomor Induk Kependudukan)</span>
                    <input type="text" class="profile-input" value="{{ $user->nik ?? '-' }}" readonly>
                </div>

                <div class="profile-item">
                    <span>No. HP</span>
                    <input type="text" name="no_hp" class="profile-input" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Masukkan Nomor HP" required>
                </div>

                {{-- Row 3: Nama Bank & No. Rekening --}}
                <div class="profile-item">
                    <span>Nama Bank</span>
                    <select name="nama_bank" class="profile-input">
                        <option value="">-- Pilih Bank --</option>
                        @foreach(['Bank Central Asia (BCA)', 'Bank Negara Indonesia (BNI)', 'Bank Rakyat Indonesia (BRI)', 'Bank Mandiri', 'Bank Tabungan Negara (BTN)', 'Bank Syariah Indonesia (BSI)', 'CIMB Niaga', 'Bank Danamon', 'Bank Permata', 'Bank OCBC', 'Bank Mega', 'Bank Panin', 'Maybank Indonesia', 'Bank Jago', 'SeaBank Indonesia', 'Bank Muamalat Indonesia', 'Bank Sinarmas', 'Bank BTPN / SMBC Indonesia', 'Bank Neo Commerce', 'Bank Raya Indonesia', 'Bank Aladin Syariah', 'Bank Victoria', 'Bank Woori Saudara'] as $bank)
                            <option value="{{ $bank }}" {{ old('nama_bank', $user->nama_bank) == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="profile-item">
                    <span>No. Rekening</span>
                    <input type="text" name="no_rekening" class="profile-input" value="{{ old('no_rekening', $user->no_rekening) }}" placeholder="Masukkan nomor rekening" inputmode="numeric">
                </div>

                {{-- Row 4: Alamat (Full Width) --}}
                <div class="profile-item full-width">
                    <span>Alamat</span>
                    <textarea name="alamat" class="profile-input" required>{{ old('alamat', $user->alamat) }}</textarea>
                </div>

            </div>

            <div style="margin-top: 22px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-submit">
                    <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

    </div>


    {{-- DATA ANGGOTA --}}

    <div class="profile-section">

        <h2>
            <i data-lucide="shield-check" style="width: 20px; height: 20px; color: #2563EB;"></i>
            <span>Data Keanggotaan</span>
        </h2>

        @if($anggota)

            <div class="profile-grid">

                <div class="profile-item">
                    <span>ID Anggota</span>
                    <strong>
                        {{ $anggota->id_anggota ?? '-' }}
                    </strong>
                </div>

                <div class="profile-item">
                    <span>Nama Anggota</span>
                    <strong>
                        {{ $anggota->nama ?? '-' }}
                    </strong>
                </div>

                <div class="profile-item">
                    <span>Tanggal Bergabung</span>
                    <strong>
                        {{ $anggota->tanggal_join
                ? $anggota->tanggal_join->format('d F Y')
                : '-' }}
                    </strong>
                </div>

                <div class="profile-item">
                    <span>Status Keanggotaan</span>
                    <strong style="color: #10B981;">
                        Aktif
                    </strong>
                </div>

                <div class="profile-item full-width">
                    <span>No. Rekening / Bank</span>
                    <strong>
                        @if($user->no_rekening)
                            {{ $user->nama_bank ? $user->nama_bank . ' - ' : '' }}{{ $user->no_rekening }}
                        @else
                            -
                        @endif
                    </strong>
                </div>

            </div>

        @else

            <p style="color:#777;">
                Data anggota belum terhubung dengan akun Anda.
            </p>

        @endif

    </div>

@endsection