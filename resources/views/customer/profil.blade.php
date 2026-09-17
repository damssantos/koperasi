@extends('customer.layouts.app')

@section('title', 'Profil')

@section('page-title', 'Profil Saya')

@section('page-description', 'Informasi akun dan data keanggotaan Anda')

@section('content')

    <style>
        .profile-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .profile-section h2 {
            font-size: 19px;
            margin-bottom: 20px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .profile-item {
            background: #f5f6f8;
            padding: 16px;
            border-radius: 10px;
        }

        .profile-item span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .profile-item strong {
            font-size: 15px;
        }

        @media (max-width: 700px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>


    {{-- DATA AKUN --}}

    <div class="profile-section">

        <h2>Informasi Akun</h2>

        <div class="profile-grid">

            <div class="profile-item">
                <span>Nama Lengkap</span>
                <strong>
                    {{ $user->nama_lengkap ?? '-' }}
                </strong>
            </div>

            <div class="profile-item">
                <span>Email</span>
                <strong>
                    {{ $user->email ?? '-' }}
                </strong>
            </div>

            <div class="profile-item">
                <span>No. HP</span>
                <strong>
                    {{ $user->no_hp ?? '-' }}
                </strong>
            </div>

            <div class="profile-item">
                <span>Alamat</span>
                <strong>
                    {{ $user->alamat ?? '-' }}
                </strong>
            </div>

        </div>

    </div>


    {{-- DATA ANGGOTA --}}

    <div class="profile-section">

        <h2>Data Keanggotaan</h2>

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
                    <span>Status</span>
                    <strong>
                        Aktif
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