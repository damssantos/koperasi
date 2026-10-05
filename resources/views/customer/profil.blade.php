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

        select.profile-input {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748B' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px 16px;
            padding-right: 40px;
            cursor: pointer;
        }

        /* =========================
           CUSTOM SELECT COMPONENT
        ========================= */
        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            width: 100%;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 14px;
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #1F2937;
            cursor: pointer;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            font-family: inherit;
            text-align: left;
        }

        .custom-select-trigger:hover {
            border-color: #94A3B8;
        }

        .custom-select-trigger:focus,
        .custom-select-wrapper.is-open .custom-select-trigger {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .custom-select-value {
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 8px;
            font-weight: 600;
            color: #1F2937;
        }

        .custom-select-value.is-placeholder {
            color: #94A3B8;
            font-weight: 500;
        }

        .custom-select-arrow {
            color: #64748B;
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease;
            flex-shrink: 0;
        }

        .custom-select-wrapper.is-open .custom-select-arrow {
            transform: rotate(180deg);
            color: #2563EB;
        }

        .custom-select-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.15), 0 10px 15px -5px rgba(15, 23, 42, 0.08);
            z-index: 100;
            max-height: 250px;
            overflow-y: auto;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(0.98);
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .custom-select-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .custom-select-dropdown::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }

        .custom-select-wrapper.is-open .custom-select-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .custom-select-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            font-size: 13.5px;
            font-weight: 500;
            color: #334155;
            gap: 10px;
        }

        .custom-select-option:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .custom-select-option.is-selected {
            background: #EFF6FF;
            color: #2563EB;
            font-weight: 700;
        }

        .custom-select-check {
            width: 16px;
            height: 16px;
            color: #2563EB;
            opacity: 0;
            transform: scale(0.6);
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .custom-select-option.is-selected .custom-select-check {
            opacity: 1;
            transform: scale(1);
        }

        .visually-hidden-select {
            position: absolute !important;
            opacity: 0 !important;
            width: 1px !important;
            height: 1px !important;
            top: 20px !important;
            left: 20px !important;
            pointer-events: none !important;
            clip: rect(0, 0, 0, 0) !important;
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
                    <div class="custom-select-wrapper" id="customBankWrapper">
                        <select name="nama_bank" id="nama_bank" class="visually-hidden-select" tabindex="-1">
                            <option value="">-- Pilih Bank --</option>
                            @foreach(['Bank Central Asia (BCA)', 'Bank Negara Indonesia (BNI)', 'Bank Rakyat Indonesia (BRI)', 'Bank Mandiri', 'Bank Tabungan Negara (BTN)', 'Bank Syariah Indonesia (BSI)', 'CIMB Niaga', 'Bank Danamon', 'Bank Permata', 'Bank OCBC', 'Bank Mega', 'Bank Panin', 'Maybank Indonesia', 'Bank Jago', 'SeaBank Indonesia', 'Bank Muamalat Indonesia', 'Bank Sinarmas', 'Bank BTPN / SMBC Indonesia', 'Bank Neo Commerce', 'Bank Raya Indonesia', 'Bank Aladin Syariah', 'Bank Victoria', 'Bank Woori Saudara'] as $bank)
                                <option value="{{ $bank }}" {{ old('nama_bank', $user->nama_bank) == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                            @endforeach
                        </select>

                        <button type="button" class="custom-select-trigger" id="customBankTrigger" aria-haspopup="listbox" aria-expanded="false">
                            <span class="custom-select-value {{ old('nama_bank', $user->nama_bank) ? '' : 'is-placeholder' }}" id="customBankValue">
                                {{ old('nama_bank', $user->nama_bank) ?: '-- Pilih Bank --' }}
                            </span>
                            <svg class="custom-select-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>

                        <div class="custom-select-dropdown" id="customBankDropdown" role="listbox">
                            <div class="custom-select-option {{ !old('nama_bank', $user->nama_bank) ? 'is-selected' : '' }}" data-value="">
                                <span>-- Pilih Bank --</span>
                                <svg class="custom-select-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            @foreach(['Bank Central Asia (BCA)', 'Bank Negara Indonesia (BNI)', 'Bank Rakyat Indonesia (BRI)', 'Bank Mandiri', 'Bank Tabungan Negara (BTN)', 'Bank Syariah Indonesia (BSI)', 'CIMB Niaga', 'Bank Danamon', 'Bank Permata', 'Bank OCBC', 'Bank Mega', 'Bank Panin', 'Maybank Indonesia', 'Bank Jago', 'SeaBank Indonesia', 'Bank Muamalat Indonesia', 'Bank Sinarmas', 'Bank BTPN / SMBC Indonesia', 'Bank Neo Commerce', 'Bank Raya Indonesia', 'Bank Aladin Syariah', 'Bank Victoria', 'Bank Woori Saudara'] as $bank)
                                <div class="custom-select-option {{ old('nama_bank', $user->nama_bank) == $bank ? 'is-selected' : '' }}" data-value="{{ $bank }}">
                                    <span>{{ $bank }}</span>
                                    <svg class="custom-select-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('customBankWrapper');
            const select = document.getElementById('nama_bank');
            const trigger = document.getElementById('customBankTrigger');
            const valueEl = document.getElementById('customBankValue');
            const dropdown = document.getElementById('customBankDropdown');

            if (wrapper && trigger && select && valueEl && dropdown) {
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = wrapper.classList.toggle('is-open');
                    trigger.setAttribute('aria-expanded', isOpen);
                });

                const options = dropdown.querySelectorAll('.custom-select-option');
                options.forEach(function (opt) {
                    opt.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const val = this.getAttribute('data-value');
                        const text = this.querySelector('span') ? this.querySelector('span').textContent.trim() : val;

                        select.value = val;
                        valueEl.textContent = text;
                        if (val) {
                            valueEl.classList.remove('is-placeholder');
                        } else {
                            valueEl.classList.add('is-placeholder');
                        }

                        options.forEach(function (o) { o.classList.remove('is-selected'); });
                        this.classList.add('is-selected');

                        wrapper.classList.remove('is-open');
                        trigger.setAttribute('aria-expanded', 'false');
                        select.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                });

                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) {
                        wrapper.classList.remove('is-open');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        wrapper.classList.remove('is-open');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>

@endsection