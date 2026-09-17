@extends('pengawas.layouts.app')

@section('title', 'Laporan')

@section('page-title', 'Laporan Koperasi')

@section('page-description', 'Monitoring kondisi koperasi secara keseluruhan.')

@section('content')

    <div class="space-y-6">

        {{-- ============================= --}}
        {{-- RINGKASAN DATA --}}
        {{-- ============================= --}}

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- TOTAL ANGGOTA --}}
            <div class="bg-white rounded-2xl border border-zinc-200 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-zinc-500">
                            Total Anggota
                        </p>

                        <h2 class="text-2xl font-bold text-zinc-900 mt-2">
                            {{ number_format($totalAnggota, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                        👥
                    </div>

                </div>

                <p class="text-xs text-zinc-400 mt-4">
                    Seluruh anggota koperasi
                </p>

            </div>


            {{-- TOTAL SIMPANAN --}}
            <div class="bg-white rounded-2xl border border-zinc-200 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-zinc-500">
                            Total Simpanan
                        </p>

                        <h2 class="text-2xl font-bold text-zinc-900 mt-2">
                            Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                        💰
                    </div>

                </div>

                <p class="text-xs text-zinc-400 mt-4">
                    Total saldo simpanan anggota
                </p>

            </div>


            {{-- TOTAL PINJAMAN --}}
            <div class="bg-white rounded-2xl border border-zinc-200 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-zinc-500">
                            Total Pinjaman Aktif
                        </p>

                        <h2 class="text-2xl font-bold text-zinc-900 mt-2">
                            Rp {{ number_format($totalPinjamanAktif, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                        💳
                    </div>

                </div>

                <p class="text-xs text-zinc-400 mt-4">
                    Sisa pinjaman yang masih berjalan
                </p>

            </div>


            {{-- JUMLAH PINJAMAN --}}
            <div class="bg-white rounded-2xl border border-zinc-200 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-zinc-500">
                            Pinjaman Aktif
                        </p>

                        <h2 class="text-2xl font-bold text-zinc-900 mt-2">
                            {{ number_format($jumlahPinjamanAktif, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-zinc-100 flex items-center justify-center text-xl">
                        📋
                    </div>

                </div>

                <p class="text-xs text-zinc-400 mt-4">
                    Pinjaman yang sedang berjalan
                </p>

            </div>

        </div>


        {{-- ============================= --}}
        {{-- LAPORAN --}}
        {{-- ============================= --}}

        <div class="bg-white rounded-2xl border border-zinc-200">

            <div class="px-6 py-5 border-b border-zinc-200">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-lg font-bold text-zinc-900">
                            Laporan Koperasi
                        </h2>

                        <p class="text-sm text-zinc-500 mt-1">
                            Pilih laporan yang ingin Anda lihat.
                        </p>

                    </div>

                    <div class="text-xs px-3 py-2 rounded-lg bg-zinc-100 text-zinc-600">
                        Mode View Only
                    </div>

                </div>

            </div>


            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- LAPORAN SIMPANAN --}}
                <a href="{{ route('pengawas.laporan.simpanan') }}"
                    class="group border border-zinc-200 rounded-xl p-5 hover:border-zinc-400 hover:shadow-sm transition">

                    <div class="w-12 h-12 rounded-xl bg-zinc-100 flex items-center justify-center text-2xl mb-4">
                        💰
                    </div>

                    <h3 class="font-bold text-zinc-900">
                        Laporan Simpanan
                    </h3>

                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                        Melihat data dan transaksi simpanan anggota koperasi.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-zinc-700 group-hover:text-black">
                        Lihat laporan →
                    </div>

                </a>


                {{-- LAPORAN PINJAMAN --}}
                <a href="{{ route('pengawas.laporan.pinjaman') }}"
                    class="group border border-zinc-200 rounded-xl p-5 hover:border-zinc-400 hover:shadow-sm transition">

                    <div class="w-12 h-12 rounded-xl bg-zinc-100 flex items-center justify-center text-2xl mb-4">
                        💳
                    </div>

                    <h3 class="font-bold text-zinc-900">
                        Laporan Pinjaman
                    </h3>

                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                        Melihat data pinjaman, status, tenor, dan sisa pinjaman.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-zinc-700 group-hover:text-black">
                        Lihat laporan →
                    </div>

                </a>


                {{-- LAPORAN KEUANGAN --}}
                {{-- KAS USAHA --}}

                <a href="{{ route('pengawas.laporan.kas-usaha') }}"
                    class="group border border-zinc-200 rounded-xl p-5 hover:border-zinc-400 hover:shadow-sm transition">

                    <div class="w-12 h-12 rounded-xl bg-zinc-100 flex items-center justify-center text-2xl mb-4">
                        💰
                    </div>

                    <h3 class="font-bold text-zinc-900">
                        Kas Usaha
                    </h3>

                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                        Melihat pemasukan, pengeluaran, dan kondisi kas usaha.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-zinc-700 group-hover:text-black">
                        Lihat Kas Usaha →
                    </div>

                </a>

            </div>

        </div>


        {{-- ============================= --}}
        {{-- INFORMASI PENGAWAS --}}
        {{-- ============================= --}}

        <div class="bg-zinc-900 rounded-2xl p-6 text-white">

            <div class="flex items-start gap-4">

                <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl flex-shrink-0">
                    🛡️
                </div>

                <div>

                    <h3 class="font-bold text-base">
                        Akses Pengawas
                    </h3>

                    <p class="text-sm text-zinc-400 mt-2 leading-relaxed">
                        Akun Pengawas memiliki hak akses baca saja.
                        Pengawas dapat melihat laporan koperasi,
                        tetapi tidak dapat menambah, mengubah,
                        menghapus, atau menyetujui data.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection