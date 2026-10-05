@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Data Anggota')

@section('content')
    @php
        $formatRupiah = fn ($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
        $nextNumber = (int) ($anggota->map(fn ($item) => (int) preg_replace('/\D/', '', (string) $item->id_anggota))->max() ?? 0);
        $nextId = 'AGT-' . str_pad((string) ($nextNumber + 1), 3, '0', STR_PAD_LEFT);
    @endphp

    <!-- PAGE HEADER CARD (Matching Customer Design) -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shadow-md shadow-blue-600/25 shrink-0">
                <i data-lucide="users" class="w-6 h-6 text-white" stroke="white"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F172A] tracking-tight">Data Anggota</h1>
                <p class="text-xs sm:text-sm text-[#64748B] mt-0.5">Manajemen keanggotaan dan simpanan pokok wajib koperasi.</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('anggota.export') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-emerald-600/20">
                <i data-lucide="file-down" class="w-4 h-4"></i>
                <span>Export Excel</span>
            </a>

            <button type="button" onclick="openImportAnggotaModal()"
                class="inline-flex items-center gap-2 px-3.5 py-2 border border-[#E2E8F0] bg-white text-[#0F172A] hover:bg-[#F8FAFC] rounded-xl transition duration-150 text-xs font-bold shadow-sm cursor-pointer">
                <i data-lucide="upload" class="w-4 h-4 text-[#64748B]"></i>
                <span>Import Excel</span>
            </button>

            <button type="button" onclick="openNewMemberModal()" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-xl transition duration-150 text-xs font-bold shadow-md shadow-blue-600/25 cursor-pointer">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>+ Tambah Anggota</span>
            </button>
        </div>
    </div>

    <!-- MAIN CONTENT CARD -->
    <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 shadow-sm space-y-6">
        <!-- Search & Filter Controls -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" id="memberSearch" oninput="filterMembers()" placeholder="Cari nama, ID anggota, atau nomor HP..." class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB] transition duration-150">
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table id="membersTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold w-[20%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-bold w-[25%]">Nama Anggota</th>
                        <th class="py-3.5 px-4 font-bold w-[25%]">Nomor HP</th>
                        <th class="py-3.5 px-4 font-bold w-[20%]">Tanggal Bergabung</th>
                        <th class="py-3.5 px-4 font-bold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse($anggota as $item)
                        <tr class="member-row hover:bg-[#F8FAFC] transition duration-150">
                            <td class="py-4 px-4 text-xs font-semibold text-[#2563EB] member-id w-[20%]">
                                <span class="bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md text-xs">
                                    {{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs font-bold text-[#0F172A] member-name w-[25%]">{{ $item->nama }}</td>
                            <td class="py-4 px-4 text-xs text-[#64748B] member-phone w-[25%]">{{ $item->no_hp ?? '-' }}</td>
                            <td class="py-4 px-4 text-xs text-[#64748B] w-[20%]">{{ optional($item->tanggal_join ?? $item->created_at)->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-center w-[10%]">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('anggota.show', $item) }}" class="w-8 h-8 rounded-xl bg-blue-50 text-[#2563EB] border border-blue-200/80 flex items-center justify-center hover:bg-[#2563EB] hover:text-white transition-all duration-150 shadow-sm group" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-4 h-4 text-[#2563EB] group-hover:text-white"></i>
                                    </a>
                                    <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->nama) }}')" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-200/80 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all duration-150 cursor-pointer shadow-sm group" title="Hapus Anggota">
                                        <i data-lucide="trash-2" class="w-4 h-4 text-rose-600 group-hover:text-white"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="member-row">
                            <td colspan="5" class="py-10 px-4 text-center text-xs text-[#64748B]">Belum ada data anggota di database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Table Footer: Total Members Count -->
            <div id="tableFooter" class="flex justify-between items-center mt-5 pt-4 border-t border-[#E2E8F0]">
                <span class="text-xs font-semibold text-[#64748B]">
                    Total Anggota Terdaftar: <span id="memberCountText" class="text-[#0F172A] font-bold">{{ $anggota->count() }} Orang</span>
                </span>
            </div>

            <div id="emptyState" class="hidden py-12 flex flex-col items-center justify-center text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 border border-[#E2E8F0] text-[#64748B] flex items-center justify-center">
                    <i data-lucide="user-x" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-[#0F172A]">Anggota Tidak Ditemukan</p>
                    <p class="text-xs text-[#64748B]">Coba masukkan kata kunci pencarian yang lain.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 1: NEW MEMBER MODAL -->
    <div id="memberModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Tambah Anggota Baru</h3>
                <button onclick="closeMemberModal('memberModal')" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form action="{{ route('anggota.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">ID Anggota</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#64748B]">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                        </span>
                        <input type="text" id="memberIdInput" name="id_anggota" readonly value="{{ $nextId }}" class="w-full bg-[#F1F5F9] border border-[#E2E8F0] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[#64748B] font-bold focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required placeholder="Masukkan nama lengkap" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nomor HP <span class="text-rose-500">*</span></label>
                    <input type="text" name="no_hp" required placeholder="+62 8xxxxxxxxxx" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] placeholder-[#94A3B8] focus:outline-none focus:border-[#2563EB]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Tanggal Bergabung <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_join" required value="{{ now()->toDateString() }}" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                </div>

                <input type="hidden" name="simpanan_pokok" value="100000">
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#E2E8F0] justify-end">
                    <button type="button" onclick="closeMemberModal('memberModal')" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold transition shadow-md shadow-blue-600/25 cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT MEMBER MODAL -->
    <div id="editMemberModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A]">Ubah Data Anggota</h3>
                <button onclick="closeMemberModal('editMemberModal')" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="editMemberForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">ID Anggota</label>
                    <input type="text" id="edit_id_anggota" name="id_anggota" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" id="edit_nama" name="nama" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Nomor HP</label>
                    <input type="text" id="edit_no_hp" name="no_hp" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Tanggal Join</label>
                        <input type="date" id="edit_tanggal_join" name="tanggal_join" required class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Simpanan Pokok</label>
                        <input type="number" id="edit_simpanan_pokok" name="simpanan_pokok" min="0" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Simpanan Wajib</label>
                        <input type="number" id="edit_simpanan_wajib" name="simpanan_wajib" min="0" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Simpanan Sukarela</label>
                        <input type="number" id="edit_simpanan_sukarela" name="simpanan_sukarela" min="0" class="w-full bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#2563EB]">
                    </div>
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#E2E8F0] justify-end">
                    <button type="button" onclick="closeMemberModal('editMemberModal')" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold transition shadow-md shadow-blue-600/25 cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: IMPORT ANGGOTA MODAL -->
    <div id="importAnggotaModal" class="fixed inset-0 z-[99] hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-[#E2E8F0]">
                <div>
                    <h3 class="text-base font-extrabold text-[#0F172A]">Import Data Anggota</h3>
                    <p class="text-xs text-[#64748B] mt-0.5">Import data anggota menggunakan file Excel</p>
                </div>
                <button type="button" onclick="closeImportAnggotaModal()" class="text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-4 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl">
                <p class="text-xs font-bold text-[#2563EB]">Format Excel</p>
                <p class="text-xs text-[#64748B] mt-1">Gunakan template agar format kolom sesuai dengan sistem.</p>
                <a href="{{ route('anggota.template') }}" class="inline-flex items-center gap-2 mt-3 px-3.5 py-1.5 bg-[#2563EB] hover:bg-[#1D4ED8] text-white rounded-lg text-xs font-bold shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    Download Template
                </a>
            </div>

            <form action="{{ route('anggota.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#64748B] mb-1.5 uppercase tracking-wider">Pilih File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required class="block w-full text-xs text-[#64748B] bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#2563EB] file:text-white file:text-xs file:font-bold hover:file:bg-[#1D4ED8] focus:outline-none">
                    <p class="text-[10px] text-[#94A3B8] mt-1.5">Format: .xlsx atau .xls — maksimal 5 MB</p>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-[#E2E8F0] justify-end">
                    <button type="button" onclick="closeImportAnggotaModal()" class="px-5 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-xs font-bold transition shadow-md shadow-blue-600/25 cursor-pointer">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                        <span>Import Excel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: DELETE CONFIRMATION MODAL -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-white border border-[#E2E8F0] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5">
            <div class="text-center pb-2 relative border-b border-[#E2E8F0]">
                <h3 class="text-base font-extrabold text-[#0F172A] text-center">Hapus Anggota</h3>
                <button onclick="closeDeleteModal()" class="absolute right-0 top-0 text-[#64748B] hover:text-[#0F172A] transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="deleteMemberForm" method="POST" class="space-y-5 m-0 text-center flex flex-col items-center justify-center">
                @csrf
                @method('DELETE')
                
                <div class="flex flex-col items-center justify-center text-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500">
                        <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                    </div>
                    
                    <div class="space-y-1.5">
                        <p class="text-xs text-[#64748B]">Apakah Anda yakin ingin menghapus anggota <span id="deleteMemberNameText" class="text-[#0F172A] font-bold"></span>?</p>
                        <p class="text-xs text-rose-600 font-semibold">Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus secara permanen.</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 pt-3 border-t border-[#E2E8F0] justify-center w-full">
                    <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F1F5F9] text-[#475569] text-xs font-bold hover:bg-[#E2E8F0] transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-md shadow-rose-600/25 cursor-pointer">Hapus</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openImportAnggotaModal() {
            const modal = document.getElementById('importAnggotaModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImportAnggotaModal() {
            const modal = document.getElementById('importAnggotaModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openDeleteModal(id, name) {
            const form = document.getElementById('deleteMemberForm');
            form.action = `/anggota/${id}`;
            document.getElementById('deleteMemberNameText').textContent = name;
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        }

        function openNewMemberModal() {
            document.getElementById('memberModal').classList.remove('hidden');
        }

        function closeMemberModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditMemberModal(member) {
            const form = document.getElementById('editMemberForm');
            form.action = `/anggota/${member.id}`;
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

        function filterMembers() {
            const query = document.getElementById('memberSearch').value.toLowerCase();
            const rows = document.querySelectorAll('.member-row');
            let foundAny = false;
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('.member-name')?.textContent.toLowerCase() ?? '';
                const id = row.querySelector('.member-id')?.textContent.toLowerCase() ?? '';
                const phone = row.querySelector('.member-phone')?.textContent.toLowerCase() ?? '';
                const matchesQuery = name.includes(query) || id.includes(query) || phone.includes(query);

                row.classList.toggle('hidden', !matchesQuery);
                if (matchesQuery) {
                    visibleCount++;
                    foundAny = true;
                }
            });

            document.getElementById('emptyState').classList.toggle('hidden', foundAny);
            document.getElementById('memberCountText').textContent = `${visibleCount} Orang`;
        }
    </script>
@endsection