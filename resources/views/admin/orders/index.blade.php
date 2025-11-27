<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pesanan - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root { --text:#2c2c2c; --muted:#9a9a9a; --shadow:0 14px 22px rgba(0,0,0,0.08); }
        *{box-sizing:border-box;}
        body{margin:0;font-family:'Aboreto',sans-serif;color:var(--text);background:#f9f9f9;}
        .dashboard-shell{display:flex;min-height:100vh;}
        .sidebar{width:230px;background:#fff;box-shadow:8px 0 26px rgba(0,0,0,0.06);padding:28px 22px;z-index:2;}
        .brand{margin-bottom:18px;}
        .brand__name{font-family:'Mea Culpa',cursive;font-size:28px;margin:0;line-height:1.1;}
        .brand__address{display:flex;align-items:center;gap:8px;font-size:12px;letter-spacing:0.4px;color:var(--muted);text-transform:uppercase;}
        .menu{margin-top:40px;display:grid;gap:18px;}
        .menu__item{display:flex;align-items:center;gap:12px;color:var(--text);text-decoration:none;letter-spacing:1px;font-size:13px;text-transform:uppercase;transition:color .2s ease,transform .2s ease;}
        .menu__item:hover{color:#000;transform:translateX(4px);}
        .menu__item.is-active{font-weight:600;}
        .menu__icon{font-size:20px;width:22px;text-align:center;}
        .main{flex:1;padding:20px 34px 40px;position:relative;background:#fcfcfc;}
        .top-line{border-bottom:1px solid #e0e0e0;margin:8px 0 20px;}
        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-bottom:12px;}
        .card{border:1px solid #d3d3d3;border-radius:12px;padding:14px 12px;background:#fff;box-shadow:var(--shadow);}
        .card h4{margin:0;font-size:14px;letter-spacing:0.8px;color:var(--muted);}
        .card .value{font-size:24px;margin:6px 0 0;font-weight:700;}
        .filters{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px;}
        .filters input,.filters select{padding:10px 12px;border:1px solid #cfcfcf;background:#f4f4f4;border-radius:10px;font-size:13px;}
        .table-wrap{background:#fff;border:1px solid #c9c9c9;border-radius:14px;overflow:hidden;box-shadow:var(--shadow);}
        table{width:100%;border-collapse:collapse;font-size:13px;}
        th,td{padding:10px 12px;border-bottom:1px solid #e1e1e1;}
        th{background:#2d2b2b;color:#fff;text-align:left;letter-spacing:0.8px;font-size:12px;}
        tr:hover td{background:#fafafa;}
        .status-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;letter-spacing:0.5px;}
        .status-pending{background:#f1f1f1;color:#666;border:1px solid #d7d7d7;}
        .status-occupying{background:#f6e7b0;color:#8a6f00;border:1px solid #e4d28a;}
        .status-canceled{background:#f8d7da;color:#a00;border:1px solid #f5c6cb;}
        .status-completed{background:#d1f1d6;color:#136534;border:1px solid #b7e4c7;}
        .ellipsis{cursor:pointer;}
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
            .dashboard-shell{flex-direction:column;}
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
            .sidebar.is-open { transform: translateX(0); }
            .sidebar .menu { grid-template-columns: 1fr; }
            .main{padding:18px; padding-left:16px; padding-right:16px;}
            .hamburger { display: inline-flex; }
            .cards{grid-template-columns:repeat(auto-fit,minmax(160px,1fr));}
        }
        @media(max-width:700px){
            .main{padding:18px;}
            .filters{flex-direction:column;font-family: Aboreto;}
            .filters input,.filters select{width:100%;}
            .table-wrap{overflow-x:auto;}
            table{min-width:720px;}
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
                    <h4>Total Selesai</h4>
                    <div class="value">{{ $metrics['completed'] }}</div>
                </div>
                <div class="card">
                    <h4>Total Dibatalkan</h4>
                    <div class="value">{{ $metrics['canceled'] }}</div>
                </div>
            </div>

            <div class="filters">
                <input type="text" placeholder="Cari nama / kode pesanan" aria-label="Cari">
                <select aria-label="Filter tanggal">
                    <option>Tanggal</option>
                </select>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Status</th>
                            <th>Kamar</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->kode_pesanan }}</strong></td>
                                <td>{{ $order->user->nama_user ?? '-' }}</td>
                                <td>{{ $order->user->email ?? '-' }}</td>
                                <td>{{ $order->user->phone_number ?? '-' }}</td>
                                <td>
                                    @php
                                        $status = strtolower($order->status_label);
                                        $class = [
                                            'pending' => 'status-pending',
                                            'occupying' => 'status-occupying',
                                            'canceled' => 'status-canceled',
                                            'completed' => 'status-completed',
                                        ][$status] ?? 'status-pending';
                                    @endphp
                                    <span class="status-badge {{ $class }}">{{ strtoupper($order->status_label) }}</span>
                                </td>
                                <td>{{ $order->kamar->nama_kamar ?? '-' }}</td>
                                <td>Rp{{ number_format($order->pembayaran->amount_paid ?? 0, 0, ',', '.') }}</td>
                                <td>{{ optional($order->tanggal_checkin)->translatedFormat('d M Y') }} - {{ optional($order->tanggal_checkout)->translatedFormat('d M Y') }}</td>
                                <td class="ellipsis">...</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;color:#888;">Belum ada data pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script>
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

