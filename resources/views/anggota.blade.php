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
            <button onclick="openNewMemberModal()" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                <span>+ Tambah Anggota</span>
            </button>
        </div>
    </div>

    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 mt-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" id="memberSearch" oninput="filterMembers()" placeholder="Cari nama, ID anggota, atau nomor HP..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="membersTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold w-[20%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Nama Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Nomor HP</th>
                        <th class="py-3.5 px-4 font-semibold w-[20%]">Tanggal Bergabung</th>
                        <th class="py-3.5 px-4 font-semibold text-center w-[10%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    @forelse($anggota as $item)
                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[20%]">{{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">{{ $item->nama }}</td>
                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[25%]">{{ $item->no_hp ?? '-' }}</td>
                            <td class="py-4 px-4 text-xs text-slate-300 w-[20%]">{{ optional($item->tanggal_join ?? $item->created_at)->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-center w-[10%]">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('anggota.show', $item) }}" class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-200 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </a>
                                    <button onclick='openEditMemberModal(@json($item))' class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-200 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Ubah Anggota">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->nama) }}')" class="w-7 h-7 rounded-lg bg-slate-800/40 text-rose-500 hover:text-white border border-slate-700/20 flex items-center justify-center hover:bg-rose-600 hover:border-transparent transition-all duration-200 cursor-pointer" title="Hapus Anggota">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="member-row">
                            <td colspan="5" class="py-10 px-4 text-center text-xs text-[#8f9bb3]">Belum ada data anggota di database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Table Footer: Total Members Count -->
            <div id="tableFooter" class="flex justify-between items-center mt-5 pt-4 border-t border-[#1f243d]" style="text-align: left;">
                <span class="text-[10px] font-semibold text-[#8f9bb3]">
                    Total Anggota Terdaftar: <span id="memberCountText" class="text-white">{{ $anggota->count() }} Orang</span>
                </span>
            </div>

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

    <div id="memberModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-lg hidden transition-opacity">
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
                    <button type="button" onclick="closeMemberModal('memberModal')" class="btn-edit-cancel px-5 py-2.5 rounded-lg text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="btn-edit-save px-5 py-2.5 rounded-lg text-xs font-bold cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editMemberModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-lg hidden transition-opacity">
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
                    <button type="button" onclick="closeMemberModal('editMemberModal')" class="btn-edit-cancel px-5 py-2.5 rounded-lg text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="btn-edit-save px-5 py-2.5 rounded-lg text-xs font-bold cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Style for Modal Buttons to avoid JIT Compiler limitations -->
    <style>
        .btn-delete-cancel, .btn-edit-cancel {
            background-color: #334155 !important; /* slate-700 */
            color: #f1f5f9 !important; /* slate-100 */
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            transition: all 0.2s ease-in-out !important;
        }
        .btn-delete-cancel:hover, .btn-edit-cancel:hover {
            background-color: #475569 !important; /* slate-600 */
            color: #ffffff !important;
            transform: scale(1.03) !important;
        }
        .btn-delete-cancel:active, .btn-edit-cancel:active {
            transform: scale(0.97) !important;
        }
        
        .btn-delete-confirm {
            background-color: #dc2626 !important; /* red-600 */
            color: #ffffff !important;
            border: none !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3) !important;
        }
        .btn-delete-confirm:hover {
            background-color: #ef4444 !important; /* red-500 */
            transform: scale(1.03) !important;
        }
        .btn-delete-confirm:active {
            transform: scale(0.97) !important;
        }

        .btn-edit-save {
            background-color: #2f54eb !important; /* blue-600 */
            color: #ffffff !important;
            border: none !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 10px 15px -3px rgba(47, 84, 235, 0.3) !important;
        }
        .btn-edit-save:hover {
            background-color: #3b5bdb !important; /* brighter blue */
            transform: scale(1.03) !important;
        }
        .btn-edit-save:active {
            transform: scale(0.97) !important;
        }
    </style>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-lg hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-5" style="max-width: 448px; width: 100%;">
            <!-- Header -->
            <div class="text-center pb-2 relative">
                <h3 class="text-base font-bold text-white text-center">Hapus Anggota</h3>
                <button onclick="closeDeleteModal()" class="absolute right-0 top-0 text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="deleteMemberForm" method="POST" class="space-y-5 m-0 text-center flex flex-col items-center justify-center">
                @csrf
                @method('DELETE')
                
                <!-- Warning Icon & Text (Rata Tengah) -->
                <div class="flex flex-col items-center justify-center text-center space-y-4">
                    <i data-lucide="alert-triangle" class="w-20 h-20" style="color: #ef4444; stroke-width: 1.2;"></i>
                    
                    <div class="space-y-2">
                        <p class="text-xs text-[#8f9bb3] leading-relaxed">Apakah Anda yakin ingin menghapus anggota <span id="deleteMemberNameText" class="text-white font-bold"></span>?</p>
                        <p class="text-xs text-rose-400/90 font-medium leading-relaxed">Tindakan ini tidak dapat dibatalkan dan semua data transaksi terkait akan dihapus secara permanen.</p>
                    </div>
                </div>
                
                <!-- Buttons (Rata Tengah) -->
                <div class="flex items-center gap-3 pt-2 justify-center w-full">
                    <button type="button" onclick="closeDeleteModal()" class="btn-delete-cancel px-6 py-2.5 rounded-lg text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="btn-delete-confirm px-6 py-2.5 rounded-lg text-xs font-bold cursor-pointer">Hapus</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openDeleteModal(id, name) {
            const form = document.getElementById('deleteMemberForm');
            form.action = `{{ url('/anggota') }}/${id}`;
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
