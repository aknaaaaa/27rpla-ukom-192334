<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pesanan - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* ... CSS Anda yang sudah ada ... */
        :root { 
            --text:#2c2c2c; 
            --muted:#9a9a9a; 
            --shadow:0 14px 22px rgba(0,0,0,0.08); 
        }
        *{
            box-sizing:border-box;
        }
        body{
            margin:0;
            font-family:'Aboreto',sans-serif;
            color:var(--text);background:#f9f9f9;
        }
        .dashboard-shell{
            display:flex;
            min-height:100vh;
        }
        .sidebar{
            width:230px;
            background:#fff;
            box-shadow:8px 0 26px rgba(0,0,0,0.06);
            padding:28px 22px;
            z-index:2;
        }
        .brand{
            margin-bottom:18px;
        }
        .brand__name{
            font-family:'Mea Culpa',cursive;
            font-size:28px;
            margin:0;
            line-height:1.1;
        }
        .brand__address{
            display:flex;
            align-items:center;
            gap:8px;
            font-size:12px;
            letter-spacing:0.4px;
            color:var(--muted);
            text-transform:uppercase;
        }
        .menu{
            margin-top:40px;
            display:grid;
            gap:18px;
        }
        .menu__item{
            display:flex;
            align-items:center;
            gap:12px;
            color:var(--text);
            text-decoration:none;
            letter-spacing:1px;
            font-size:13px;
            text-transform:uppercase;
            transition:color .2s ease,transform .2s ease;
        }
        .menu__item:hover{
            color:#000;
            transform:translateX(4px);
        }
        .menu__item.is-active{
            font-weight:600;
        }
        .menu__icon{
            font-size:20px;
            width:22px;
            text-align:center;
        }
        .main{
            flex:1;
            padding:20px 34px 40px;
            position:relative;
            background:#fcfcfc;
        }
        .top-line{
            border-bottom:1px solid #e0e0e0;
            margin:8px 0 20px;
        }
        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
            gap:12px;
            margin-bottom:12px;
        }
        .card{
            border:1px solid #d3d3d3;
            border-radius:12px;
            padding:14px 12px;
            background:#fff;
            box-shadow:var(--shadow);
        }
        .card h4{
            margin:0;
            font-size:14px;
            letter-spacing:0.8px;
            color:var(--muted);
        }
        .card .value{
            font-size:24px;
            margin:6px 0 0;
            font-weight:700;
        }
        .filters{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            margin-bottom:12px;
        }
        .filters input,.filters select{
            padding:10px 12px;
            border:1px solid #cfcfcf;
            background:#f4f4f4;
            border-radius:10px;
            font-size:13px;
        }
        .status-filter{
            padding:10px 12px;
            border:1px solid #cfcfcf;
            background:#fff;
            border-radius:10px;
            font-size:13px;
            min-width:180px;
            box-shadow:0 8px 16px rgba(0,0,0,0.04);
            cursor:pointer;
        }

        .table-wrap{
            background:#fff;
            border:1px solid #c9c9c9;
            border-radius:14px;
            overflow:hidden;
            box-shadow:var(--shadow);
        }
        table{
            width:100%;
            border-collapse:collapse;
            font-size:13px;
        }
        th,td{
            padding:10px 12px;
            border-bottom:1px solid #e1e1e1;
        }
        th{
            background:#2d2b2b;
            color:#fff;
            text-align:left;
            letter-spacing:0.8px;
            font-size:12px;
        }
        tr:hover td{
            background:#fafafa;
        }
        .status-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:4px 10px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
            letter-spacing:0.5px;
        }
        .status-pending{
            background:#f1f1f1;
            color:#666;
            border:1px solid #d7d7d7;
        }
        .status-occupying{
            background:#f6e7b0;
            color:#8a6f00;
            border:1px solid #e4d28a;
        }
        .status-canceled{
            background:#f8d7da;
            color:#a00;
            border:1px solid #f5c6cb;
        }
        .status-completed{
            background:#d1f1d6;
            color:#136534;
            border:1px solid #b7e4c7;
        }
        .ellipsis{
            cursor:pointer;
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
        @media(max-width:960px){
            .dashboard-shell{
                flex-direction:column;
            }
            .sidebar{
                position:fixed;
                inset:0 auto 0 0;
                width:250px;
                transform: translateX(-100%);
                box-shadow:0 6px 16px rgba(0,0,0,0.12);
                background:#fff;
                z-index:110;
                transition: transform 0.25s ease;
                padding-top:72px;
            }
            .sidebar.is-open { 
                transform: translateX(0); 
            }
            .sidebar .menu { 
                grid-template-columns: 1fr; 
            }
            .main{
                padding:18px; 
                padding-left:16px; 
                padding-right:16px
                ;}
            .hamburger { 
                display: inline-flex; 
            }
            .cards{
                grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
            }
        }
        @media(max-width:700px){
            .main{
                padding:18px;
            }
            .filters{
                flex-direction:column;
                font-family: Aboreto;
            }
            .filters input,.filters select{
                width:100%;
            }

            .table-wrap{
                overflow-x:auto;
            }
            table{
                min-width:720px;
            }
        }
        /* Gaya untuk Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 0 0;
            gap: 8px;
        }
        .pagination-button {
            padding: 8px 14px;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
            color: var(--text);
            cursor: pointer;
            border-radius: 8px;
            font-family: 'Aboreto', sans-serif;
            font-size: 13px;
        }
        .pagination-button:hover:not(.active):not(:disabled) {
            background-color: #eee;
        }
        .pagination-button.active {
            background-color: #2d2b2b;
            color: #fff;
            border-color: #2d2b2b;
            font-weight: 600;
        }
        .pagination-button:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
        /* Penempatan kontainer pagination di luar table-wrap */
        .main > .pagination-container {
            margin-top: 15px;
        }
        .btn-link-detail{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:6px 10px;
            border-radius:8px;
            border:1px solid #cfcfcf;
            text-decoration:none;
            color:#2c2c2c;
            background:#fff;
            font-weight:600;
            font-size:12px;
            transition:all 0.2s ease;
            box-shadow:0 6px 12px rgba(0,0,0,0.06);
        }
        .btn-link-detail:hover{
            background:#2c2c2c;
            color:#fff;
            border-color:#2c2c2c;
            transform:translateY(-1px);
        }
    </style>
</head>
<body>
    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'orders'])

        <main class="main">
            <div class="top-line"></div>
            <div class="cards">
                <div class="card">
                    <h4>Total Pemesanan</h4>
                    <div class="value">{{ $metrics['total'] }}</div>
                </div>
                <div class="card">
                    <h4>Total Ditempati</h4>
                    <div class="value">{{ $metrics['occupied'] }}</div>
                </div>
                <div class="card">
                    <h4>Total Menunggu</h4>
                    <div class="value">{{ $metrics['pending'] }}</div>
                </div>
                <div class="card">
                    <h4>Total Dibatalkan</h4>
                    <div class="value">{{ $metrics['canceled'] }}</div>
                </div>
            </div>
            
            <div class="filters">
                <input 
                    style="font-family: Aboreto;" 
                    type="text" 
                    id="bookingSearch"
                    placeholder="Cari ID Pesanan / Nama / Email" 
                    aria-label="Cari" 
                    oninput="setPage(1); filterOrders();"
                >

                <select id="statusFilter" onchange="setPage(1); filterOrders();" aria-label="Filter status" class="status-filter">
                    <option value="">Semua Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            
            <div class="table-wrap">
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Status</th>
                            <th>Kamar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $status = strtolower($order->status_label);
                                $class = [
                                    'pending' => 'status-pending',
                                    'occupying' => 'status-occupying',
                                    'canceled' => 'status-canceled',
                                    'completed' => 'status-completed',
                                ][$status] ?? 'status-pending';
                                
                                // Format tanggal Check-in untuk perbandingan di JS (YYYY-MM-DD)
                                $checkInDateSort = optional($order->check_in)->format('Y-m-d') ?? '';
                            @endphp
                            <tr 
                                data-booking-code="{{ strtolower($order->booking_code) }}"
                                data-customer-name="{{ strtolower($order->user->nama_user ?? '') }}"
                                data-customer-email="{{ strtolower($order->user->email ?? '') }}"
                                data-status="{{ $status }}"
                            >
                                <td>#{{ $order->booking_code }}</td>
                                <td>{{ $order->user->nama_user ?? '-' }}</td>
                                <td>{{ $order->user->email ?? '-' }}</td>
                                <td>{{ $order->user->phone_number ?? '-' }}</td>
                                <td>
                                    <span class="status-badge {{ $class }}">{{ strtoupper($order->status_label) }}</span>
                                </td>
                                <td>{{ $order->kamar->nama_kamar ?? '-' }}</td>
                                <td>{{ optional($order->check_in)->translatedFormat('d M Y') }} - {{ optional($order->check_out)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->booking_code) }}" class="btn-link-detail" title="Lihat detail pesanan">
                                        <i class="bi bi-receipt"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRowDefault" style="display:none;">
                                <td colspan="8" style="text-align:center;color:#888;">Belum ada data pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-container" id="paginationContainer">
                </div>
        </main>
    </div>
    <script>
        // --- Variabel Global untuk Pagination ---
        let currentPage = 1;
        const rowsPerPage = 10;

        /**
         * Mengatur halaman saat ini dan memicu pembaruan tampilan
         * @param {number} page - Nomor halaman yang ingin dituju
         * @param {Array<HTMLElement>} filteredRows - Daftar baris yang sudah difilter (opsional, jika dipanggil dari setupPagination)
         */
        const setPage = (page, filteredRows) => {
            const totalPages = Math.ceil((filteredRows ? filteredRows.length : 0) / rowsPerPage);
            
            // Batasi nomor halaman
            if (page < 1) page = 1;
            if (page > totalPages && totalPages > 0) page = totalPages;
            
            currentPage = page;

            // Panggil displayList jika dipanggil dari tombol pagination
            if (filteredRows) {
                 displayList(filteredRows, rowsPerPage, currentPage);
            }
            
            // Panggil filterOrders jika dipanggil dari filter/pencarian
            if (!filteredRows) {
                filterOrders(true); // Memanggil filterOrders tanpa mereset halaman
            }

            // Update status tombol pagination
            setupPagination(filteredRows);
        }

        /**
         * Menampilkan baris data yang sesuai dengan halaman saat ini.
         * @param {Array<HTMLElement>} list - Daftar baris yang sudah difilter
         * @param {number} rowsPer_Page - Jumlah baris per halaman
         * @param {number} page - Halaman saat ini
         */
        const displayList = (list, rowsPer_Page, page) => {
            const start = rowsPer_Page * (page - 1);
            const end = start + rowsPer_Page;
            
            list.forEach((row, index) => {
                // Sembunyikan semua baris
                row.style.display = 'none';
                
                // Tampilkan hanya baris dalam rentang halaman saat ini
                if (index >= start && index < end) {
                    row.style.display = '';
                }
            });
        }
        
        /**
         * Membuat dan menampilkan tombol pagination.
         * @param {Array<HTMLElement>} list - Daftar baris yang sudah difilter
         */
        const setupPagination = (list) => {
            const paginationContainer = document.getElementById('paginationContainer');
            paginationContainer.innerHTML = '';
            
            const totalPages = Math.ceil(list.length / rowsPerPage);
            
            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
                return;
            }

            paginationContainer.style.display = 'flex';
            
            // Tombol Previous
            const prevButton = document.createElement('button');
            prevButton.innerText = 'Prev';
            prevButton.classList.add('pagination-button');
            prevButton.disabled = currentPage === 1;
            prevButton.onclick = () => setPage(currentPage - 1, list);
            paginationContainer.appendChild(prevButton);

            // Tombol Halaman
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.innerText = i;
                button.classList.add('pagination-button');
                if (i === currentPage) {
                    button.classList.add('active');
                }
                button.onclick = () => setPage(i, list);
                paginationContainer.appendChild(button);
            }

            // Tombol Next
            const nextButton = document.createElement('button');
            nextButton.innerText = 'Next';
            nextButton.classList.add('pagination-button');
            nextButton.disabled = currentPage === totalPages;
            nextButton.onclick = () => setPage(currentPage + 1, list);
            paginationContainer.appendChild(nextButton);
        }


        /**
         * Fungsi utama untuk filter dan Pagination.
         * @param {boolean} keepPage - Jika true, tidak mereset currentPage ke 1.
         */
        const filterOrders = (keepPage = false) => {
            const keyword = document.getElementById('bookingSearch').value.toLowerCase().trim();
            const statusFilter = document.getElementById('statusFilter').value;
            const allRows = Array.from(document.querySelectorAll('#ordersTable tbody tr'));
            
            // Ambil pesan default "Belum ada data"
            const noDataRow = document.getElementById('noDataRowDefault');

            // --- 1. Filter Data (Menentukan baris yang cocok) ---
            const filteredRows = allRows.filter(row => {
                // Lewati baris "Belum ada data pemesanan"
                if (row === noDataRow) return false;

                const bookingCode = row.getAttribute('data-booking-code') || '';
                const customerName = row.getAttribute('data-customer-name') || '';
                const customerEmail = row.getAttribute('data-customer-email') || '';
                const status = row.getAttribute('data-status') || '';
                
                let isMatch = true;

                // 1.1 Filter Kata Kunci
                if (keyword) {
                    const isSearchingForId = keyword.startsWith('#') || keyword.startsWith('book-');
                    let isKeywordMatch = false;

                    if (isSearchingForId) {
                        const cleanedKeyword = keyword.replace('#', ''); 
                        isKeywordMatch = bookingCode.includes(cleanedKeyword);
                    } else {
                        const isCodeMatch = bookingCode.includes(keyword);
                        const isNameMatch = customerName.includes(keyword);
                        const isEmailMatch = customerEmail.includes(keyword);
                        isKeywordMatch = isCodeMatch || isNameMatch || isEmailMatch;
                    }
                    
                    if (!isKeywordMatch) {
                        isMatch = false;
                    }
                }

                // 1.2 Filter Status (Completed / Pending / Failed)
                if (isMatch && statusFilter) {
                    if (statusFilter === 'failed') {
                        if (status !== 'canceled') {
                            isMatch = false;
                        }
                    } else if (status !== statusFilter) {
                        isMatch = false;
                    }
                }

                // Kembalikan true/false untuk menentukan apakah baris ini cocok
                return isMatch;
            });
            
            // --- 2. Tampilkan Pagination dan List ---
            
            // Reset halaman ke-1 jika filter berubah (kecuali jika keepPage=true)
            if (!keepPage) {
                currentPage = 1;
            } else {
                // Pastikan current page tidak melebihi batas setelah filter
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = totalPages;
                } else if (totalPages === 0) {
                    currentPage = 1;
                }
            }

            // Tampilkan list sesuai halaman saat ini
            displayList(filteredRows, rowsPerPage, currentPage);
            
            // Buat tombol pagination
            setupPagination(filteredRows);
            
            // --- 3. Kelola Pesan "Tidak Ada Data" ---
            if (noDataRow) {
                if (filteredRows.length === 0 && allRows.length > 0) {
                    noDataRow.querySelector('td').textContent = "Tidak ada data pemesanan yang cocok dengan filter.";
                    noDataRow.style.display = '';
                } else if (allRows.length === 0) {
                    noDataRow.querySelector('td').textContent = "Belum ada data pemesanan.";
                    noDataRow.style.display = '';
                } else {
                    noDataRow.style.display = 'none';
                }
            }
        };


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
            
            // Panggil filterOrders() saat halaman dimuat
            filterOrders();
        });
    </script>
</body>
</html>
