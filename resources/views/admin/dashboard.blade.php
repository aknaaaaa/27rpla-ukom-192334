<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - D'Kasuari</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --text-main: #2c2c2c;
            --muted: #9a9a9a;
            --card-shadow: 0 14px 22px rgba(0, 0, 0, 0.08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Aboreto', sans-serif;
            color: var(--text-main);
            background: #f9f9f9;
        }
        .dashboard-shell {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 230px;
            background: #ffffff;
            box-shadow: 8px 0 26px rgba(0, 0, 0, 0.06);
            padding: 28px 22px;
            position: relative;
            z-index: 2;
            transition: transform 0.25s ease;
        }
        .brand {
            margin-bottom: 18px;
        }
        .brand__name {
            font-family: 'Mea Culpa', cursive;
            font-size: 28px;
            margin: 0;
            line-height: 1.1;
        }
        .brand__address {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            letter-spacing: 0.4px;
            color: var(--muted);
            text-transform: uppercase;
        }
        .menu {
            margin-top: 40px;
            display: grid;
            gap: 18px;
        }
        .menu__item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 13px;
            text-transform: uppercase;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .menu__item:hover {
            color: #000;
            transform: translateX(4px);
        }
        .menu__item.is-active {
            font-weight: 600;
        }
        .menu__icon {
            font-size: 20px;
            width: 22px;
            text-align: center;
        }
        .main {
            flex: 1;
            position: relative;
            padding: 26px 34px 40px;
            overflow: hidden;
            background: #fcfcfc;
        }
        .main::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(120deg, rgba(0,0,0,0.04) 0, rgba(0,0,0,0.04) 1px, transparent 1px, transparent 22px),
                repeating-linear-gradient(60deg, rgba(0,0,0,0.035) 0, rgba(0,0,0,0.035) 1px, transparent 1px, transparent 26px);
            opacity: 0.35;
            pointer-events: none;
        }
        .content {
            position: relative;
            z-index: 1;
        }
        .top-line {
            border-bottom: 1px solid #e0e0e0;
            margin: 12px 0 22px;
        }
        .kpi-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:12px;
        }
        .tile{
            background:#fff;
            border:1px solid #dcdcdc;
            border-radius:4px;
            padding:18px 16px;
            box-shadow:0 6px 12px rgba(0,0,0,0.06);
            min-height:110px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            letter-spacing:0.4px;
        }
        .tile__label{
            margin:0 0 6px;
            font-size:12px;
            text-transform:uppercase;
            color:#4a4a4a;
        }
        .tile__value{
            margin:0;
            font-size:36px;
            line-height:1.1;
            font-weight:400;
        }
        .tile__row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }
        .tile__icon{
            font-size:32px;
            color:#202020;
        }
        .tile--hero{
            grid-column:1 / -1;
        }
        .tile--orders{
            grid-column:1 / 3;
        }
        .tile--users{
            grid-column:3 / 4;
        }
        .tile--dark{
            background:#111;
            color:#fff;
            border-color:#111;
        }
        .tile--muted{
            background:#d9d9d9;
            border-color:#d9d9d9;
        }
        .tile--ghost{
            background:#fff;
        }
        .tile--dark .tile__label,
        .tile--dark .tile__icon{color:#fff;}
        .tile--muted .tile__icon{color:#222;}
        .tile--ghost .tile__icon{color:#000;}
        .hamburger {
            position: fixed;
            top: 16px;
            left: 16px;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid #cfcfcf;
            background: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            z-index: 120;
            box-shadow: 0 10px 16px rgba(0,0,0,0.08);
            cursor: pointer;
        }
        @media (max-width: 960px) {
            .dashboard-shell { flex-direction: column; }
            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                width: 250px;
                transform: translateX(-100%);
                box-shadow: 0 6px 16px rgba(0,0,0,0.12);
                background: #fff;
                z-index: 110;
                padding-top: 72px;
            }
            .sidebar.is-open { transform: translateX(0); }
            .sidebar .menu { grid-template-columns: 1fr; }
            .main { padding-left: 16px; padding-right: 16px; }
            .hamburger { display: inline-flex; }
            .kpi-grid{grid-template-columns:repeat(auto-fit,minmax(200px,1fr));}
            .tile--orders,
            .tile--users{grid-column:auto;}
        }
        @media (max-width: 600px) {
            .menu { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
            .kpi-grid{grid-template-columns:repeat(auto-fit,minmax(160px,1fr));}
            .tile__value{font-size:30px;}
        }
        /* Loading overlay saat pindah halaman */
        .page-loader {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.75);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s ease;
        }
        .page-loader.is-visible {
            opacity: 1;
            pointer-events: all;
        }
        .loader-spinner {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 6px solid #e1e1e1;
            border-top-color: #2c2c2c;
            animation: spin 0.9s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @media (max-width: 980px) {
            .dashboard-shell { flex-direction: column; }
            .sidebar { width: 100%; box-shadow: 0 6px 16px rgba(0,0,0,0.05); }
        }
    </style>
</head>
<body>
    @php
        $metrics = $metrics ?? [
            'total_orders' => 12,
            'total_users' => 0,
            'total_rooms' => 0,
            'occupied_rooms' => 0,
            'available_rooms' => 0,
            'total_revenue' => 'Rp 0',
        ];
    @endphp

    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

        <main class="main">
            <div class="content">
                <div class="top-line"></div>
                <div class="kpi-grid">
                    <div class="tile tile--hero">
                        <p class="tile__label">Total Pendapatan</p>
                        <p class="tile__value">{{ $metrics['total_revenue'] }}</p>
                    </div>
                    <div class="tile tile--orders">
                        <p class="tile__label">Total Pesanan</p>
                        <div class="tile__row">
                            <p class="tile__value">{{ $metrics['total_orders'] }}</p>
                            <i class="bi bi-cart3 tile__icon"></i>
                        </div>
                    </div>
                    <div class="tile tile--users">
                        <p class="tile__label">Total Pengguna</p>
                        <div class="tile__row">
                            <p class="tile__value">{{ $metrics['total_users'] }}</p>
                            <i class="bi bi-person tile__icon"></i>
                        </div>
                    </div>
                    <div class="tile tile--dark">
                        <p class="tile__label">Jumlah Kamar</p>
                        <div class="tile__row">
                            <p class="tile__value">{{ $metrics['total_rooms'] }}</p>
                            <i class="bi bi-phone tile__icon"></i>
                        </div>
                    </div>
                    <div class="tile tile--muted">
                        <p class="tile__label">Jumlah Kamar Terisi</p>
                        <div class="tile__row">
                            <p class="tile__value">{{ $metrics['occupied_rooms'] }}</p>
                            <i class="bi bi-briefcase tile__icon"></i>
                        </div>
                    </div>
                    <div class="tile tile--ghost">
                        <p class="tile__label">Jumlah Kamar Tersedia</p>
                        <div class="tile__row">
                            <p class="tile__value">{{ $metrics['available_rooms'] }}</p>
                            <i class="bi bi-box-arrow-up-right tile__icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="page-loader" id="pageLoader" aria-hidden="true">
        <div class="loader-spinner" role="status" aria-label="Loading"></div>
    </div>

    <script>
        // Tampilkan overlay ketika pindah halaman dari dashboard admin
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;

            const showLoader = () => loader.classList.add('is-visible');

            // Saat user klik link (kecuali anchor kosong)
            document.querySelectorAll('a[href]').forEach((link) => {
                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;

                link.addEventListener('click', function (e) {
                    // Jangan tampilkan jika tetap di halaman yang sama
                    if (this.target === '_blank' || this.href === window.location.href) return;
                    showLoader();
                });
            });

            // Fallback: ketika browser mulai unload
            window.addEventListener('beforeunload', showLoader);
        });
        // Sidebar toggle on mobile
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            toggle?.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar?.classList.toggle('is-open');
            });
            document.addEventListener('click', function (e) {
                if (window.innerWidth > 960) return;
                if (!sidebar?.classList.contains('is-open')) return;
                if (!sidebar.contains(e.target) && e.target !== toggle) {
                    sidebar.classList.remove('is-open');
                }
            });
        });
    </script>
</body>
</html>
