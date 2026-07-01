@extends('layouts.app')

@section('title', 'SOY YPIK PAM JAYA - Profil Saya')

@section('content')
    <!-- Page Header Title -->
    <div class="flex flex-col gap-1 pb-6 border-b border-[#1f243d]">
        <h2 class="text-2xl font-bold text-white tracking-tight">Pengaturan Profil</h2>
        <p class="text-xs text-[#8f9bb3]">Kelola informasi pribadi, detail akun, dan keamanan kata sandi Anda.</p>
    </div>

    <!-- Main Profile Layout Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
        
        <!-- Left Side: Profile Card & Quick Stats -->
        <div class="xl:col-span-1 space-y-6">
            <!-- Profile Overview Card -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-6 flex flex-col items-center text-center relative overflow-hidden group hover:border-[#8f9bb3]/20 transition duration-300">
                <!-- Decorative Blur Background -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>

                <!-- Avatar with edit indicator -->
                <div class="relative mt-4">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-xl shadow-blue-500/25 border-4 border-[#16192b]" style="background: linear-gradient(135deg, #2563eb, #4338ca);">
                        <span>{{ strtoupper(substr(trim(auth()->user()->nama_lengkap), 0, 1)) }}</span>
                    </div>
                    <button onclick="alert('Unggah foto profil baru')" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-[#2f54eb] hover:bg-blue-600 text-white flex items-center justify-center shadow-lg transition-transform hover:scale-110 active:scale-95 border-2 border-[#16192b]" title="Ubah Foto">
                        <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                    </button>
                </div>

                <div class="mt-5 space-y-1 z-10">
                    <h3 class="text-lg font-bold text-white tracking-tight">{{ auth()->user()->nama_lengkap }}</h3>
                    <p class="text-xs font-semibold text-[#8f9bb3]">Anggota Koperasi</p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 text-blue-400 text-[10px] font-bold tracking-wide rounded-full mt-2" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                        <span>Status Anggota Aktif</span>
                    </div>
                </div>

                <!-- Profile quick specs list -->
                <div class="w-full mt-8 pt-6 border-t border-[#1f243d] space-y-3.5 text-left text-xs">
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>NIK Anggota:</span>
                        <span class="text-white font-semibold">{{ auth()->user()->nik }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>Bergabung Sejak:</span>
                        <span class="text-white font-semibold">{{ auth()->user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[#8f9bb3]">
                        <span>Status Keanggotaan:</span>
                        <span class="font-bold px-2 py-0.5 rounded-md text-[10px]" style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399;">Aktif</span>
                    </div>
                </div>
            </div>


        </div>

        <!-- Right Side: Settings Forms tabs -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Form Card: General Info -->
            <div class="bg-[#16192b] border border-[#1f243d] rounded-2xl p-6 space-y-6">
                <div class="flex items-center gap-3 border-b border-[#1f243d] pb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center border border-blue-500/20">
                        <i data-lucide="user-cog" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Informasi Personal</h3>
                        <p class="text-[10px] text-[#8f9bb3]">Perbarui detail informasi akun Anda di sini.</p>
                    </div>
                </div>

                <form onsubmit="saveProfileInfo(event)" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" id="profileName" required value="{{ auth()->user()->nama_lengkap }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" id="profileNik" required value="{{ auth()->user()->nik }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Alamat Email</label>
                            <input type="email" id="profileEmail" required value="{{ auth()->user()->email }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Nomor HP</label>
                            <input type="text" id="profilePhone" required value="{{ auth()->user()->no_hp }}" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-[#8f9bb3] uppercase tracking-wider mb-2">Alamat Tinggal</label>
                        <textarea id="profileAddress" rows="3" class="w-full bg-[#07080f] border border-[#1f243d] rounded-lg px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500 resize-none">{{ auth()->user()->alamat }}</textarea>
                    </div>

                    <div class="flex items-center justify-end pt-2 border-t border-[#1f243d]">
                        <button type="submit" class="px-5 py-2.5 bg-[#2f54eb] hover:bg-blue-600 active:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-lg shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // Handle personal info saving
        function saveProfileInfo(event) {
            event.preventDefault();
            const name = document.getElementById('profileName').value;
            const email = document.getElementById('profileEmail').value;
            
            if(!name.trim() || !email.trim()) {
                alert('Nama dan Email wajib diisi.');
                return;
            }

            // Sync with navbar display
            const nameLabels = document.querySelectorAll('header span.text-slate-100, header span.text-white');
            nameLabels.forEach(label => {
                if(label.textContent.includes('{{ auth()->user()->nama_lengkap }}')) {
                    label.textContent = name + ' (Anggota Koperasi)';
                }
            });

            // Sync dropdown header name
            const dropdownHeaderName = document.querySelector('#profileDropdown p.text-white');
            if (dropdownHeaderName) {
                dropdownHeaderName.textContent = name;
            }

            alert('Informasi profil berhasil diperbarui!');
        }
    </script>
@endsection
