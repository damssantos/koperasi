@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Data Anggota')

@section('content')
    <!-- Page Header Title and Action buttons -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 pb-6 border-b border-[#1f243d]">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Data Anggota</h2>
            <p class="text-xs text-[#8f9bb3] mt-0.5">Manajemen keanggotaan dan simpanan pokok wajib koperasi.</p>
        </div>
        
        <!-- Action Buttons Group -->
        <div class="flex items-center gap-3">
            <button onclick="alert('Data anggota berhasil diunduh')" class="inline-flex items-center gap-2 px-3.5 py-1.5 border border-[#1f243d] rounded-lg bg-[#16192b] text-[#8f9bb3] hover:text-white hover:bg-[#1f243d] transition duration-150 text-xs font-semibold">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Unduh Data</span>
            </button>
            <button onclick="openNewMemberModal()" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg transition duration-150 text-xs font-bold shadow-md shadow-blue-500/10">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                <span>+ Tambah Anggota</span>
            </button>
        </div>
    </div>

    <!-- Metrics Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Metric Card 1: Total Members -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex items-center justify-between hover:border-[#8f9bb3]/20 transition duration-300">
            <div>
                <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Anggota Terdaftar</p>
                <h3 class="text-xl font-extrabold text-white mt-1.5" id="metric-total-members">1.248 Orang</h3>
                <p class="text-[9px] text-[#7c83a7] mt-1">Aktif berpartisipasi simpan pinjam</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center border border-blue-500/20 shadow-inner">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Metric Card 2: Total Simpanan Pokok -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex items-center justify-between hover:border-[#8f9bb3]/20 transition duration-300">
            <div>
                <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Simpanan Pokok</p>
                <h3 class="text-xl font-extrabold text-white mt-1.5" id="metric-total-pokok">Rp 124.800.000,00</h3>
                <p class="text-[9px] text-[#7c83a7] mt-1">Estimasi kas simpanan pokok awal</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center border border-emerald-500/20 shadow-inner">
                <i data-lucide="coins" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Metric Card 3: Pokok Lunas Dibayar -->
        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-5 flex items-center justify-between hover:border-[#8f9bb3]/20 transition duration-300">
            <div>
                <p class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Pokok Lunas Dibayar</p>
                <h3 class="text-xl font-extrabold text-white mt-1.5" id="metric-pokok-paid">Rp 120.000.000</h3>
                <p class="text-[9px] text-[#7c83a7] mt-1">Jumlah kas masuk dari 1.200 anggota</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center border border-purple-500/20 shadow-inner">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Data Table & Search controls Section -->
    <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 space-y-6">
        <!-- Search and Filter Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Search input -->
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" id="memberSearch" oninput="filterMembers()" placeholder="Cari nama, ID anggota, atau nomor HP..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Table Info / Quick Actions -->
            <p class="text-[10px] font-semibold text-[#8f9bb3] uppercase tracking-wider">Menampilkan Data Urutan Terbaru</p>
        </div>

        <!-- Members Table -->
        <div class="overflow-x-auto">
            <table id="membersTable" class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold w-[15%]">Tanggal Join</th>
                        <th class="py-3.5 px-4 font-semibold w-[15%]">ID Anggota</th>
                        <th class="py-3.5 px-4 font-semibold w-[25%]">Nama Lengkap</th>
                        <th class="py-3.5 px-4 font-semibold w-[20%]">Nomor HP</th>
                        <th class="py-3.5 px-4 font-semibold w-[20%]">Total Simpanan</th>
                        <th class="py-3.5 px-4 font-semibold text-center w-[5%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f243d]">
                    <!-- Row 1 -->
                    <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">12 Mar 2024</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-12093</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Budi Santoso</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 812-3456-7890</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 100.000,00</td>
                        <td class="py-4 px-4 text-center w-[5%]">
                            <button onclick="alert('Membuka profil detail Budi Santoso')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">10 Mar 2024</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-12092</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Siti Aminah</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 878-7654-3210</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 100.000,00</td>
                        <td class="py-4 px-4 text-center w-[5%]">
                            <button onclick="alert('Membuka profil detail Siti Aminah')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">08 Mar 2024</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-12091</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Andi Wijaya</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 856-9876-5432</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 100.000,00</td>
                        <td class="py-4 px-4 text-center w-[5%]">
                            <button onclick="alert('Membuka profil detail Andi Wijaya')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">05 Mar 2024</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-12090</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Rian Hidayat</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 821-2233-4455</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 100.000,00</td>
                        <td class="py-4 px-4 text-center w-[5%]">
                            <button onclick="alert('Membuka profil detail Rian Hidayat')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                        <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">01 Mar 2024</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-12089</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Diana Putri</td>
                        <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 838-5566-7788</td>
                        <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 100.000,00</td>
                        <td class="py-4 px-4 text-center w-[5%]">
                            <button onclick="alert('Membuka profil detail Diana Putri')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Empty Search State -->
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

    <!-- NEW MEMBER MODAL -->
    <div id="memberModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#07080f]/75 backdrop-blur-sm hidden transition-opacity">
        <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-2">
                <h3 class="text-base font-bold text-white">Tambah Anggota</h3>
                <button onclick="closeNewMemberModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Form Inputs -->
            <form id="memberForm" onsubmit="submitNewMember(event)" class="space-y-4">
                <!-- ID Anggota (Read Only/Disabled Field with icon inside) -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">ID Anggota</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8f9bb3]">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                        </span>
                        <input type="text" id="memberIdInput" disabled class="w-full bg-[#07080f]/60 border border-[#1f243d] rounded-lg pl-10 pr-4 py-2.5 text-xs text-[#8f9bb3] font-semibold focus:outline-none cursor-not-allowed">
                    </div>
                </div>

                <!-- Nama Lengkap * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Nama Lengkap <span class="text-rose-400">*</span></label>
                    <input type="text" id="memberName" required placeholder="Masukkan nama lengkap" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Nomor HP * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Nomor HP <span class="text-rose-400">*</span></label>
                    <input type="text" id="memberPhone" required placeholder="+62 8xxxxxxxxxx" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Tanggal Bergabung * -->
                <div>
                    <label class="block text-[10px] font-semibold text-[#8f9bb3] mb-1.5">Tanggal Bergabung <span class="text-rose-400">*</span></label>
                    <div class="relative">
                        <input type="date" id="memberJoinDate" required class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <!-- Simpanan Pokok Awal (Implicit for calculation data) -->
                <input type="hidden" id="memberPokok" value="100000">
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-4 justify-end">
                    <button type="button" onclick="closeNewMemberModal()" class="px-5 py-2.5 border border-[#1f243d] rounded-lg bg-transparent text-white text-xs font-semibold hover:bg-[#16192b] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-lg shadow-blue-500/10">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Local state variables for updating metrics
        let totalMembers = 1248;
        let totalPokok = 124800000;
        let paidPokok = 120000000;

        // Open/Close member modal
        function openNewMemberModal() {
            // Generate random AGT-xxxxx code
            const randomDigits = String(Math.floor(10000 + Math.random() * 90000));
            document.getElementById('memberIdInput').value = `AGT-${randomDigits}`;
            
            // Set default join date to today
            const todayDate = new Date().toISOString().split('T')[0];
            document.getElementById('memberJoinDate').value = todayDate;

            document.getElementById('memberModal').classList.remove('hidden');
        }

        document.getElementById('memberJoinDate').addEventListener('focus', function() {
            this.showPicker();
        });

        function closeNewMemberModal() {
            document.getElementById('memberModal').classList.add('hidden');
            document.getElementById('memberForm').reset();
        }

        // Instant Client-side Search row visibility
        function filterMembers() {
            const query = document.getElementById('memberSearch').value.toLowerCase();
            const rows = document.querySelectorAll('.member-row');
            let foundAny = false;

            rows.forEach(row => {
                const name = row.querySelector('.member-name').textContent.toLowerCase();
                const id = row.querySelector('.member-id').textContent.toLowerCase();
                const phone = row.querySelector('.member-phone').textContent.toLowerCase();

                const matchesQuery = name.includes(query) || id.includes(query) || phone.includes(query);

                if (matchesQuery) {
                    row.classList.remove('hidden');
                    foundAny = true;
                } else {
                    row.classList.add('hidden');
                }
            });

            const emptyState = document.getElementById('emptyState');
            if (foundAny) {
                emptyState.classList.add('hidden');
            } else {
                emptyState.classList.remove('hidden');
            }
        }

        // Form Submit handler
        function submitNewMember(event) {
            event.preventDefault();
            const name = document.getElementById('memberName').value;
            const idVal = document.getElementById('memberIdInput').value;
            const phone = document.getElementById('memberPhone').value;
            const joinDateVal = document.getElementById('memberJoinDate').value;
            const pokok = parseInt(document.getElementById('memberPokok').value);

            if (!name.trim()) {
                alert('Nama lengkap tidak boleh kosong.');
                return;
            }

            // Format display join date
            const dateParts = joinDateVal.split('-');
            let dateString = joinDateVal;
            if(dateParts.length === 3) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const day = parseInt(dateParts[2]);
                const monthIndex = parseInt(dateParts[1]) - 1;
                const year = dateParts[0];
                dateString = `${day} ${months[monthIndex]} ${year}`;
            }

            const formattedPokok = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(pokok);

            // Insert dynamic table row (Clean format with Nomor HP, left-aligned Total Simpanan, soft blue eye icon w-[5%] matching headers)
            const tbody = document.querySelector('#membersTable tbody');
            const newRow = document.createElement('tr');
            newRow.className = 'member-row hover:bg-[#07080f]/30 transition duration-150';
            newRow.innerHTML = `
                <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">${dateString}</td>
                <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">${idVal}</td>
                <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">${name}</td>
                <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">${phone}</td>
                <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">${formattedPokok},00</td>
                <td class="py-4 px-4 text-center w-[5%]">
                    <button onclick="alert('Membuka profil detail ${name}')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                        <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                    </button>
                </td>
            `;

            tbody.insertBefore(newRow, tbody.firstChild);
            lucide.createIcons();

            // Update Local Metrics
            totalMembers += 1;
            totalPokok += pokok;
            paidPokok += pokok;

            // Update DOM metrics labels
            document.getElementById('metric-total-members').textContent = totalMembers.toLocaleString('id-ID') + ' Orang';
            document.getElementById('metric-total-pokok').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalPokok);
            document.getElementById('metric-pokok-paid').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(paidPokok);

            // Close and notify
            closeNewMemberModal();
            alert(`Anggota Baru "${name}" berhasil disimpan!`);
        }
    </script>
@endsection
