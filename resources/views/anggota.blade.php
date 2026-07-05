@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Data Anggota')

@section('content')
    @php
        $formatRupiah = fn ($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
        $nextNumber = (int) ($anggota->map(fn ($item) => (int) preg_replace('/\D/', '', (string) $item->id_anggota))->max() ?? 0);
        $nextId = 'AGT-' . str_pad((string) ($nextNumber + 1), 3, '0', STR_PAD_LEFT);
    @endphp

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Data Anggota</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Manajemen keanggotaan dan simpanan pokok wajib koperasi.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('anggota.print') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-1.5 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition duration-150 text-xs font-semibold">
                <i data-lucide="file-down" class="w-3.5 h-3.5"></i>
                <span>Unduh Data</span>
            </a>
            <button onclick="openNewMemberModal()" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                <span>+ Tambah Anggota</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex items-center justify-between hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div>
                <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Anggota Terdaftar</p>
                <h3 class="text-xl font-extrabold text-white mt-1.5">{{ number_format($totalAnggota, 0, ',', '.') }} Orang</h3>
                <p class="text-[9px] text-[#7c83a7] mt-1">Aktif berpartisipasi simpan pinjam</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-inner" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa;">
                <i data-lucide="users-2" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex items-center justify-between hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div>
                <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Simpanan Pokok</p>
                <h3 class="text-xl font-extrabold text-white mt-1.5">{{ $formatRupiah($totalPokok) }}</h3>
                <p class="text-[9px] text-[#7c83a7] mt-1">Estimasi kas simpanan pokok awal</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-inner" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">
                <i data-lucide="banknote" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex items-center justify-between hover:border-[#8f9bb3]/20 transition duration-300 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-purple-500/5 rounded-full blur-xl group-hover:bg-purple-500/10 transition-colors"></div>
            <div>
                <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Saldo Tercatat</p>
                <h3 class="text-xl font-extrabold text-white mt-1.5">{{ $formatRupiah($totalSaldo) }}</h3>
                <p class="text-[9px] text-[#7c83a7] mt-1">Akumulasi saldo anggota di database</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-inner" style="background-color: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); color: #a855f7;">
                <i data-lucide="badge-check" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" id="memberSearch" oninput="filterMembers()" placeholder="Cari nama, ID anggota, atau nomor HP..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
            </div>

            <p class="text-[10px] font-semibold text-[#8f9bb3] uppercase tracking-wider">Menampilkan Data Urutan Terbaru</p>
        </div>

        <div class="overflow-x-auto">
            <table id="membersTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Tanggal Join</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Nama Lengkap</th>
                        <th class="py-3.5 px-4 font-semibold w-[20%]">Nomor HP</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Total Simpanan</th>
                        <th class="py-3.5 px-4 font-semibold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    @forelse($anggota as $item)
                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">{{ optional($item->tanggal_join ?? $item->created_at)->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">{{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">{{ $item->nama }}</td>
                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">{{ $item->no_hp ?? '-' }}</td>
                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[15%]">{{ $formatRupiah($item->total_saldo ?: $item->simpanan_pokok) }}</td>
                            <td class="py-4 px-4 text-center w-[10%]">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button onclick='openViewMemberModal(@json($item))' class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-400 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button onclick='openEditMemberModal(@json($item))' class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-400 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Ubah Anggota">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="member-row">
                            <td colspan="6" class="py-10 px-4 text-center text-xs text-[#8f9bb3]">Belum ada data anggota di database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="emptyState" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-800/40 border border-slate-700/20 text-slate-400 flex items-center justify-center">
                    <i data-lucide="user-x" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Anggota Tidak Ditemukan</p>
                    <p class="text-xs text-[#8f9bb3]">Coba masukkan kata kunci pencarian yang lain.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="memberModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-2">
                <h3 class="text-base font-bold text-white">Tambah Anggota</h3>
                <button onclick="closeMemberModal('memberModal')" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form action="{{ route('anggota.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">ID Anggota</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                        </span>
                        <input type="text" id="memberIdInput" name="id_anggota" readonly value="{{ $nextId }}" class="w-full bg-[#07080f]/60 border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-[#8f9bb3] font-semibold focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Nama Lengkap <span class="text-rose-400">*</span></label>
                    <input type="text" name="nama" required placeholder="Masukkan nama lengkap" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Nomor HP <span class="text-rose-400">*</span></label>
                    <input type="text" name="no_hp" required placeholder="+62 8xxxxxxxxxx" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Tanggal Bergabung <span class="text-rose-400">*</span></label>
                    <input type="date" name="tanggal_join" required value="{{ now()->toDateString() }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                </div>

                <input type="hidden" name="simpanan_pokok" value="100000">
                
                <div class="flex items-center gap-3 pt-4 justify-end">
                    <button type="button" onclick="closeMemberModal('memberModal')" class="px-5 py-2.5 border border-[#1f243d] rounded-lg bg-transparent text-white text-xs font-semibold hover:bg-[#16192b] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-lg shadow-blue-500/10">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editMemberModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-2">
                <h3 class="text-base font-bold text-white">Ubah Anggota</h3>
                <button onclick="closeMemberModal('editMemberModal')" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editMemberForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">ID Anggota</label>
                    <input type="text" id="edit_id_anggota" name="id_anggota" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Nama Lengkap</label>
                    <input type="text" id="edit_nama" name="nama" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Nomor HP</label>
                    <input type="text" id="edit_no_hp" name="no_hp" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Tanggal Join</label>
                        <input type="date" id="edit_tanggal_join" name="tanggal_join" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Simpanan Pokok</label>
                        <input type="number" id="edit_simpanan_pokok" name="simpanan_pokok" min="0" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Simpanan Wajib</label>
                        <input type="number" id="edit_simpanan_wajib" name="simpanan_wajib" min="0" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Simpanan Sukarela</label>
                        <input type="number" id="edit_simpanan_sukarela" name="simpanan_sukarela" min="0" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                
                <div class="flex items-center gap-3 pt-4 justify-end">
                    <button type="button" onclick="closeMemberModal('editMemberModal')" class="px-5 py-2.5 border border-[#1f243d] rounded-lg bg-transparent text-white text-xs font-semibold hover:bg-[#16192b] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-lg shadow-blue-500/10">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Member Modal -->
    <div id="viewMemberModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-2xl w-full p-6 shadow-2xl space-y-4" style="background-color: #16192b; border: 1px solid #1f243d; border-radius: 1rem; max-width: 42rem; width: 100%; padding: 1.5rem;">
            <div class="flex justify-between items-center pb-2 border-b border-[#1f243d]" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; border-bottom: 1px solid #1f243d;">
                <h3 class="text-base font-bold text-white">Detail Anggota</h3>
                <button onclick="closeMemberModal('viewMemberModal')" class="text-slate-400 hover:text-white transition-colors" style="background: none; border: none; cursor: pointer;">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.5rem; align-items: stretch; padding-top: 0.5rem;">
                <!-- Left Column -->
                <div style="grid-column: span 1 / span 1; background-color: rgba(7, 8, 15, 0.4); border: 1px solid #1f243d; border-radius: 0.75rem; padding: 1.25rem; display: flex; flex-direction: column; align-items: center; text-align: center; position: relative; overflow: hidden; justify-content: space-between;">
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-xl"></div>
                    <div style="width: 64px; height: 64px; min-width: 64px; min-height: 64px; flex-shrink: 0; border-radius: 9999px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.25rem; font-weight: 700; border: 4px solid #16192b; background: linear-gradient(135deg, #2563eb, #4338ca);">
                        <span id="view_avatar_initial">A</span>
                    </div>
                    <div class="mt-4 space-y-1 z-10 w-full" style="width: 100%;">
                        <h4 id="view_nama" class="text-xs font-bold text-white tracking-tight truncate" style="color: #ffffff; font-weight: 700; font-size: 0.75rem; margin-top: 1rem; width: 100%; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">Nama</h4>
                        <p id="view_id_anggota" class="text-[9px] font-semibold text-[#8f9bb3]" style="color: #8f9bb3; font-weight: 600; font-size: 9px; margin-top: 0.25rem;">AGT-000</p>
                        <div style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; color: #34d399; font-size: 8px; font-weight: 700; border-radius: 9999px; background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); margin-top: 0.5rem;">
                            <span style="width: 4px; height: 4px; border-radius: 9999px; background-color: #34d399;"></span>
                            <span>Anggota Aktif</span>
                        </div>
                    </div>
                    <div class="w-full mt-5 pt-4 border-t border-[#1f243d] space-y-3 text-left text-[11px]" style="width: 100%; border-top: 1px solid #1f243d; padding-top: 1rem; margin-top: 1.25rem; text-align: left; font-size: 11px;">
                        <div class="flex flex-col gap-0.5" style="display: flex; flex-direction: column; gap: 2px;">
                            <span class="text-[8px] text-[#8f9bb3] uppercase font-bold tracking-wider" style="font-size: 8px; font-weight: 700; color: #8f9bb3; text-transform: uppercase;">Nomor HP</span>
                            <span id="view_no_hp" class="text-white font-semibold" style="color: #ffffff; font-weight: 600;">-</span>
                        </div>
                        <div class="flex flex-col gap-0.5" style="display: flex; flex-direction: column; gap: 2px; margin-top: 0.75rem;">
                            <span class="text-[8px] text-[#8f9bb3] uppercase font-bold tracking-wider" style="font-size: 8px; font-weight: 700; color: #8f9bb3; text-transform: uppercase;">Bergabung Pada</span>
                            <span id="view_tanggal_join" class="text-white font-semibold" style="color: #ffffff; font-weight: 600;">-</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="grid-column: span 2 / span 2; display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
                    <div style="background-color: rgba(7, 8, 15, 0.2); border: 1px solid #1f243d; border-radius: 0.75rem; padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; flex-grow: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; padding-bottom: 0.75rem; border-bottom: 1px solid #1f243d;">
                            <i data-lucide="wallet" class="w-3.5 h-3.5 text-blue-500"></i>
                            <h4 style="font-size: 10px; font-weight: 700; color: #ffffff; text-transform: uppercase; margin: 0; letter-spacing: 0.05em;">Rincian Simpanan Koperasi</h4>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px;">
                            <div style="background-color: rgba(7, 8, 15, 0.4); border: 1px solid #1f243d; border-radius: 0.5rem; padding: 0.75rem; display: flex; flex-direction: column; gap: 2px;">
                                <p style="font-size: 8px; font-weight: 700; color: #8f9bb3; text-transform: uppercase; margin: 0;">Pokok</p>
                                <p id="view_simpanan_pokok" style="font-size: 11px; font-weight: 700; color: #ffffff; margin: 0;">Rp 0</p>
                            </div>
                            <div style="background-color: rgba(7, 8, 15, 0.4); border: 1px solid #1f243d; border-radius: 0.5rem; padding: 0.75rem; display: flex; flex-direction: column; gap: 2px;">
                                <p style="font-size: 8px; font-weight: 700; color: #8f9bb3; text-transform: uppercase; margin: 0;">Wajib</p>
                                <p id="view_simpanan_wajib" style="font-size: 11px; font-weight: 700; color: #ffffff; margin: 0;">Rp 0</p>
                            </div>
                            <div style="background-color: rgba(7, 8, 15, 0.4); border: 1px solid #1f243d; border-radius: 0.5rem; padding: 0.75rem; display: flex; flex-direction: column; gap: 2px;">
                                <p style="font-size: 8px; font-weight: 700; color: #8f9bb3; text-transform: uppercase; margin: 0;">Sukarela</p>
                                <p id="view_simpanan_sukarela" style="font-size: 11px; font-weight: 700; color: #ffffff; margin: 0;">Rp 0</p>
                            </div>
                        </div>
                        <div style="background: linear-gradient(to right, rgba(37, 99, 235, 0.1), rgba(147, 51, 234, 0.1)); border: 1px solid rgba(37, 99, 235, 0.15); border-radius: 0.5rem; padding: 1rem; margin-top: 0.5rem;">
                            <p style="font-size: 9px; font-weight: 700; color: #8f9bb3; text-transform: uppercase; margin: 0;">Total Akumulasi Saldo</p>
                            <h3 id="view_total_saldo" style="font-size: 1rem; font-weight: 900; color: #ffffff; margin: 5px 0 0 0;">Rp 0</h3>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding-top: 0.5rem;">
                        <button onclick="closeMemberModal('viewMemberModal')" style="padding: 0.625rem 1.25rem; border: 1px solid #1f243d; border-radius: 0.5rem; background-color: transparent; color: #ffffff; font-size: 12px; font-weight: 600; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#16192b'" onmouseout="this.style.backgroundColor='transparent'">Tutup</button>
                        <button id="view_edit_button" style="padding: 0.625rem 1.25rem; background-color: #2f54eb; color: #ffffff; border: none; border-radius: 0.5rem; font-size: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2f54eb'">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Ubah Anggota</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openNewMemberModal() {
            document.getElementById('memberModal').classList.remove('hidden');
        }

        function closeMemberModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditMemberModal(member) {
            const form = document.getElementById('editMemberForm');
            form.action = `{{ url('/anggota') }}/${member.id}`;
            document.getElementById('edit_id_anggota').value = member.id_anggota ?? `AGT-${String(member.id).padStart(3, '0')}`;
            document.getElementById('edit_nama').value = member.nama ?? '';
            document.getElementById('edit_no_hp').value = member.no_hp ?? '';
            document.getElementById('edit_tanggal_join').value = member.tanggal_join ? member.tanggal_join.substring(0, 10) : new Date().toISOString().split('T')[0];
            document.getElementById('edit_simpanan_pokok').value = member.simpanan_pokok ?? 0;
            document.getElementById('edit_simpanan_wajib').value = member.simpanan_wajib ?? 0;
            document.getElementById('edit_simpanan_sukarela').value = member.simpanan_sukarela ?? 0;
            document.getElementById('editMemberModal').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const editId = new URLSearchParams(window.location.search).get('edit');
            if (!editId) return;

            const members = @json($anggota->keyBy('id'));
            if (members[editId]) {
                openEditMemberModal(members[editId]);
            }
        });

        function formatRupiahJs(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
        }

        function formatDateJs(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return `${String(date.getDate()).padStart(2, '0')} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        function openViewMemberModal(member) {
            const initial = member.nama ? member.nama.trim().charAt(0).toUpperCase() : 'A';
            document.getElementById('view_avatar_initial').textContent = initial;
            document.getElementById('view_nama').textContent = member.nama;
            
            const nextId = member.id_anggota ?? `AGT-${String(member.id).padStart(3, '0')}`;
            document.getElementById('view_id_anggota').textContent = nextId;
            document.getElementById('view_no_hp').textContent = member.no_hp ?? '-';
            document.getElementById('view_tanggal_join').textContent = formatDateJs(member.tanggal_join ?? member.created_at);
            
            document.getElementById('view_simpanan_pokok').textContent = formatRupiahJs(member.simpanan_pokok ?? 0);
            document.getElementById('view_simpanan_wajib').textContent = formatRupiahJs(member.simpanan_wajib ?? 0);
            document.getElementById('view_simpanan_sukarela').textContent = formatRupiahJs(member.simpanan_sukarela ?? 0);
            
            const total = (member.simpanan_pokok ?? 0) + (member.simpanan_wajib ?? 0) + (member.simpanan_sukarela ?? 0);
            document.getElementById('view_total_saldo').textContent = formatRupiahJs(member.total_saldo || total);
            
            const editBtn = document.getElementById('view_edit_button');
            editBtn.onclick = () => {
                closeMemberModal('viewMemberModal');
                setTimeout(() => {
                    openEditMemberModal(member);
                }, 200);
            };

            document.getElementById('viewMemberModal').classList.remove('hidden');
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        function filterMembers() {
            const query = document.getElementById('memberSearch').value.toLowerCase();
            const rows = document.querySelectorAll('.member-row');
            let foundAny = false;

            rows.forEach(row => {
                const name = row.querySelector('.member-name')?.textContent.toLowerCase() ?? '';
                const id = row.querySelector('.member-id')?.textContent.toLowerCase() ?? '';
                const phone = row.querySelector('.member-phone')?.textContent.toLowerCase() ?? '';
                const matchesQuery = name.includes(query) || id.includes(query) || phone.includes(query);

                row.classList.toggle('hidden', !matchesQuery);
                foundAny = foundAny || matchesQuery;
            });

            document.getElementById('emptyState').classList.toggle('hidden', foundAny);
        }
    </script>
@endsection
