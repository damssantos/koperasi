<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Anggota - SOY YPIK PAM JAYA</title>

        <!-- Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Fallback CDN Tailwind for easy rendering -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                            },
                        }
                    }
                }
            </script>
        @endif

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Lucide Icons CDN -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #0f111a;
            }
            .bg-page {
                background-color: #0f111a;
            }
            .bg-sidebar {
                background-color: #07080f;
            }
            .bg-card {
                background-color: #16192b;
            }
            .border-card {
                border-color: #1f243d;
            }
            .text-muted {
                color: #8f9bb3;
            }
            
            /* Sidebar and container transitions */
            aside {
                transition: width 0.3s ease, transform 0.3s ease;
            }
            #main-container {
                transition: padding-left 0.3s ease;
            }
            
            /* Sidebar collapsed state rules on Desktop */
            @media (min-width: 1024px) {
                .sidebar-collapsed aside {
                    width: 5rem; /* w-20 */
                }
                .sidebar-collapsed #main-container {
                    padding-left: 5rem; /* lg:pl-20 */
                }
                .sidebar-collapsed aside .logo-full {
                    display: none;
                }
                .sidebar-collapsed aside .logo-mini {
                    display: block;
                }
                .sidebar-collapsed aside nav a span {
                    display: none;
                }
                .sidebar-collapsed aside nav a {
                    justify-content: center;
                    padding-left: 0;
                    padding-right: 0;
                }
                .sidebar-collapsed aside .footer-full {
                    display: none;
                }
                .sidebar-collapsed aside .footer-mini {
                    display: block;
                }
            }

            /* Custom scrollbars for a premium dark mode feel */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: #0f111a;
            }
            ::-webkit-scrollbar-thumb {
                background: #1f243d;
                border-radius: 3px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #2b3152;
            }
        </style>
    </head>
    <body class="h-full text-slate-100 antialiased bg-[#0f111a]">
        
        <!-- TOP NAVBAR (Consistent with Dashboard Header Bar) -->
        <header class="h-16 bg-[#07080f] border-b border-[#1f243d] flex items-center justify-between px-6 w-full fixed top-0 left-0 z-50">
            <!-- Left side: Brand Logo and Minimize Toggle Button -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <!-- Circular Icon / Logo -->
                    <div class="w-8 h-8 rounded-full bg-[#2f54eb] flex items-center justify-center font-extrabold text-white text-xs shadow-md shadow-blue-500/25">
                        Y
                    </div>
                    <span class="text-sm font-bold tracking-wider text-white uppercase logo-full">SOY YPIK PAM JAYA</span>
                    <span class="text-sm font-bold tracking-wider text-blue-500 uppercase logo-mini hidden">YPIK</span>
                </div>
                
                <!-- Desktop Sidebar Collapse Toggle -->
                <button onclick="toggleSidebarCollapse()" class="hidden lg:flex text-slate-400 hover:text-white p-1.5 hover:bg-[#16192b] rounded-lg transition-colors" title="Perkecil Menu">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                
                <!-- Mobile Sidebar Toggle -->
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1.5 hover:bg-[#16192b] rounded-lg transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Right side: Mode Gelap, Language, User profile text -->
            <div class="flex items-center gap-5">
                <div class="hidden sm:flex items-center gap-2 text-xs text-[#8f9bb3] hover:text-white cursor-pointer transition-colors">
                    <i data-lucide="moon" class="w-4 h-4"></i>
                    <span>Mode Gelap</span>
                </div>
                <div class="hidden sm:flex items-center gap-2 text-xs text-[#8f9bb3] hover:text-white cursor-pointer transition-colors">
                    <i data-lucide="globe" class="w-4 h-4"></i>
                    <span>ID</span>
                </div>
                <span class="h-6 w-px bg-[#1f243d] hidden sm:block"></span>
                <div class="flex items-center gap-2.5">
                    <span class="text-xs font-bold text-white">Audy (IT Support)</span>
                </div>
            </div>
        </header>

        <div class="flex h-full min-h-screen pt-16">
            
            <!-- SIDEBAR -->
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-[#07080f] border-r border-[#1f243d] transition-transform duration-300 -translate-x-full lg:translate-x-0 pt-16">
                <!-- Navigation Menu -->
                <nav class="flex-1 space-y-1 px-3 py-6 overflow-y-auto">
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Dashboard</span>
                    </a>
                    
                    <a href="{{ url('/anggota') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-[#2f54eb] text-white transition-all duration-150 shadow-md shadow-blue-500/10">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Anggota</span>
                    </a>

                    <a href="#" onclick="showNotImplementedAlert('Simpanan')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
                        <i data-lucide="wallet" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Simpanan</span>
                    </a>

                    <a href="#" onclick="showNotImplementedAlert('Pinjaman')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
                        <i data-lucide="hand-coins" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Pinjaman</span>
                    </a>

                    <a href="#" onclick="showNotImplementedAlert('Kas Usaha')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
                        <i data-lucide="briefcase" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Kas Usaha</span>
                    </a>

                    <a href="#" onclick="showNotImplementedAlert('Pembukuan')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Pembukuan</span>
                    </a>

                    <a href="#" onclick="showNotImplementedAlert('Laporan')" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-[#8f9bb3] hover:text-white hover:bg-[#16192b] transition-all duration-150">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                        <span class="font-bold text-xs uppercase tracking-wider">Laporan</span>
                    </a>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-[#1f243d]">
                    <div class="footer-full flex items-center justify-between pt-1">
                        <span class="text-[10px] font-semibold text-[#8f9bb3] tracking-widest uppercase">VERSI WEB 1.1</span>
                        <button onclick="alert('Keluar dari sistem')" class="text-xs text-rose-400 hover:text-rose-300 font-semibold">Keluar</button>
                    </div>
                    
                    <div class="footer-mini hidden text-center">
                        <button onclick="alert('Keluar dari sistem')" class="text-rose-400 hover:text-rose-300">
                            <i data-lucide="log-out" class="w-4 h-4 mx-auto"></i>
                        </button>
                    </div>
                </div>
            </aside>

            <!-- MAIN CONTAINER -->
            <div id="main-container" class="flex-grow flex flex-col min-w-0 lg:pl-64">
                
                <!-- CONTENT WRAPPER -->
                <main class="flex-1 p-6 lg:p-8 space-y-8 w-full">
                    
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

                    <!-- Metrics Grid (3 Cards) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Card 1: Total Anggota Aktif -->
                        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 flex flex-col justify-between min-h-[130px] relative overflow-hidden group hover:border-[#8f9bb3]/30 transition-all duration-300">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                                    <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Total Anggota Aktif</span>
                                </div>
                                <h3 id="metric-total-members" class="text-2xl lg:text-3xl font-extrabold text-white mt-2 tracking-tight">1.248 Orang</h3>
                            </div>
                            <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                                <div>Laki-laki: <span id="metric-male-count" class="text-white font-bold">742</span></div>
                                <div class="w-1.5 h-1.5 rounded-full bg-[#1f243d]"></div>
                                <div>Perempuan: <span id="metric-female-count" class="text-white font-bold">506</span></div>
                            </div>
                        </div>

                        <!-- Card 2: Pengajuan Anggota Baru -->
                        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 flex flex-col justify-between min-h-[130px] relative overflow-hidden group hover:border-[#8f9bb3]/30 transition-all duration-300">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                    <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Pengajuan Baru</span>
                                </div>
                                <h3 class="text-2xl font-extrabold text-white mt-2 tracking-tight">12 Pengajuan</h3>
                            </div>
                            <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                                <div>Menunggu Persetujuan: <span class="text-white font-bold">8</span></div>
                                <div class="w-1.5 h-1.5 rounded-full bg-[#1f243d]"></div>
                                <div>Diproses: <span class="text-white font-bold">4</span></div>
                            </div>
                        </div>

                        <!-- Card 3: Total Simpanan Pokok Terkumpul -->
                        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6 flex flex-col justify-between min-h-[130px] relative overflow-hidden group hover:border-[#8f9bb3]/30 transition-all duration-300">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    <span class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider">Simpanan Pokok</span>
                                </div>
                                <h3 id="metric-total-pokok" class="text-2xl font-extrabold text-white mt-2 tracking-tight">Rp 124.800.000,00</h3>
                            </div>
                            <div class="mt-4 pt-3 border-t border-[#1f243d] flex items-center justify-between text-[10px] text-[#8f9bb3]">
                                <div>Terbayar: <span id="metric-pokok-paid" class="text-white font-bold">Rp 120.000.000</span></div>
                                <div class="w-1.5 h-1.5 rounded-full bg-[#1f243d]"></div>
                                <div>Tunggakan: <span class="text-white font-bold">Rp 4.800.000</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Section -->
                    <div class="space-y-6 pt-2">
                        <div class="flex items-center gap-3">
                            <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                            <h3 class="text-[10px] font-bold text-[#8f9bb3] uppercase tracking-widest">Daftar Anggota Koperasi</h3>
                            <span class="h-px bg-[#1f243d] flex-grow"></span>
                        </div>

                        <!-- Data List Card -->
                        <div class="bg-[#16192b] border border-[#1f243d] rounded-xl p-6">
                            
                            <!-- Search Bar -->
                            <div class="flex gap-4 justify-between items-center pb-6 border-b border-[#1f243d]">
                                <div class="relative w-full md:w-80">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#8f9bb3]">
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </span>
                                    <input type="text" id="memberSearch" oninput="filterMembers()" placeholder="Cari nama, nomor HP, atau nomor anggota..." class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg pl-9 pr-4 py-2 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>

                            <!-- Responsive Data Table (Evenly distributed and perfectly aligned) -->
                            <div class="overflow-x-auto mt-4">
                                <table class="w-full text-left border-collapse" id="membersTable">
                                    <thead>
                                        <tr class="border-b border-[#1f243d] text-[#8f9bb3] text-[10px] font-bold uppercase tracking-wider">
                                            <th class="py-3.5 px-4 font-semibold w-[15%]">Tanggal Gabung</th>
                                            <th class="py-3.5 px-4 font-semibold w-[15%]">No. Anggota</th>
                                            <th class="py-3.5 px-4 font-semibold w-[25%]">Nama Lengkap</th>
                                            <th class="py-3.5 px-4 font-semibold w-[20%]">Nomor HP</th>
                                            <th class="py-3.5 px-4 font-semibold w-[20%]">Total Simpanan</th>
                                            <th class="py-3.5 px-4 font-semibold text-center w-[5%]">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#1f243d]">
                                        <!-- Row 1 -->
                                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">12 Jan 2024</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-00101</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Budi Santoso</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 812-3456-7890</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 12.500.000,00</td>
                                            <td class="py-4 px-4 text-center w-[5%]">
                                                <button onclick="alert('Membuka profil detail Budi Santoso')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Row 2 -->
                                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">15 Jan 2024</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-00102</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Siti Aminah</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 813-9876-5432</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 8.400.000,00</td>
                                            <td class="py-4 px-4 text-center w-[5%]">
                                                <button onclick="alert('Membuka profil detail Siti Aminah')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Row 3 -->
                                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">02 Feb 2024</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-00103</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Andi Wijaya</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 815-5555-4321</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 15.000.000,00</td>
                                            <td class="py-4 px-4 text-center w-[5%]">
                                                <button onclick="alert('Membuka profil detail Andi Wijaya')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Row 4 -->
                                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">10 Feb 2024</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-00104</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Diana Putri</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 821-4444-8888</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 5.200.000,00</td>
                                            <td class="py-4 px-4 text-center w-[5%]">
                                                <button onclick="alert('Membuka profil detail Diana Putri')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Row 5 -->
                                        <tr class="member-row hover:bg-[#07080f]/30 transition duration-150">
                                            <td class="py-4 px-4 text-xs text-slate-300 w-[15%]">22 Feb 2024</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] font-medium member-id w-[15%]">AGT-00105</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-name w-[25%]">Ahmad Faisal</td>
                                            <td class="py-4 px-4 text-xs text-[#8f9bb3] member-phone w-[20%]">+62 856-7777-1234</td>
                                            <td class="py-4 px-4 text-xs font-bold text-white member-simpanan w-[20%]">Rp 3.000.000,00</td>
                                            <td class="py-4 px-4 text-center w-[5%]">
                                                <button onclick="alert('Membuka profil detail Ahmad Faisal')" class="text-blue-400/80 hover:text-blue-300 transition-colors p-1" title="Lihat Detail">
                                                    <i data-lucide="eye" class="w-4 h-4 mx-auto"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <!-- Empty state display -->
                                <div id="emptyState" class="hidden text-center py-12 space-y-3">
                                    <i data-lucide="user-x" class="w-12 h-12 text-[#8f9bb3] mx-auto opacity-55 animate-bounce"></i>
                                    <p class="text-sm font-semibold text-white">Anggota Tidak Ditemukan</p>
                                    <p class="text-xs text-[#8f9bb3]">Coba masukkan kata kunci pencarian yang lain.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
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

        <script>
            // Initialize Lucide Icons
            lucide.createIcons();

            // Local state variables for updating metrics
            let totalMembers = 1248;
            let totalPokok = 124800000;
            let paidPokok = 120000000;

            // Alert for unimplemented menu items
            function showNotImplementedAlert(menuName) {
                alert(`Halaman untuk menu "${menuName}" sedang dalam tahap pengembangan dan belum tersedia.`);
            }

            // Mobile Sidebar Toggle
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            }

            // Toggle Minimize Sidebar (Desktop Collapse)
            function toggleSidebarCollapse() {
                document.body.classList.toggle('sidebar-collapsed');
                lucide.createIcons();
            }

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
    </body>
</html>
