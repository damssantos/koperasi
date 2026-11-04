@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Pelunasan')

@section('content')
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-600/25 shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Pelunasan Pinjaman</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Kelola pelunasan pinjaman anggota yang masih aktif atau menunggak.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-[#E2E8F0] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
                        <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">No. Pinjaman</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Anggota</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Sisa (incl. Denda)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-[#64748B] uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse($pinjaman as $loan)
                        <tr class="hover:bg-[#F8FAFC] transition duration-150">
                            <td class="px-6 py-4 text-xs font-bold text-[#2563EB]">PJ-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-[#0F172A]">{{ $loan->anggota->nama ?? '-' }}</div>
                                <div class="text-[11px] text-[#64748B]">{{ $loan->anggota->id_anggota ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-[#0F172A]">{{ $loan->jumlah_cicilan_dibayar }} / {{ $loan->tenor }} bulan</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-extrabold text-[#0F172A]">Rp{{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</span>
                                @if($loan->denda > 0)
                                    <div class="text-[11px] font-bold text-rose-600">Denda: Rp{{ number_format($loan->denda, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $loan->status === 'Menunggak' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-blue-50 text-[#2563EB] border-blue-200' }}">
                                    {{ $loan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" onclick="openLunasModal({{ $loan->id }}, '{{ addslashes($loan->anggota->nama ?? '-') }}', {{ (int) $loan->sisa_pinjaman }})"
                                    class="px-3 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm">
                                    Proses Pelunasan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-xs text-[#64748B]">
                                Tidak ada pinjaman aktif atau menunggak.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL PELUNASAN --}}
    <div id="lunasModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-[#0F172A]">Proses Pelunasan</h3>
                    <p class="text-xs text-[#64748B] mt-0.5">Tandai pinjaman ini lunas penuh.</p>
                </div>
                <button type="button" onclick="closeLunasModal()" class="text-[#64748B] hover:text-[#0F172A] text-xl leading-none">×</button>
            </div>

            <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 mb-4 text-xs space-y-1">
                <div class="flex justify-between"><span class="text-[#64748B]">Anggota</span><strong id="lunasNama" class="text-[#0F172A]">-</strong></div>
                <div class="flex justify-between"><span class="text-[#64748B]">Total Pelunasan</span><strong id="lunasSisa" class="text-emerald-600">-</strong></div>
            </div>

            <form id="lunasForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-[11px] font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Bukti Pembayaran (opsional)</label>
                    <input type="file" name="bukti_transfer"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3 py-2 text-xs text-[#0F172A] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                    <p class="text-[11px] text-[#64748B] mt-1.5">Format JPG, JPEG, PNG atau WEBP. Maksimal 2MB.</p>
                </div>

                <div class="flex items-center gap-3 justify-end">
                    <button type="button" onclick="closeLunasModal()"
                        class="px-4 py-2 text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-white border border-[#E2E8F0] hover:bg-[#F8FAFC] rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-md shadow-emerald-600/20">
                        Konfirmasi Lunas
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const lunasUrl = @json(url('/pelunasan') . '/__ID__');

        function openLunasModal(id, nama, sisa) {
            document.getElementById('lunasForm').action = lunasUrl.replace('__ID__', id);
            document.getElementById('lunasNama').textContent = nama;
            document.getElementById('lunasSisa').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(sisa);
            document.getElementById('lunasModal').classList.remove('hidden');
            document.getElementById('lunasModal').classList.add('flex');
        }

        function closeLunasModal() {
            const m = document.getElementById('lunasModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
    </script>
@endsection
