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
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Tanggal Join</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Nama Lengkap</th>
                        <th class="py-3.5 px-4 font-semibold w-[20%]">Nomor HP</th>
                        <th class="py-3.5 px-4 font-semibold w-[13%]">Total Simpanan</th>
                        <th class="py-3.5 px-4 font-semibold text-center w-[12%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    @forelse($anggota as $item)
                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">{{ optional($item->tanggal_join ?? $item->created_at)->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">{{ $item->id_anggota ?? 'AGT-' . str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">{{ $item->nama }}</td>
                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">{{ $item->no_hp ?? '-' }}</td>
                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[13%]">{{ $formatRupiah($item->total_saldo ?: $item->simpanan_pokok) }}</td>
                            <td class="py-4 px-4 text-center w-[12%]">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('anggota.show', $item) }}" class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-400 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </a>
                                    <button onclick='openEditMemberModal(@json($item))' class="w-7 h-7 rounded-lg bg-slate-800/40 text-slate-400 border border-slate-700/20 flex items-center justify-center hover:bg-[#2f54eb] hover:text-white hover:border-transparent transition-all duration-200" title="Ubah Anggota">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <form action="{{ route('anggota.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-slate-800/40 text-rose-500 hover:text-white border border-slate-700/20 flex items-center justify-center hover:bg-rose-600 hover:border-transparent transition-all duration-200 cursor-pointer" title="Hapus Anggota">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
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
