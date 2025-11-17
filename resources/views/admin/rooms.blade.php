<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kamar - D'Kasuari</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --text-main: #2c2c2c;
            --muted: #9a9a9a;
            --badge-bg: #d9d9d9;
            --shadow: 0 14px 22px rgba(0,0,0,0.08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Aboreto', sans-serif;
            color: var(--text-main);
            background: #f9f9f9;
        }
        .dashboard-shell { display: flex; min-height: 100vh; }
        .sidebar {
            width: 230px;
            background: #fff;
            box-shadow: 8px 0 26px rgba(0,0,0,0.06);
            padding: 28px 22px;
            position: relative;
            z-index: 2;
        }
        .brand { margin-bottom: 18px; }
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
        .menu { margin-top: 40px; display: grid; gap: 18px; }
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
        .menu__item:hover { color: #000; transform: translateX(4px); }
        .menu__item.is-active { font-weight: 600; }
        .menu__icon { font-size: 20px; width: 22px; text-align: center; }
        .main {
            flex: 1;
            position: relative;
            padding: 20px 34px 40px;
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
        .content { position: relative; z-index: 1; }
        .top-line { border-bottom: 1px solid #e0e0e0; margin: 8px 0 20px; }
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.35);
            z-index: 30;
            padding: 16px;
        }
        .modal.is-open { display: flex; }
        .form-card{
            background: #fff;
            border: 1px solid #d8d8d8;
            border-radius: 12px;
            padding: 18px;
            box-shadow: var(--shadow);
            width: min(700px, 100%);
            max-height: 90vh;
            overflow: auto;
        }
        .form-grid{
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .field label{
            display: block;
            font-size: 12px;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }
        .field input,
        .field textarea,
        .field select{
            width: 100%;
            border: 1px solid #cfcfcf;
            background: #f4f4f4;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
        }
        .field textarea{ min-height: 72px; resize: vertical; }
        .actions-inline{
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .btn-new {
            display: inline-block;
            padding: 10px 18px;
            background: #2d2b2b;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.5px;
            font-size: 13px;
        }
        .rooms {
            display: grid;
            gap: 14px;
        }
        .room-card {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 20px;
            background: #fff;
            border: 1px solid #c9c9c9;
            border-radius: 14px;
            padding: 16px;
            box-shadow: var(--shadow);
        }
        .room-card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            border-radius: 10px;
        }
        .room-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 10px;
        }
        .room-title { font-size: 24px; margin: 0; letter-spacing: 0.8px; }
        .room-count { font-size: 12px; letter-spacing: 0.7px; text-align: right; }
        .meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 12px;
        }
        .meta-block { font-size: 12px; letter-spacing: 0.6px; }
        .meta-block h5 {
            margin: 0 0 6px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }
        .meta-item i { font-size: 14px; }
        .badge-muted {
            display: inline-block;
            background: var(--badge-bg);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        .divider {
            border-top: 1px solid #cfcfcf;
            margin: 6px 0 10px;
            max-width: 260px;
        }
        .status-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .status-badges {
            display: flex;
            gap: 8px;
        }
        .price {
            font-size: 20px;
            letter-spacing: 1px;
            text-align: right;
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        .btn-pill {
            flex: 1;
            min-width: 120px;
            padding: 10px 14px;
            background: #2d2b2b;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.6px;
            font-size: 13px;
        }
        @media (max-width: 960px) {
            .dashboard-shell { flex-direction: column; }
            .sidebar { width: 100%; box-shadow: 0 6px 16px rgba(0,0,0,0.05); }
            .room-card { grid-template-columns: 1fr; }
            .room-head { flex-direction: column; align-items: flex-start; }
            .status-price { flex-direction: column; align-items: flex-start; }
            .price { text-align: left; }
        }
    </style>
</head>
<body>
    <div class="dashboard-shell">
        <aside class="sidebar">
            <div class="brand">
                <p class="brand__name">D'Kasuari</p>
                <div class="brand__address">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Jl. Kasuari RT 03 RW 18</span>
                </div>
            </div>

            <nav class="menu">
                <a href="{{ route('admin.dashboard') }}" class="menu__item">
                    <i class="bi bi-grid-1x2-fill menu__icon"></i> Dashboard
                </a>
                <a href="{{ route('admin.rooms') }}" class="menu__item is-active">
                    <i class="bi bi-door-open-fill menu__icon"></i> Kamar
                </a>
                <a href="#" class="menu__item">
                    <i class="bi bi-box-seam menu__icon"></i> Pesanan
                </a>
                <a href="#" class="menu__item">
                    <i class="bi bi-people menu__icon"></i> Pelanggan
                </a>
                <a href="#" class="menu__item">
                    <i class="bi bi-credit-card-2-back menu__icon"></i> Pembayaran
                </a>
                <a href="#" class="menu__item">
                    <i class="bi bi-box-arrow-right menu__icon"></i> Keluar
                </a>
            </nav>
        </aside>

        <main class="main">
            <div class="content">
                <div class="top-line"></div>
                @if(session('ok'))
                    <div style="background:#d8f3dc;color:#1b4332;padding:10px 12px;border-radius:8px;border:1px solid #b7e4c7;margin-bottom:12px;">
                        {{ session('ok') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div style="background:#fde2e4;color:#b00020;padding:10px 12px;border-radius:8px;border:1px solid #f8d7da;margin-bottom:12px;">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="text-align:right; margin-bottom:12px;">
                    <button class="btn-new" type="button" onclick="openModal()">Buat kamar baru</button>
                </div>

                <div class="rooms">
                    @forelse($rooms as $room)
                        <div class="room-card">
                            <div>
                                <img src="{{ $room->gambar ?? asset('images/discover%20(1).jpg') }}" alt="{{ $room->nama_kamar }}">
                            </div>
                            <div>
                                <div class="room-head">
                                    <h3 class="room-title">{{ strtoupper($room->nama_kamar) }}</h3>
                                    <div class="room-count">
                                        Status: {{ $room->status_kamar ?? 'Tersedia' }}
                                    </div>
                                </div>

                                <div class="meta">
                                    <div class="meta-block">
                                        <h5>Kategori</h5>
                                        <div class="divider"></div>
                                        <div class="meta-item"><i class="bi bi-person-standing"></i> 1 Orang</div>
                                        <div class="meta-item"><i class="bi bi-square"></i> {{ $room->ukuran_kamar ?? '-' }}</div>
                                        <div class="meta-item"><i class="bi bi-door-closed"></i> Single</div>
                                    </div>
                                    <div class="meta-block">
                                        <h5>Fasilitas</h5>
                                        <div class="divider"></div>
                                        <div class="meta-item">
                                            <span class="badge-muted">Sarapan tidak tersedia</span>
                                        </div>
                                        <div class="meta-item">{{ $room->deskripsi ?? 'Tidak bisa refund & reschedule' }}</div>
                                    </div>
                                </div>

                                <div class="status-price">
                                    <div class="status-badges">
                                        <span class="badge-muted">{{ $room->status_kamar }}</span>
                                    </div>
                                    <div class="price">RP{{ number_format($room->harga_permalam, 0, ',', '.') }} / MALAM</div>
                                </div>

                                <div class="actions">
                                    <button class="btn-pill">Edit</button>
                                    <button class="btn-pill">Hapus</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="margin:0;">Belum ada data kamar.</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
    <div class="modal" id="roomModal">
        <div class="form-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h4 style="margin:0; letter-spacing:1px;">Buat kamar baru</h4>
                <button type="button" class="btn-new" style="background:#999;" onclick="closeModal()">Tutup</button>
            </div>
            <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label>Nama kamar</label>
                        <input type="text" name="nama_kamar" value="{{ old('nama_kamar') }}" required>
                    </div>
                    <div class="field">
                        <label>Harga per malam</label>
                        <input type="number" name="harga_permalam" min="0" step="1000" value="{{ old('harga_permalam') }}" required>
                    </div>
                    <div class="field">
                        <label>Ukuran kamar</label>
                        <input type="text" name="ukuran_kamar" value="{{ old('ukuran_kamar') }}" placeholder="contoh: 10 m2">
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status_kamar">
                            <option value="Tersedia" {{ old('status_kamar') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Telah di reservasi" {{ old('status_kamar') === 'Telah di reservasi' ? 'selected' : '' }}>Telah di reservasi</option>
                            <option value="Maintenance" {{ old('status_kamar') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="field" style="grid-column: 1 / -1;">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" placeholder="Detail singkat kamar">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="field">
                        <label>Gambar</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="actions-inline" style="margin-top:12px;">
                    <button type="submit" class="btn-new">Simpan kamar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(){ document.getElementById('roomModal').classList.add('is-open'); }
        function closeModal(){ document.getElementById('roomModal').classList.remove('is-open'); }
        @if($errors->any())
            // auto open modal when validation fails so user sees errors and data
            openModal();
        @endif
    </script>
</body>
</html>
