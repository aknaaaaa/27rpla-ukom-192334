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
    .card-room-modern {
        border: 1px solid #e4e4e4;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 12px 26px rgba(0,0,0,0.06);
        background: #fff;
        display: grid;
        grid-template-rows: 170px auto;
    }
    .card-room-modern .visual {
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .card-room-modern .visual::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.1), rgba(0,0,0,0.55));
    }
    .card-room-modern .visual .tag,
    .card-room-modern .visual .price,
    .card-room-modern .visual .status {
        position: absolute;
        z-index: 2;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        letter-spacing: 0.4px;
        color: #fff;
        background: rgba(0,0,0,0.55);
    }
    .card-room-modern .visual .tag { top: 12px; left: 12px; }
    .card-room-modern .visual .price { bottom: 12px; right: 12px; background: #111; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    .card-room-modern .visual .status { top: 12px; right: 12px; }
    .card-room-modern .body { padding: 14px; display: grid; gap: 6px; }
    .card-room-modern .title-row { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; }
    .card-room-modern h5 { margin:0; letter-spacing:0.6px; }
    .card-room-modern .stock { font-size: 12px; padding:4px 8px; border-radius:8px; background:#f2f2f2; }
    .card-room-modern .meta { display:flex; flex-wrap:wrap; gap:8px; font-size: 12px; color:#4b5563; }
    .card-room-modern .actions { display:flex; gap:8px; flex-wrap:wrap; justify-content:flex-end; }
    .card-room-modern .desc { margin:0; color:#6b7280; line-height:1.5; font-size: 13px; }
</style>
<div class="card-room-modern">
    <div class="visual" style="background-image:url('{{ $imageUrl }}'); {{ $imageStyle }}">
        <span class="tag">{{ $kamar->kategoriRelasi->name ?? $kamar->kategori ?? 'Kamar' }}</span>
        <span class="status" style="background: {{ $isMaintenance ? '#f59e0b' : ($isBlocked ? '#dc2626' : '#16a34a') }};">
            {{ $kamar->status_kamar }}
        </span>
        <span class="price">Rp{{ number_format($kamar->harga_permalam, 0, ',', '.') }}/malam</span>
    </div>
    <div class="body">
        <div class="title-row">
            <div>
                <h5 class="fw-bold">{{ $kamar->nama_kamar }}</h5>
                <div class="meta">
                    <span><i class="bi bi-people"></i> {{ $kamar->kapasitas ?? 2 }} orang</span>
                    <span><i class="bi bi-aspect-ratio"></i> {{ $kamar->ukuran_kamar ?? 'Tidak dicantumkan' }}</span>
                </div>
            </div>
            <span class="stock {{ ($kamar->stok ?? 0) > 0 ? 'text-success' : 'text-danger' }}">
                Stok {{ $kamar->stok ?? 0 }}
            </span>
        </div>
        <p class="desc">
            {{ $kamar->deskripsi ? \Illuminate\Support\Str::limit($kamar->deskripsi, 110) : 'Tidak ada deskripsi.' }}
        </p>
        <div class="actions">
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
                    {{ $isBlocked ? 'disabled' : '' }}>
                {{ $isBlocked ? 'Tidak Tersedia' : 'Keranjang' }}
            </button>
        </div>
    </div>
</div>
