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
            padding: 30px 38px 48px;
            overflow: hidden;
            background: #fdfdfd;
        }
        .main::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(0,0,0,0.08), transparent 55%);
            opacity: 0.65;
            pointer-events: none;
        }
        .main::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(120deg, rgba(0,0,0,0.06) 1px, transparent 1px),
                linear-gradient(300deg, rgba(0,0,0,0.04) 1px, transparent 1px);
            background-size: 340px 260px;
            opacity: 0.4;
            pointer-events: none;
        }
        .content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .top-line {
            border-bottom: 1px solid rgba(0,0,0,0.15);
            margin-bottom: 10px;
        }
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(140px, 1fr));
            gap: 18px;
        }
        .metric-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.25);
            padding: 20px 24px;
            border-radius: 10px;
            min-height: 130px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 14px 26px rgba(0,0,0,0.08);
        }
        .metric-card.span-6 { grid-column: span 6; min-height: 190px; }
        .metric-card.span-4 { grid-column: span 4; }
        .metric-card.span-3 { grid-column: span 3; }
        .metric-card.span-2 { grid-column: span 2; }
        .metric-card.span-1 { grid-column: span 1; }
        .metric-card.card-dark {
            background: #101010;
            color: #fff;
        }
        .metric-card.card-gray {
            background: #dcdcdc;
        }
        .metric-card .title {
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0 0 8px;
        }
        .metric-card .value {
            font-size: 44px;
            font-weight: 400;
            margin: 0;
        }
        .metric-card .icon {
            font-size: 42px;
            align-self: flex-end;
            opacity: 0.7;
            display: inline-flex;
        }
        .metric-card .icon i {
            font-size: inherit;
        }
        .metric-card .card-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 12px;
        }
        .metric-card.span-6 .value {
            font-size: 52px;
        }
        @media (max-width: 1024px) {
            .metric-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .metric-card.span-6,
            .metric-card.span-4,
            .metric-card.span-3,
            .metric-card.span-2,
            .metric-card.span-1 {
                grid-column: span 2;
            }
        }
        @media (max-width: 600px) {
            .metric-grid {
                grid-template-columns: 1fr;
            }
            .metric-card.span-6,
            .metric-card.span-4,
            .metric-card.span-3,
            .metric-card.span-2,
            .metric-card.span-1 {
                grid-column: span 1;
            }
        }
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
            .cards { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        }
        @media (max-width: 600px) {
            .menu { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
            .cards { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
            .card__value { font-size: 32px; }
        }
        .card--wide {
            grid-column: 1 / -1;
            min-height: 200px;
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
            'occupied_rooms' => 136,
            'available_rooms' => 0,
            'maintenance_rooms' => 0,
            'total_users' => 0,
            'total_rooms' => 0,
            'total_revenue' => 'Rp 0',
        ];
    @endphp

    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

        <main class="main">
            <div class="content">
                <div class="top-line"></div>

                <div class="metric-grid">
                    <div class="metric-card span-6">
                        <p class="title">Total Pendapatan</p>
                        <p class="value">{{ $metrics['total_revenue'] }}</p>
                    </div>

                    <div class="metric-card span-4">
                        <p class="title">Total Pesanan</p>
                        <div class="card-bottom">
                            <p class="value">{{ $metrics['total_orders'] }}</p>
                            <span class="icon"><i class="bi bi-cart3"></i></span>
                        </div>
                    </div>
                    <div class="metric-card span-2">
                        <p class="title">Total Akun Pengguna</p>
                        <div class="card-bottom">
                            <p class="value">{{ $metrics['total_users'] ?? 0 }}</p>
                            <span class="icon"><i class="bi bi-people"></i></span>
                        </div>
                    </div>

                    <div class="metric-card span-3 card-dark">
                        <p class="title">Jumlah Kamar</p>
                        <div class="card-bottom">
                            <p class="value">{{ $metrics['total_rooms'] ?? 0 }}</p>
                            <span class="icon"><i class="bi bi-door-closed"></i></span>
                        </div>
                    </div>
                    <div class="metric-card span-2 card-gray">
                        <p class="title">Jumlah Kamar Terisi</p>
                        <div class="card-bottom">
                            <p class="value">{{ $metrics['occupied_rooms'] }}</p>
                            <span class="icon"><i class="bi bi-archive"></i></span>
                        </div>
                    </div>
                    <div class="metric-card span-1 card-light">
                        <p class="title">Jumlah Kamar Tersedia</p>
                        <div class="card-bottom">
                            <p class="value">{{ $metrics['available_rooms'] }}</p>
                            <span class="icon"><i class="bi bi-box-arrow-up-right"></i></span>
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
