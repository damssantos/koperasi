<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard Customer') - SOY YPIK PAM JAYA
    </title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #222;
        }

        /* =========================================
           LAYOUT
        ========================================= */

        .layout {
            display: flex;
            min-height: 100vh;
        }


        /* =========================================
           SIDEBAR
        ========================================= */

        .sidebar {
            width: 250px;
            height: 100vh;

            position: fixed;
            left: 0;
            top: 0;

            background: #111111;
            color: white;

            padding: 25px 18px;

            display: flex;
            flex-direction: column;

            overflow-y: auto;
        }


        /* =========================================
           LOGO
        ========================================= */

        .logo {
            padding: 5px 12px 30px;

            font-size: 20px;
            font-weight: bold;

            line-height: 1.4;
        }

        .subtitle {
            display: block;

            font-size: 11px;
            font-weight: normal;

            color: #999;

            margin-top: 3px;
        }


        /* =========================================
           MENU
        ========================================= */

        .menu {
            display: flex;
            flex-direction: column;

            gap: 6px;
        }

        .menu-title {
            color: #666;

            font-size: 11px;
            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: 1px;

            padding: 12px;
        }


        /* MENU LINK */

        .menu a {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px;

            border-radius: 8px;

            color: #aaa;

            text-decoration: none;

            font-size: 14px;

            transition: all 0.2s ease;
        }


        /* HOVER */

        .menu a:hover {
            background: #222;

            color: white;
        }


        /* ACTIVE */

        .menu a.active {
            background: #333;

            color: white;
        }


        /* ICON */

        .icon {
            width: 20px;

            min-width: 20px;

            text-align: center;

            font-size: 16px;
        }


        /* =========================================
           SIDEBAR BOTTOM
        ========================================= */

        .sidebar-bottom {
            margin-top: auto;

            padding-top: 20px;
        }


        /* =========================================
           LOGOUT
        ========================================= */

        .logout-form {
            margin-top: 10px;
        }

        .logout-button {
            width: 100%;

            border: none;

            background: transparent;

            color: #aaa;

            padding: 12px;

            border-radius: 8px;

            text-align: left;

            cursor: pointer;

            font-size: 14px;

            display: flex;

            align-items: center;

            gap: 12px;

            transition: all 0.2s ease;
        }

        .logout-button:hover {
            background: #222;

            color: white;
        }


        /* =========================================
           MAIN CONTENT
        ========================================= */

        .content {
            flex: 1;

            margin-left: 250px;

            min-width: 0;

            padding: 30px;
        }


        /* =========================================
           TOPBAR
        ========================================= */

        .topbar {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 28px;

            font-weight: 700;

            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;

            font-size: 14px;
        }


        /* =========================================
           USER INFO
        ========================================= */

        .user {
            background: white;

            padding: 10px 15px;

            border-radius: 8px;

            font-size: 14px;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.04);
        }


        /* =========================================
           ALERT
        ========================================= */

        .alert {
            padding: 13px 15px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 14px;
        }

        .alert-success {
            background: #e8f7ee;

            color: #18794e;
        }

        .alert-error {
            background: #fdecec;

            color: #b42318;
        }


        /* =========================================
           VALIDATION ERROR
        ========================================= */

        .validation-errors {
            margin: 0;

            padding-left: 20px;
        }


        /* =========================================
           RESPONSIVE TABLET
        ========================================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 220px;
            }

            .content {
                margin-left: 220px;

                padding: 25px;
            }

        }


        /* =========================================
           RESPONSIVE MOBILE
        ========================================= */

        @media (max-width: 650px) {

            .layout {
                display: block;
            }

            .sidebar {
                position: relative;

                width: 100%;

                height: auto;

                min-height: auto;
            }

            .content {
                margin-left: 0;

                padding: 20px;
            }

            .topbar {
                display: block;
            }

            .user {
                display: inline-block;

                margin-top: 15px;
            }

        }
    </style>


    @stack('styles')

</head>


<body>


    <div class="layout">


        <!-- =========================================
         SIDEBAR
    ========================================== -->

        <aside class="sidebar">


            <!-- LOGO -->

            <div>

                <div class="logo">

                    SOY YPIK

                    <span class="subtitle">
                        PAM JAYA
                    </span>

                </div>


                <!-- MENU -->

                <nav class="menu">


                    <div class="menu-title">
                        Menu Utama
                    </div>


                    <!-- DASHBOARD -->

                    <a href="{{ route('customer.dashboard') }}"
                        class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">

                        <span class="icon">
                            🏠
                        </span>

                        <span>
                            Dashboard
                        </span>

                    </a>


                    <!-- SIMPANAN -->

                    <a href="{{ route('customer.simpanan') }}"
                        class="{{ request()->routeIs('customer.simpanan') ? 'active' : '' }}">

                        <span class="icon">
                            💰
                        </span>

                        <span>
                            Simpanan
                        </span>

                    </a>


                    <!-- PINJAMAN -->

                    <a href="{{ route('customer.pinjaman') }}"
                        class="{{ request()->routeIs('customer.pinjaman') ? 'active' : '' }}">

                        <span class="icon">
                            💳
                        </span>

                        <span>
                            Pinjaman
                        </span>

                    </a>


                    <!-- RIWAYAT -->

                    <a href="{{ route('customer.riwayat') }}"
                        class="{{ request()->routeIs('customer.riwayat') ? 'active' : '' }}">

                        <span class="icon">
                            📜
                        </span>

                        <span>
                            Riwayat Transaksi
                        </span>

                    </a>


                    <!-- ACCOUNT -->

                    <div class="menu-title">
                        Akun
                    </div>


                    <!-- PROFIL -->

                    <a href="{{ route('customer.profil') }}"
                        class="{{ request()->routeIs('customer.profil') ? 'active' : '' }}">

                        <span class="icon">
                            👤
                        </span>

                        <span>
                            Profil
                        </span>

                    </a>


                </nav>

            </div>


            <!-- =========================================
             SIDEBAR BOTTOM
        ========================================== -->

            <div class="sidebar-bottom">


                <!-- LOGOUT -->

                <form action="{{ route('logout') }}" method="POST" class="logout-form">

                    @csrf

                    <button type="submit" class="logout-button">

                        <span class="icon">
                            🚪
                        </span>

                        <span>
                            Logout
                        </span>

                    </button>

                </form>


            </div>


        </aside>


        <!-- =========================================
         MAIN CONTENT
    ========================================== -->

        <main class="content">


            <!-- TOPBAR -->

            <div class="topbar">


                <div>

                    <h1>
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <p>
                        @yield(
                            'page-description',
                            'Ringkasan aktivitas koperasi Anda'
                        )
                    </p>

                </div>


                <!-- USER LOGIN -->

                <div class="user">

                    {{ auth()->user()->nama_lengkap }}

                </div>


            </div>


            <!-- =========================================
             SUCCESS MESSAGE
        ========================================== -->

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif


            <!-- =========================================
             ERROR MESSAGE
        ========================================== -->

            @if(session('error'))

                <div class="alert alert-error">

                    {{ session('error') }}

                </div>

            @endif


            <!-- =========================================
             VALIDATION ERRORS
        ========================================== -->

            @if($errors->any())

                <div class="alert alert-error">

                    <ul class="validation-errors">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- =========================================
             PAGE CONTENT
        ========================================== -->

            @yield('content')


        </main>


    </div>


    <!-- =========================================
     JAVASCRIPT STACK
========================================== -->

    @stack('scripts')


</body>

</html>