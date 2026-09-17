@extends('pengawas.layouts.app')

@section('title', 'Laporan Koperasi')

@section('content')

    <!-- Page Header Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Pusat Laporan</h1>
            <p class="text-xs text-gray-500 mt-1">Ringkasan berkas dan rekapitulasi data operasional koperasi.</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-white border border-gray-200 shadow-sm text-xs font-semibold text-gray-700">
            <i data-lucide="shield-check" class="w-4 h-4 text-[#2563EB]"></i>
            <span>Mode View Only</span>
        </div>
    </div>

    <!-- Quick Navigation to Reports -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Laporan Simpanan -->
        <a href="{{ route('pengawas.laporan.simpanan') }}"
            class="group bg-white border border-gray-200/80 rounded-2xl p-6 hover:border-[#2563EB] hover:shadow-md transition duration-200 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#2563EB] mb-4 group-hover:scale-105 transition-transform">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base group-hover:text-[#2563EB] transition-colors">
                    Laporan Simpanan
                </h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Data simpanan pokok, simpanan wajib, simpanan sukarela, serta total saldo seluruh anggota koperasi.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#2563EB] group-hover:translate-x-1 transition-transform">
                <span>Lihat Laporan</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>

        <!-- Laporan Pinjaman -->
        <a href="{{ route('pengawas.laporan.pinjaman') }}"
            class="group bg-white border border-gray-200/80 rounded-2xl p-6 hover:border-[#0EA5E9] hover:shadow-md transition duration-200 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0EA5E9] mb-4 group-hover:scale-105 transition-transform">
                    <i data-lucide="hand-coins" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base group-hover:text-[#0EA5E9] transition-colors">
                    Laporan Pinjaman
                </h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Data pinjaman, plafon pembiayaan, tenor angsuran, cicilan, serta sisa pinjaman anggota.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#0EA5E9] group-hover:translate-x-1 transition-transform">
                <span>Lihat Laporan</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>

        <!-- Kas Usaha -->
        <a href="{{ route('pengawas.laporan.kas-usaha') }}"
            class="group bg-white border border-gray-200/80 rounded-2xl p-6 hover:border-[#10B981] hover:shadow-md transition duration-200 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#10B981] mb-4 group-hover:scale-105 transition-transform">
                    <i data-lucide="briefcase" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base group-hover:text-[#10B981] transition-colors">
                    Kas Usaha
                </h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Monitoring arus kas operasional: seluruh penerimaan, pengeluaran, dan saldo kas terkini.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#10B981] group-hover:translate-x-1 transition-transform">
                <span>Lihat Kas Usaha</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>

    </div>

@endsection