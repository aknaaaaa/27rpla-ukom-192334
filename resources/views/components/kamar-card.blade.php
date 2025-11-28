@php
    $imageUrl = $kamar->gambar ?: asset('images/default.jpg');
    $statusLower = strtolower($kamar->status_kamar);
    $isReserved = $statusLower === 'telah di reservasi';
    $isMaintenance = $statusLower === 'maintenance';
    $isBlocked = $isReserved || $isMaintenance;

    $imageStyle = '';
    if ($isReserved) {
        $imageStyle = 'filter: grayscale(1);';
    } elseif ($isMaintenance) {
        $imageStyle = 'filter: grayscale(1) opacity(0.7);';
    }
@endphp
<style>
    .room-card-hotel {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 16px;
        border: 1px solid #e3e3e3;
        border-radius: 18px;
        background: linear-gradient(135deg, #ffffff, #fafafa);
        box-shadow: 0 14px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        min-height: 240px;
    }
    .room-thumb {
        position: relative;
        height: 220px;
        background: #f5f5f5;
    }
    .room-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .room-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        letter-spacing: 0.4px;
    }
    .room-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
    }
    .room-price-tag {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0,0,0,0.75);
        color: #fff;
        padding: 6px 10px;
        border-radius: 12px;
        font-size: 12px;
        letter-spacing: 0.3px;
    }
    .room-body {
        padding: 16px 18px 18px 0;
        display: grid;
        gap: 8px;
        align-content: center;
    }
    .room-head {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: flex-start;
    }
    .room-title { margin: 0; letter-spacing: 0.6px; font-weight: 700; color: #1f2937; }
    .room-stock {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 12px;
        background: #f3f4f6;
        color: #111827;
        border: 1px solid #e5e7eb;
    }
    .room-meta { display: flex; gap: 12px; flex-wrap: wrap; font-size: 12px; color: #4b5563; }
    .room-desc { margin: 0; color: #6b7280; font-size: 13px; line-height: 1.6; max-width: 90%; }
    .room-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .qty-control { display:flex; align-items:center; gap:8px; }
    .qty-control button {
        width:32px; height:32px;
        border-radius:8px;
        border:1px solid #d7d7d7;
        background:#fff;
        display:inline-flex; align-items:center; justify-content:center;
        font-weight:700;
    }
    .qty-control input {
        width:60px;
        text-align:center;
        border:1px solid #d7d7d7;
        border-radius:8px;
        padding:6px 8px;
    }
    @media (max-width: 720px) {
        .room-card-hotel { grid-template-columns: 1fr; }
        .room-thumb { height: 200px; }
        .room-body { padding-left: 14px; }
    }
</style>
<div class="room-card-hotel">
    <div class="room-thumb">
        <img src="{{ $imageUrl }}" alt="{{ $kamar->nama_kamar }}" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';" style="{{ $imageStyle }}">
        <span class="room-badge">{{ strtoupper($kamar->kategoriRelasi->name ?? $kamar->kategori ?? 'KAMAR') }}</span>
        <span class="room-status" style="background: {{ $isMaintenance ? '#9ca3af' : ($isBlocked ? '#b91c1c' : '#22c55e') }};">
            {{ strtoupper($kamar->status_kamar) }}
        </span>
        <span class="room-price-tag">Rp{{ number_format($kamar->harga_permalam, 0, ',', '.') }}/malam</span>
    </div>
    <div class="room-body">
        <div class="room-head">
            <div>
                <h5 class="room-title">{{ strtoupper($kamar->nama_kamar) }}</h5>
                <div class="room-meta">
                    <span><i class="bi bi-people"></i> {{ $kamar->kapasitas ?? 2 }} orang</span>
                    <span><i class="bi bi-aspect-ratio"></i> {{ $kamar->ukuran_kamar ?? 'Tidak dicantumkan' }}</span>
                </div>
            </div>
            <span class="room-stock">Stok {{ $kamar->stok ?? 0 }}</span>
        </div>
        <p class="room-desc">{{ $kamar->deskripsi ? \Illuminate\Support\Str::limit($kamar->deskripsi, 110) : 'Tidak ada deskripsi.' }}</p>
        <div class="room-actions">
            <div class="qty-control">
                <button type="button" class="btn-dec" data-qty-dec>-</button>
                <input type="number" min="1" value="1" data-qty-input>
                <button type="button" class="btn-inc" data-qty-inc>+</button>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-dark btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#kamarDetailModal"
                        data-nama="{{ $kamar->nama_kamar }}"
                        data-deskripsi="{{ $kamar->deskripsi }}"
                        data-gambar="{{ $imageUrl }}"
                        data-harga="Rp{{ number_format($kamar->harga_permalam, 0, ',', '.') }} / Malam"
                        data-ukuran="{{ $kamar->ukuran_kamar ?? 'Tidak dicantumkan' }}"
                        data-status="{{ $kamar->status_kamar }}"
                        data-url="{{ route('kamar.show', $kamar->id_kamar) }}">
                    Detail
                </button>
                <button type="button"
                        class="btn btn-outline-primary btn-sm"
                        data-requires-auth="true"
                        data-action="{{ $isBlocked ? '' : 'add-to-cart' }}"
                        data-id="{{ $kamar->id_kamar }}"
                        data-price="{{ $kamar->harga_permalam }}"
                        data-nama="{{ $kamar->nama_kamar }}"
                        data-status="{{ $kamar->status_kamar }}"
                        data-gambar="{{ $imageUrl }}"
                        data-stok="{{ $kamar->stok ?? 0 }}"
                        {{ $isBlocked ? 'disabled' : '' }}>
                    {{ $isBlocked ? 'Tidak Tersedia' : 'Keranjang' }}
                </button>
            </div>
        </div>
    </div>
</div>
