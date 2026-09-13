<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Pengawas') - SOY YPIK PAM JAYA
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            margin: 0;
            background: #f5f5f5;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #050505;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #a1a1aa;
            text-decoration: none;
            transition: 0.2s;
        }

        .menu-item:hover {
            background: #18181b;
            color: white;
        }

        .menu-item.active {
            background: white;
            color: black;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <!-- LOGO -->
        <div class="px-5 py-6 border-b border-zinc-800">

            <div class="flex items-center gap-3">

                <img
                    src="{{ asset('images/logo-ypik.png') }}"
                    alt="SOY YPIK PAM JAYA"
                    class="w-10 h-10 object-contain"
                >

                <div>
                    <div class="font-bold text-sm">
                        SOY YPIK
                    </div>

                    <div class="text-xs text-zinc-500">
                        PAM JAYA
                    </div>
                </div>

            </div>

        </div>


        <!-- USER -->
        <div class="px-5 py-5 border-b border-zinc-800">

            <div class="text-xs text-zinc-500 mb-1">
                Login sebagai
            </div>

            <div class="font-semibold text-sm">
                {{ auth()->user()->nama_lengkap }}
            </div>

            <div class="text-xs text-zinc-500 mt-1">
                Pengawas
            </div>

        </div>


        <!-- MENU -->
        <nav class="px-4 py-6">

            <div class="text-[11px] uppercase tracking-wider text-zinc-600 px-3 mb-3">
                Monitoring
            </div>

            <a
                href="{{ route('pengawas.dashboard') }}"
                class="menu-item {{ request()->routeIs('pengawas.dashboard') ? 'active' : '' }}"
            >
                <span>📊</span>
                <span>Laporan</span>
            </a>

        </nav>


        <!-- LOGOUT -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-zinc-800">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="menu-item w-full text-left"
                >
                    <span>↪</span>
                    <span>Keluar</span>
                </button>

            </form>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="bg-white border-b border-zinc-200 px-8 py-5">

            <div>
                <h1 class="text-xl font-bold text-zinc-900">
                    @yield('page-title', 'Laporan')
                </h1>

                <p class="text-sm text-zinc-500 mt-1">
                    @yield(
                        'page-description',
                        'Monitoring dan melihat laporan koperasi.'
                    )
                </p>
            </div>

        </header>


        <!-- ALERT SUCCESS -->
        @if(session('success'))

            <div class="mx-8 mt-6 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                {{ session('success') }}
            </div>

        @endif


        <!-- ALERT ERROR -->
        @if(session('error'))

            <div class="mx-8 mt-6 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                {{ session('error') }}
            </div>

        @endif


        <!-- CONTENT -->
        <div class="p-8">

            @yield('content')

        </div>

    </main>


    @stack('scripts')

</body>
</html>