@php
    $imageUrl = $kamar->gambar ?: asset('images/default.jpg');
    $statusLower = strtolower($kamar->status_kamar);
    $isReserved = $statusLower === 'telah di reservasi';
    $isMaintenance = $statusLower === 'maintenance';

    $imageStyle = '';
    if ($isReserved) {
        $imageStyle = 'filter: grayscale(1);';
    } elseif ($isMaintenance) {
        $imageStyle = 'filter: grayscale(1) opacity(0.7);';
    }
@endphp
<div class="card shadow-sm mb-3 room-card w-100">
    <div class="row g-0 align-items-stretch h-100">
        <div class="col-md-4">
            <div class="position-relative h-100">
                @if($isMaintenance)
                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Maintenance</span>
                @endif
                <img src="{{ $imageUrl }}"
                    class="img-fluid rounded-start room-card-img h-100"
                    alt="{{ $kamar->nama_kamar }}"
                    style="{{ $imageStyle }}">
            </div>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title text-uppercase fw-bold">{{ $kamar->nama_kamar }}</h5>
                <p class="card-text small mb-1">Ukuran: {{ $kamar->ukuran_kamar ?? 'Tidak dicantumkan' }}</p>
                <p class="card-text small mb-1">Kapasitas: <strong>{{ $kamar->kapasitas ?? 2 }} orang</strong></p>
                <p class="card-text small mb-1">Status: {{ $kamar->status_kamar }}</p>
                <p class="card-text small mb-1">
                    <strong>Stok: {{ $kamar->stok ?? 0 }} kamar</strong>
                    <span class="badge {{ ($kamar->stok ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ ($kamar->stok ?? 0) > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </p>
                <p class="card-text mb-2 fw-semibold text-dark">
                    Rp{{ number_format($kamar->harga_permalam, 0, ',', '.') }} / Malam
                </p>
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
                    <a href="{{ route('kamar.show', $kamar->id_kamar) }}"
                       class="btn btn-outline-primary btn-sm"
                       data-requires-auth="true"
                       data-action="add-to-cart"
                       data-id="{{ $kamar->id_kamar }}"
                       data-price="{{ $kamar->harga_permalam }}"
                       data-nama="{{ $kamar->nama_kamar }}"
                       data-gambar="{{ $imageUrl }}">
                        Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
