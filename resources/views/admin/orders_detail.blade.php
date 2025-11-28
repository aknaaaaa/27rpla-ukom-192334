<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
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
            color:var(--text);
            background:#f9f9f9;
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
        .card-detail{
            background:#fff;
            border:1px solid #d3d3d3;
            border-radius:16px;
            box-shadow:var(--shadow);
            padding:20px;
        }
        .detail-header{
            display:flex;
            justify-content:space-between;
            gap:14px;
            flex-wrap:wrap;
            align-items:flex-start;
        }
        .detail-header h2{
            margin:0;
            font-size:22px;
        }
        .detail-header p{
            margin:4px 0 0;
            color:#777;
        }
        .status-block{
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            gap:6px;
        }
        .status-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:6px 12px;
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
        .detail-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
            gap:14px;
            margin-top:12px;
        }
        .field{
            padding:12px 12px 10px;
            border:1px solid #ececec;
            border-radius:12px;
            background:#fafafa;
        }
        .field label{
            display:block;
            font-size:12px;
            letter-spacing:0.6px;
            color:#777;
            margin-bottom:6px;
        }
        .field .value{
            font-size:15px;
            font-weight:600;
            letter-spacing:0.4px;
        }
        .section-title{
            margin:16px 0 6px;
            font-size:16px;
            letter-spacing:0.5px;
        }
        .actions{
            margin-top:18px;
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }
        .btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:10px;
            border:1px solid #cfcfcf;
            background:#fff;
            color:#2c2c2c;
            text-decoration:none;
            font-size:13px;
            cursor:pointer;
            transition:all .2s ease;
        }
        .btn:hover{
            box-shadow:0 10px 18px rgba(0,0,0,0.08);
            transform:translateY(-1px);
        }
        .btn-dark{
            background:#2c2c2c;
            color:#fff;
            border-color:#2c2c2c;
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
        }
    </style>
</head>
<body>
    @php
        $status = strtolower($order->status_label);
        $statusClass = [
            'pending' => 'status-pending',
            'occupying' => 'status-occupying',
            'canceled' => 'status-canceled',
            'completed' => 'status-completed',
        ][$status] ?? 'status-pending';

        $payment = $order->pembayaran;
        $hargaPerMalam = $order->kamar->harga_permalam ?? 0;
        $subtotal = ($order->total_hari ?? 0) * $hargaPerMalam;
    @endphp
    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'orders'])

        <main class="main">
            <div class="top-line"></div>
            <div class="card-detail">
                <div class="detail-header">
                    <div>
                        <p style="margin:0;color:#777;">Pesanan #{{ $order->booking_code }}</p>
                        <h2>Detail Pesanan</h2>
                        <p>Ringkasan lengkap pemesanan dan pembayaran.</p>
                    </div>
                    <div class="status-block">
                        <span class="status-badge {{ $statusClass }}">{{ strtoupper($order->status_label) }}</span>
                        <span style="font-size:12px;color:#777;">Dibuat {{ optional($order->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</span>
                    </div>
                </div>

                <h3 class="section-title">Data Pemesanan</h3>
                <div class="detail-grid">
                    <div class="field">
                        <label>No Pesanan</label>
                        <div class="value">#{{ $order->booking_code }}</div>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <div class="value">{{ $order->status_label }}</div>
                    </div>
                    <div class="field">
                        <label>Check-in</label>
                        <div class="value">{{ optional($order->check_in)->translatedFormat('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Check-out</label>
                        <div class="value">{{ optional($order->check_out)->translatedFormat('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Durasi</label>
                        <div class="value">{{ $order->total_hari ?? 0 }} malam</div>
                    </div>
                    <div class="field">
                        <label>Kamar</label>
                        <div class="value">{{ $order->kamar->nama_kamar ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Kategori</label>
                        <div class="value">{{ $order->kamar->kategori ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Harga / Malam</label>
                        <div class="value">Rp {{ number_format($hargaPerMalam, 0, ',', '.') }}</div>
                    </div>
                    <div class="field">
                        <label>Perkiraan Tagihan</label>
                        <div class="value">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>
                </div>

                <h3 class="section-title">Data Tamu</h3>
                <div class="detail-grid">
                    <div class="field">
                        <label>Nama</label>
                        <div class="value">{{ $order->user->nama_user ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <div class="value">{{ $order->user->email ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>No Telepon</label>
                        <div class="value">{{ $order->user->phone_number ?? '-' }}</div>
                    </div>
                </div>

                <h3 class="section-title">Informasi Pembayaran</h3>
                <div class="detail-grid">
                    <div class="field">
                        <label>Status Pembayaran</label>
                        <div class="value">{{ $payment->status_pembayaran ?? 'Belum dibayar' }}</div>
                    </div>
                    <div class="field">
                        <label>Metode</label>
                        <div class="value">{{ $payment->payment_method ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Jumlah Dibayar</label>
                        <div class="value">Rp {{ number_format($payment->amount_paid ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="field">
                        <label>Tanggal Pembayaran</label>
                        <div class="value">{{ optional($payment->payment_date)->translatedFormat('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('admin.orders') }}" class="btn">
                        <i class="bi bi-arrow-left"></i> Kembali ke Pesanan
                    </a>
                </div>
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
