<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pelanggan - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --text: #2c2c2c;
            --muted: #9a9a9a;
            --shadow: 0 14px 22px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Aboreto', sans-serif;
            color: var(--text);
            background: #f9f9f9;
        }

        .dashboard-shell {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 230px;
            background: #fff;
            box-shadow: 8px 0 26px rgba(0, 0, 0, 0.06);
            padding: 28px 22px;
            z-index: 2;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
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
            color: var(--text);
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 13px;
            text-transform: uppercase;
            transition: color .2s ease, transform .2s ease;
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
            padding: 20px 34px 40px;
            position: relative;
            background: #fcfcfc;
        }

        .top-line {
            border-bottom: 1px solid #e0e0e0;
            margin: 8px 0 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }

        .card {
            border: 1px solid #d3d3d3;
            border-radius: 12px;
            padding: 14px 12px;
            background: #fff;
            box-shadow: var(--shadow);
        }

        .card h4 {
            margin: 0;
            font-size: 14px;
            letter-spacing: 0.8px;
            color: var(--muted);
        }

        .card .value {
            font-size: 24px;
            margin: 6px 0 0;
            font-weight: 700;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .filters input,
        .filters select {
            padding: 10px 12px;
            border: 1px solid #cfcfcf;
            background: #f4f4f4;
            border-radius: 10px;
            font-size: 13px;
        }

        .table-wrap {
            background: #fff;
            border: 1px solid #c9c9c9;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e1e1e1;
        }

        th {
            background: #2d2b2b;
            color: #fff;
            text-align: left;
            letter-spacing: 0.8px;
            font-size: 12px;
        }

        tr:hover td {
            background: #fafafa;
        }

        .btn-link-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid #cfcfcf;
            text-decoration: none;
            color: #2c2c2c;
            background: #fff;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.06);
        }

        .btn-link-detail:hover {
            background: #2c2c2c;
            color: #fff;
            border-color: #2c2c2c;
            transform: translateY(-1px);
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
            box-shadow: 0 10px 16px rgba(0, 0, 0, 0.08);
            cursor: pointer;
        }
        .pagination-container{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:8px;
            padding:14px 0;
        }
        .pagination-button{
            padding:8px 14px;
            border:1px solid #ccc;
            background-color:#f8f8f8;
            color:var(--text);
            cursor:pointer;
            border-radius:8px;
            font-family:'Aboreto', sans-serif;
            font-size:13px;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            justify-content:center;
        }
        .pagination-button:hover:not(.active):not(:disabled){
            background-color:#eee;
        }
        .pagination-button.active{
            background-color:#2d2b2b;
            color:#fff;
            border-color:#2d2b2b;
            font-weight:600;
        }
        .pagination-button:disabled{
            cursor:not-allowed;
            opacity:0.5;
        }
        
        /* Style untuk label filter tanggal */
        .date-filter-group {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: var(--text);
            padding: 0 5px;
        }
        
        .date-filter-group input[type="date"] {
            font-family: Arial, sans-serif; /* Mengganti font untuk input date agar lebih mudah dibaca di berbagai browser */
        }
        
        .date-filter-group-start,
        .date-filter-group-end {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        @media(max-width:960px) {
            .dashboard-shell {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                width: 250px;
                transform: translateX(-100%);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
                background: #fff;
                z-index: 110;
                transition: transform 0.25s ease;
                padding-top: 72px;
            }

            .sidebar.is-open {
                transform: translateX(0);
            }

            .sidebar .menu {
                grid-template-columns: 1fr;
            }

            .main {
                padding: 18px;
                padding-left: 16px;
                padding-right: 16px;
            }

            .hamburger {
                display: inline-flex;
            }

            .cards {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            }
        }

        @media(max-width:700px) {
            .main {
                padding: 18px;
            }

            .filters {
                flex-direction: column;
            }

            .filters input,
            .filters select {
                width: 100%;
            }

            .date-filter-group {
                /* Untuk memastikan input tanggal juga 100% lebar */
                width: 100%;
                justify-content: space-between;
                padding: 0;
            }
            
            .date-filter-group-start,
            .date-filter-group-end {
                 width: 48%; /* Bagi lebar group */
            }

            .date-filter-group input[type="date"] {
                flex-grow: 1;
            }

            .table-wrap {
                overflow-x: auto;
            }

            table {
                min-width: 720px;
            }
        }
    </style>
</head>
<body>
    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'customers'])

        <main class="main">
            <div class="top-line"></div>
            <div class="cards">
            <div class="card">
                    <h4>Total Pengguna</h4>
                    <div class="value">{{ $metrics['total_customers'] }}</div>
                </div>
            </div>
            <div class="filters">
                <input style="font-family: Aboreto;" type="text" placeholder="Cari nama / email / telepon" aria-label="Cari" oninput="filterTable(this.value)">                
            </div>
            <div class="table-wrap">
                <table id="customersTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            @php
                                $isAdmin = strcasecmp($customer->role_name ?? '', 'Admin') === 0;
                                $displayRole = $isAdmin ? 'Admin' : 'Penginap';
                                $joinDate = optional($customer->created_at)->translatedFormat('d M Y') ?? '-';
                                $sortDate = optional($customer->created_at)->format('Y-m-d') ?? ''; // Format untuk perbandingan
                            @endphp
                            <tr data-role="{{ strtolower($displayRole) }}" data-join-date="{{ $sortDate }}">
                                <td>{{ $customer->nama_user }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone_number }}</td>
                                <td>{{ $displayRole }}</td>
                                <td>{{ $joinDate }}</td>
                                <td>
                                    <a href="{{ route('admin.pelanggan.show', $customer->id_user) }}"
                                        class="btn-link-detail">
                                        <i class="bi bi-person-lines-fill"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                                <td colspan="6" style="text-align:center;color:#888;">Belum ada data pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
            <div class="pagination-container">
                @if($customers->onFirstPage())
                    <button class="pagination-button" disabled>Prev</button>
                @else
                    <a class="pagination-button" href="{{ $customers->previousPageUrl() }}">Prev</a>
                @endif

                @foreach($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                    <a class="pagination-button {{ $page == $customers->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                @endforeach

                @if($customers->hasMorePages())
                    <a class="pagination-button" href="{{ $customers->nextPageUrl() }}">Next</a>
                @else
                    <button class="pagination-button" disabled>Next</button>
                @endif
            </div>
            @endif
        </main>
    </div>
    <script>
        // Fungsi untuk filter berdasarkan nama/email/telepon
        const filterTable = (keyword) => {
            const rows = document.querySelectorAll('#customersTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                // Sembunyikan/tampilkan baris berdasarkan kata kunci
                const isKeywordMatch = text.includes(keyword.toLowerCase());
                
                // Cek apakah baris sudah disembunyikan oleh filter tanggal
                const isDateFilteredOut = row.style.display === 'none' && row.hasAttribute('data-date-filtered');
                
                if (isKeywordMatch) {
                    // Jika cocok dengan kata kunci, tampilkan jika belum disembunyikan oleh filter tanggal
                    if (!isDateFilteredOut) {
                         row.style.display = '';
                    }
                } else {
                    // Jika tidak cocok dengan kata kunci, sembunyikan
                    row.style.display = 'none';
                }
            });
            // Panggil filter tanggal lagi untuk memastikan tanggal yang disembunyikan oleh keyword tidak muncul
            if (typeof filterDate === 'function') {
                filterDate();
            }
        };

        // Fungsi untuk filter berdasarkan Role (dipertahankan dari kode asli)
        const filterRole = (role) => {
            const rows = document.querySelectorAll('#customersTable tbody tr');
            rows.forEach(row => {
                const rowRole = row.getAttribute('data-role') || '';
                if (!role) {
                    row.style.display = '';
                } else {
                    row.style.display = rowRole === role.toLowerCase() ? '' : 'none';
                }
            });

        const filterDate = () => {};

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
