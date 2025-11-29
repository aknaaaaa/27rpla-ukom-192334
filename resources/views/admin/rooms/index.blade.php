@php $active = 'rooms'; @endphp
@extends('admin.layouts.admin')

@section('title', 'Kelola Kamar')

@section('extra-css')
<style>
    .page-head {
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:14px;
        margin-bottom:16px;
    }
    .eyebrow { text-transform: uppercase; letter-spacing: 0.26em; font-size: 11px; color:#7a7a7a; margin:0 0 6px 0; }
    .muted { color:#7b7b7b; margin:0; }
    .btn-primary {
        background: linear-gradient(120deg, #0f172a, #1f2937);
        color: #fff;
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-shadow: 0 12px 26px rgba(0,0,0,0.16);
    }
    .btn-ghost, .btn-danger {
        border: 1px solid #d7d7d7;
        background: #fff;
        color: #222;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: 0.4px;
    }
    .btn-danger { color:#c53030; border-color:#f1c7c7; background:#fff7f7; }
    .room-grid {
        display:grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap:14px;
    }
    .room-card {
        background:#fff;
        border:1px solid #e3e3e3;
        border-radius:14px;
        overflow:hidden;
        box-shadow:0 14px 26px rgba(0,0,0,0.06);
        display:flex;
        flex-direction:column;
    }
    .room-media {
        position:relative;
        height:190px;
        background:#f6f6f6;
    }
    .room-media img {
        width:100%;
        height:100%;
        object-fit:cover;
    }
    .status-chip, .stock-chip {
        position:absolute;
        top:10px;
        right:10px;
        background:rgba(0,0,0,0.7);
        color:#fff;
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        letter-spacing:0.3px;
    }
    .stock-chip {
        top:auto;
        bottom:10px;
        right:10px;
        background:rgba(255,255,255,0.9);
        color:#111;
        border:1px solid #e2e2e2;
    }
    .room-body { padding:14px; display:flex; flex-direction:column; gap:8px; }
    .room-title { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .room-title h3 { margin:0; letter-spacing:0.6px; }
    .price { font-weight:700; letter-spacing:0.4px; }
    .meta { display:flex; flex-wrap:wrap; gap:8px; font-size:13px; color:#4b5563; }
    .chip { background:#111; color:#fff; border-radius:999px; padding:6px 10px; font-size:11px; letter-spacing:0.4px; }
    .chips { display:flex; flex-wrap:wrap; gap:6px; }
    .card-actions { display:flex; gap:8px; justify-content:flex-end; flex-wrap:wrap; margin-top:6px; }
    .alert { border-radius:10px; padding:10px 12px; margin-bottom:12px; }
    .alert.success { background:#e7f8ef; color:#196038; border:1px solid #c1e7d0; }
    .alert.error { background:#fdecea; color:#b00020; border:1px solid #fac7c1; }
    .modal {
        position:fixed;
        inset:0;
        background:rgba(0,0,0,0.4);
        display:none;
        align-items:center;
        justify-content:center;
        padding:16px;
        z-index:60;
    }
    .modal.is-open { display:flex; }
    .modal-card {
        width:min(900px, 100%);
        background:#fff;
        border-radius:14px;
        padding:18px;
        box-shadow:0 22px 42px rgba(0,0,0,0.18);
        border:1px solid #e3e3e3;
        max-height:90vh;
        overflow-y:auto;
    }
    .form-grid {
        display:grid;
        gap:12px;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group label { font-size:12px; letter-spacing:0.5px; }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width:100%;
        border:1px solid #d6d6d6;
        border-radius:8px;
        padding:10px 12px;
        background:#fafafa;
    }
    .form-group textarea { min-height:100px; resize:vertical; }
    .fasilitas-grid {
        display:grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap:8px;
    }
    .fasilitas-item {
        border:1px solid #e1e1e1;
        border-radius:10px;
        padding:8px 10px;
        display:flex;
        gap:8px;
        align-items:flex-start;
        background:#fafafa;
    }
    .fasilitas-item:hover { border-color:#0f172a; }
    @media (max-width: 640px) { .room-title { flex-direction:column; } }
</style>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Inventori</p>
            <h1 style="margin:0;">Manajemen Kamar</h1>
            <p class="muted">Pastikan kategori, kapasitas, dan fasilitas sesuai sebelum dipublikasikan.</p>
        </div>
        <button class="btn-primary" type="button" onclick="openRoomModal('create')">Tambah kamar</button>
    </div>

    @if(session('ok'))
        <div class="alert success">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">
            <ul style="margin:0; padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="room-grid">
        @forelse($rooms as $room)
            @php
                $status = strtolower($room->status_kamar ?? 'Tersedia');
                $statusLabel = $room->status_kamar ?? 'Tersedia';
                $statusColor = $status === 'maintenance' ? '#f59e0b' : ($status === 'penuh' || $status === 'telah di reservasi' ? '#dc2626' : '#16a34a');
            @endphp
            <article class="room-card">
                <div class="room-media">
                    <img src="{{ $room->gambar ?? asset('images/default.jpg') }}"
                         alt="{{ $room->nama_kamar }}"
                         onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">
                    <span class="status-chip" style="background: {{ $statusColor }};">{{ $statusLabel }}</span>
                    <span class="stock-chip">Stok: {{ $room->stok ?? 0 }}</span>
                </div>
                <div class="room-body">
                    <div class="room-title">
                        <div>
                            <p class="eyebrow" style="margin-bottom:4px;">{{ $room->kategoriRelasi->name ?? $room->kategori ?? 'Tanpa kategori' }}</p>
                            <h3>{{ $room->nama_kamar }}</h3>
                        </div>
                        <div class="price">Rp{{ number_format($room->harga_permalam, 0, ',', '.') }}/malam</div>
                    </div>
                    <div class="meta">
                        <span><i class="bi bi-people"></i> {{ $room->kapasitas ?? 1 }} orang</span>
                        <span><i class="bi bi-aspect-ratio"></i> {{ $room->ukuran_kamar ?? '-' }}</span>
                    </div>
                    <p class="muted" style="line-height:1.5;">
                        {{ $room->deskripsi ? \Illuminate\Support\Str::limit($room->deskripsi, 140) : 'Belum ada deskripsi.' }}
                    </p>
                    <div class="chips">
                        @forelse($room->fasilitas as $f)
                            <span class="chip">{{ $f->nama_fasilitas }}</span>
                        @empty
                            <span class="muted" style="font-size:12px;">Tidak ada fasilitas</span>
                        @endforelse
                    </div>
                    <div class="card-actions">
                        <button class="btn-ghost"
                                type="button"
                                onclick="openRoomModal('edit', this)"
                                data-id="{{ $room->id_kamar }}"
                                data-action="{{ route('admin.rooms.update', $room->id_kamar) }}"
                                data-nama="{{ $room->nama_kamar }}"
                                data-kategori-id="{{ $room->id_kategori ?? '' }}"
                                data-harga="{{ $room->harga_permalam }}"
                                data-stok="{{ $room->stok ?? 0 }}"
                                data-kapasitas="{{ $room->kapasitas ?? 1 }}"
                                data-ukuran="{{ $room->ukuran_kamar }}"
                                data-status="{{ $room->status_kamar }}"
                                data-deskripsi="{{ e($room->deskripsi) }}"
                                data-fasilitas="{{ $room->fasilitas->pluck('id_fasilitas')->join(',') }}">
                            Edit
                        </button>
                        <button class="btn-danger" type="button" data-delete="{{ $room->id_kamar }}">Hapus</button>
                    </div>
                </div>
            </article>
        @empty
            <p class="muted" style="grid-column:1/-1;">Belum ada kamar.</p>
        @endforelse
    </div>

    <div class="modal" id="roomModal">
        <div class="modal-card">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:10px;">
                <div>
                    <p class="eyebrow" style="margin:0 0 4px 0;">Form</p>
                    <h4 id="roomModalTitle" style="margin:0;">Tambah kamar</h4>
                </div>
                <button class="btn-ghost" type="button" onclick="closeRoomModal()">Tutup</button>
            </div>
            <form id="roomForm" method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="roomMethod" value="">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama kamar</label>
                        <input id="roomName" type="text" name="nama_kamar" value="{{ old('nama_kamar') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="roomKategori" name="id_kategori" required>
                            <option value="">-- Pilih kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('id_kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Harga per malam</label>
                        <input id="roomHarga" type="number" name="harga_permalam" min="0" step="1000" value="{{ old('harga_permalam') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Stok kamar</label>
                        <input id="roomStok" type="number" name="stok" min="0" value="{{ old('stok', 1) }}" required>
                        <small class="muted">Stok 0 akan mengubah status ke Penuh.</small>
                    </div>
                    <div class="form-group">
                        <label>Kapasitas (orang)</label>
                        <input id="roomKapasitas" type="number" name="kapasitas" min="1" max="10" value="{{ old('kapasitas', 2) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Ukuran kamar</label>
                        <input id="roomUkuran" type="text" name="ukuran_kamar" value="{{ old('ukuran_kamar') }}" placeholder="Mis: 24 m2">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="roomStatus" name="status_kamar">
                            <option value="Tersedia" {{ old('status_kamar') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Penuh" {{ old('status_kamar') === 'Penuh' ? 'selected' : '' }}>Penuh</option>
                            <option value="Maintenance" {{ old('status_kamar') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="Telah di reservasi" {{ old('status_kamar') === 'Telah di reservasi' ? 'selected' : '' }}>Telah di reservasi</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column:1/-1;">
                        <label>Deskripsi</label>
                        <textarea id="roomDeskripsi" name="deskripsi" placeholder="Detail singkat kamar">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="form-group" style="grid-column:1/-1;">
                        <label>Fasilitas (otomatis mengikuti kategori)</label>
                        <div id="fasilitasContainer" class="fasilitas-grid">
                            <p class="muted" style="grid-column:1/-1;">Pilih kategori untuk memuat fasilitas.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input id="roomImage" type="file" name="image" accept="image/*" {{ old('nama_kamar') ? '' : 'required' }}>
                        <small class="muted">Kosongkan saat edit jika tidak diganti.</small>
                    </div>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:12px;">
                    <button type="button" class="btn-ghost" onclick="closeRoomModal()">Batal</button>
                    <button type="submit" class="btn-primary" id="roomSubmit">Simpan kamar</button>
                </div>
            </form>
        </div>
    </div>

    <form id="deleteRoomForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('extra-js')
<script>
    const roomModal = document.getElementById('roomModal');
    const roomForm = document.getElementById('roomForm');
    const roomMethod = document.getElementById('roomMethod');
    const roomModalTitle = document.getElementById('roomModalTitle');
    const roomSubmit = document.getElementById('roomSubmit');
    const roomName = document.getElementById('roomName');
    const roomKategori = document.getElementById('roomKategori');
    const roomHarga = document.getElementById('roomHarga');
    const roomStok = document.getElementById('roomStok');
    const roomKapasitas = document.getElementById('roomKapasitas');
    const roomUkuran = document.getElementById('roomUkuran');
    const roomStatus = document.getElementById('roomStatus');
    const roomDeskripsi = document.getElementById('roomDeskripsi');
    const roomImage = document.getElementById('roomImage');
    const fasilitasContainer = document.getElementById('fasilitasContainer');
    const deleteRoomForm = document.getElementById('deleteRoomForm');
    const updateUrlTemplate = "{{ route('admin.rooms.update', ['id' => '__ID__']) }}";
    const deleteUrlTemplate = "{{ route('admin.rooms.destroy', ['id' => '__ID__']) }}";
    let currentRoomId = null;
    let selectedFasilitas = [];

    const oldValues = {
        nama: @json(old('nama_kamar')),
        kategori: @json(old('id_kategori')),
        harga: @json(old('harga_permalam')),
        stok: @json(old('stok')),
        kapasitas: @json(old('kapasitas')),
        ukuran: @json(old('ukuran_kamar')),
        status: @json(old('status_kamar')),
        deskripsi: @json(old('deskripsi')),
    };

    async function loadFasilitas(preselected = [], roomId = null) {
        const kategoriId = roomKategori.value;
        fasilitasContainer.innerHTML = '<p class="muted" style="grid-column:1/-1;">Memuat fasilitas...</p>';
        if (!kategoriId) {
            fasilitasContainer.innerHTML = '<p class="muted" style="grid-column:1/-1;">Pilih kategori terlebih dahulu.</p>';
            return;
        }
        try {
            const url = roomId
                ? `/api/kategoris/${kategoriId}/fasilitas?room_id=${roomId}`
                : `/api/kategoris/${kategoriId}/fasilitas`;
            const res = await fetch(url);
            const fasilitas = await res.json();
            if (!Array.isArray(fasilitas) || !fasilitas.length) {
                fasilitasContainer.innerHTML = '<p class="muted" style="grid-column:1/-1;">Belum ada fasilitas untuk kategori ini.</p>';
                return;
            }
            fasilitasContainer.innerHTML = '';
            fasilitas.forEach((f) => {
                const wrapper = document.createElement('label');
                wrapper.className = 'fasilitas-item';
                wrapper.innerHTML = `
                    <input type="checkbox" name="fasilitas[]" value="${f.id_fasilitas}" ${preselected.includes(String(f.id_fasilitas)) ? 'checked' : ''}>
                    <div>
                        <strong style="font-size:13px;">${f.nama_fasilitas}</strong>
                        ${f.deskripsi ? `<div class="muted" style="font-size:12px;">${f.deskripsi}</div>` : ''}
                    </div>
                `;
                fasilitasContainer.appendChild(wrapper);
            });
        } catch (err) {
            fasilitasContainer.innerHTML = '<p class="muted" style="grid-column:1/-1;color:#c53030;">Gagal memuat fasilitas.</p>';
        }
    }

    function resetRoomForm() {
        currentRoomId = null;
        selectedFasilitas = [];
        roomForm.action = "{{ route('admin.rooms.store') }}";
        roomMethod.value = '';
        roomModalTitle.textContent = 'Tambah kamar';
        roomSubmit.textContent = 'Simpan kamar';
        roomName.value = oldValues.nama || '';
        roomKategori.value = oldValues.kategori || '';
        roomHarga.value = oldValues.harga || '';
        roomStok.value = oldValues.stok ?? 1;
        roomKapasitas.value = oldValues.kapasitas || 2;
        roomUkuran.value = oldValues.ukuran || '';
        roomStatus.value = oldValues.status || 'Tersedia';
        roomDeskripsi.value = oldValues.deskripsi || '';
        roomImage.value = '';
        roomImage.required = true;
        fasilitasContainer.innerHTML = '<p class="muted" style="grid-column:1/-1;">Pilih kategori untuk memuat fasilitas.</p>';
    }

    function openRoomModal(mode = 'create', button = null) {
        roomModal.classList.add('is-open');
        if (mode === 'edit' && button) {
            const data = button.dataset;
            currentRoomId = data.id;
            selectedFasilitas = (data.fasilitas || '').split(',').filter(Boolean);
            roomForm.action = data.action || updateUrlTemplate.replace('__ID__', data.id);
            roomMethod.value = 'PUT';
            roomModalTitle.textContent = 'Edit kamar';
            roomSubmit.textContent = 'Simpan perubahan';
            roomName.value = data.nama || '';
            roomKategori.value = data.kategoriId || '';
            roomHarga.value = data.harga || '';
            roomStok.value = data.stok || 0;
            roomKapasitas.value = data.kapasitas || 1;
            roomUkuran.value = data.ukuran || '';
            roomStatus.value = data.status || 'Tersedia';
            roomDeskripsi.value = data.deskripsi || '';
            roomImage.required = false;
            loadFasilitas(selectedFasilitas, currentRoomId);
        } else {
            resetRoomForm();
        }
    }

    function closeRoomModal() {
        roomModal.classList.remove('is-open');
    }

    roomKategori?.addEventListener('change', () => loadFasilitas(selectedFasilitas, currentRoomId));

    document.querySelectorAll('[data-delete]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-delete');
            if (!id) return;
            if (!confirm('Hapus kamar ini?')) return;
            deleteRoomForm.action = deleteUrlTemplate.replace('__ID__', id);
            deleteRoomForm.submit();
        });
    });

    @if($errors->any())
        openRoomModal('create');
    @endif
</script>
@endsection
