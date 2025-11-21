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
            transition: transform 0.25s ease;
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
            font-family: 'Aboreto', sans-serif;
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
            font-family: 'Aboreto', sans-serif;
        }
        .tutup-btn {
            background: #999;
            color: white;
            transition: 0.3s ease; /* biar halus */
        }

        .tutup-btn:hover {
            background: #777; /* warna saat hover */
            cursor: pointer;
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
        .room-body {
            display: flex;
            flex-direction: column;
            height: 100%;
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
            margin-top: auto;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
        }
        .btn-pill {
            flex: 0 0 auto;
            min-width: 120px;
            padding: 10px 14px;
            background: #2d2b2b;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.6px;
            font-size: 13px;
            font-family: 'Aboreto', sans-serif;
            text-decoration: none;
            display: inline-flex;
            /* align-items: center; */
            justify-content: center;
        }
        /* Confirm modal */
        .confirm-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.25);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 40;
        }
        .confirm-backdrop.is-open { display: flex; }
        .confirm-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            width: min(320px, 100%);
            box-shadow: 0 12px 30px rgba(0,0,0,0.16);
            text-align: center;
            border: 1px solid #dcdcdc;
            font-family: 'Aboreto', sans-serif;
        }
        .confirm-card h4 {
            margin: 0 0 12px;
            font-size: 14px;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .confirm-divider {
            height: 1px;
            background: #c1c1c1;
            margin: 10px 0 16px;
        }
        .confirm-btn {
            background: #2d2b2b;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            letter-spacing: 0.8px;
            cursor: pointer;
            width: 100%;
        }
        /* Loading overlay saat berpindah halaman */
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
        .flash-stack {
            position: fixed;
            top: 20px;
            right: 20px;
            display: grid;
            gap: 10px;
            z-index: 120;
        }
        .flash {
            min-width: 260px;
            max-width: 360px;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #b7e4c7;
            background: #d8f3dc;
            color: #1b4332;
            box-shadow: 0 10px 22px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            letter-spacing: 0.4px;
        }
        .flash button {
            background: transparent;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
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
            .room-card { grid-template-columns: 1fr; }
            .room-head { flex-direction: column; align-items: flex-start; }
            .status-price { flex-direction: column; align-items: flex-start; }
            .price { text-align: left; }
        }
        @media (max-width: 650px) {
            .main { padding: 18px; }
            .actions { width: 100%; justify-content: stretch; }
            .btn-pill { flex: 1 1 45%; min-width: 0; }
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
    @if(session('ok'))
        <div class="flash-stack" id="flashStack">
            <div class="flash">
                <span>{{ session('ok') }}</span>
                <button type="button" aria-label="Tutup notifikasi" onclick="this.closest('.flash')?.remove()">&times;</button>
            </div>
        </div>
    @endif
    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'rooms'])

        <main class="main">
            <div class="content">
                <div class="top-line"></div>
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
                                <img src="{{ $room->gambar ?? asset('images/discover%20(1).jpg') }}"
                                     alt="{{ $room->nama_kamar }}"
                                     onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">
                            </div>
                            <div class="room-body">
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
                                    <div class="meta-item"><i class="bi bi-tags"></i> {{ $room->kategori ?? 'Standar' }}</div>
                                    <div class="meta-item"><i class="bi bi-square"></i> {{ $room->ukuran_kamar ?? '-' }}</div>
                                </div>
                                    <div class="meta-block">
                                        <h5>Fasilitas</h5>
                                        <div class="divider"></div>
                                        <div class="meta-item">
                                            <span class="badge-muted">Sarapan tidak tersedia</span>
                                        </div>
                                        <div class="meta-item"><p>DESKRIPSI:</p>{{ $room->deskripsi ?? 'Tidak bisa refund & reschedule' }}</div>
                                    </div>
                                </div>

                                <div class="status-price">
                                    <div class="status-badges">
                                        <span class="badge-muted">{{ $room->status_kamar }}</span>
                                    </div>
                                    <div class="price">RP{{ number_format($room->harga_permalam, 0, ',', '.') }} / MALAM</div>
                                </div>

                                <div class="actions">
                                    <button class="btn-pill"
                                            type="button"
                                            data-action="{{ route('admin.rooms.update', $room->id_kamar) }}"
                                            data-nama="{{ $room->nama_kamar }}"
                                            data-kategori="{{ $room->kategori }}"
                                            data-harga="{{ $room->harga_permalam }}"
                                            data-ukuran="{{ $room->ukuran_kamar }}"
                                            data-status="{{ $room->status_kamar }}"
                                            data-deskripsi="{{ e($room->deskripsi) }}"
                                            data-img="{{ $room->gambar }}"
                                            onclick="openEditModal(this)">
                                        Edit
                                    </button>
                                    <button class="btn-pill btn-delete"
                                        type="button"
                                        data-room-id="{{ $room->id_kamar }}"
                                        data-room-name="{{ $room->nama_kamar }}">
                                        Hapus
                                    </button>
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
    <div class="page-loader" id="pageLoader" aria-hidden="true">
        <div class="loader-spinner" role="status" aria-label="Loading"></div>
    </div>
    <div class="confirm-backdrop" id="confirmDeleteModal" aria-hidden="true">
        <div class="confirm-card">
            <h4>YAKIN INGIN HAPUS?</h4>
            <div class="confirm-divider"></div>
            <button class="confirm-btn" id="confirmDeleteBtn" type="button">KONFIRMASI</button>
        </div>
    </div>
    <div class="modal" id="roomModal">
        <div class="form-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h4 id="roomModalTitle" style="margin:0; letter-spacing:1px;">Buat kamar baru</h4>
                <button type="button" class="btn-new tutup-btn" onclick="closeModal()">Tutup</button>

            </div>
            <form id="roomModalForm" method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="roomModalMethod" value="">
                <div class="form-grid">
                    <div class="field">
                        <label>Nama kamar</label>
                        <input id="roomNameInput" type="text" name="nama_kamar" value="{{ old('nama_kamar') }}" required>
                    </div>
                    <div class="field">
                        <label>Kategori</label>
                        <select id="roomKategoriSelect" name="kategori" required>
                            @php
                                $categories = ['Standar', 'Superior', 'Deluxe', 'Suite', 'Family', 'Executive'];
                                $oldKategori = old('kategori');
                            @endphp
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ $oldKategori === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Harga per malam</label>
                        <input id="roomHargaInput" type="number" name="harga_permalam" min="0" step="1000" value="{{ old('harga_permalam') }}" required>
                    </div>
                    <div class="field">
                        <label>Ukuran kamar</label>
                        <input id="roomUkuranInput" type="text" name="ukuran_kamar" value="{{ old('ukuran_kamar') }}" placeholder="contoh: 10 m2">
                    </div>
                        <div class="field">
                            <label>Stok / Jumlah Kamar</label>
                            <input id="roomStokInput" type="number" name="stok_kamar" min="0" value="{{ old('stok_kamar') }}" required>
                        </div>
                    <div class="field">
                    <label>Status</label>
                    <select id="roomStatusSelect" name="status_kamar">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Telah di reservasi">Telah di reservasi</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

                    </div>
                    <div class="field" style="grid-column: 1 / -1;">
                        <label>Deskripsi</label>
                        <textarea id="roomDeskripsiInput" name="deskripsi" placeholder="Detail singkat kamar">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="field">
                        <label>Gambar <small style="color:#777;">(kosongkan saat edit jika tidak diganti)</small></label>
                        <input id="roomImageInput" type="file" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="actions-inline" style="margin-top:12px;">
                    <button id="roomModalSubmit" type="submit" class="btn-new">Simpan kamar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        
        const roomModal = document.getElementById('roomModal');
        const roomForm = document.getElementById('roomModalForm');
        const methodInput = document.getElementById('roomModalMethod');
        const titleEl = document.getElementById('roomModalTitle');
        const submitBtn = document.getElementById('roomModalSubmit');
        const nameInput = document.getElementById('roomNameInput');
        const kategoriSelect = document.getElementById('roomKategoriSelect');
        const hargaInput = document.getElementById('roomHargaInput');
        const ukuranInput = document.getElementById('roomUkuranInput');
        const statusSelect = document.getElementById('roomStatusSelect');
        const deskripsiInput = document.getElementById('roomDeskripsiInput');
        const imageInput = document.getElementById('roomImageInput');

        function openModal(){
            resetForm();
            titleEl.textContent = 'Buat kamar baru';
            submitBtn.textContent = 'Simpan kamar';
            methodInput.value = '';
            roomForm.action = "{{ route('admin.rooms.store') }}";
            imageInput.required = true;
            roomModal.classList.add('is-open');
        }
        function closeModal(){ roomModal.classList.remove('is-open'); }

        function resetForm() {
            nameInput.value = "{{ old('nama_kamar') }}";
            kategoriSelect.value = "{{ $oldKategori ?? 'Standar' }}";
            hargaInput.value = "{{ old('harga_permalam') }}";
            ukuranInput.value = "{{ old('ukuran_kamar') }}";
            statusSelect.value = "{{ old('status_kamar') ?? 'Tersedia' }}";
            deskripsiInput.value = `{{ old('deskripsi') }}`;
            imageInput.value = '';
        }

        function openEditModal(button){
            const action = button.getAttribute('data-action');
            const nama = button.getAttribute('data-nama') || '';
            const kategori = button.getAttribute('data-kategori') || 'Standar';
            const harga = button.getAttribute('data-harga') || '';
            const ukuran = button.getAttribute('data-ukuran') || '';
            const status = button.getAttribute('data-status') || 'Tersedia';
            const deskripsi = button.getAttribute('data-deskripsi') || '';
            const img = button.getAttribute('data-img') || '';

            roomForm.action = action;
            methodInput.value = 'PUT';
            titleEl.textContent = 'Edit kamar';
            submitBtn.textContent = 'Update kamar';

            nameInput.value = nama;
            kategoriSelect.value = kategori;
            hargaInput.value = harga;
            ukuranInput.value = ukuran;
            statusSelect.value = status;
            deskripsiInput.value = deskripsi;

            imageInput.required = false;

            roomModal.classList.add('is-open');
        }

        @if($errors->any())
            // auto open modal when validation fails so user sees errors and data
            openModal();
        @endif

        // Auto-hide flash success
        document.addEventListener('DOMContentLoaded', function () {
            const flashStack = document.getElementById('flashStack');
            if (!flashStack) return;
            setTimeout(() => flashStack.remove(), 4200);
        });

        // Loader saat pindah halaman dari admin rooms
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;

            const showLoader = () => loader.classList.add('is-visible');

            document.querySelectorAll('a[href]').forEach((link) => {
                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;

                link.addEventListener('click', function () {
                    if (this.target === '_blank' || this.href === window.location.href) return;
                    showLoader();
                });
            });

            window.addEventListener('beforeunload', showLoader);
        });

        // Handle delete confirmation
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('confirmDeleteModal');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const deleteForm = document.getElementById('deleteRoomForm');
            let selectedId = null;

            document.querySelectorAll('.btn-delete').forEach((btn) => {
                btn.addEventListener('click', function () {
                    selectedId = this.dataset.roomId;
                    modal.classList.add('is-open');
                });
            });

            modal?.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.remove('is-open');
                }
            });

            confirmBtn?.addEventListener('click', function () {
                if (!selectedId || !deleteForm) return;
                const template = "{{ route('admin.rooms.destroy', ['id' => ':id']) }}";
                deleteForm.action = template.replace(':id', selectedId);
                deleteForm.submit();
            });
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
    <form id="deleteRoomForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
</body>
</html>