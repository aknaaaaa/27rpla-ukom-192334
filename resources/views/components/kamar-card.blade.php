@php
    $imageUrl = $kamar->gambar ?: asset('images/default.jpg');
@endphp
<div class="card shadow-sm mb-3">
    <div class="row g-0 align-items-center">
        <div class="col-md-4">
            <img src="{{ $imageUrl }}"
                 class="img-fluid rounded-start"
                 alt="{{ $kamar->nama_kamar }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title text-uppercase fw-bold">{{ $kamar->nama_kamar }}</h5>
                <p class="card-text small mb-1">Ukuran: {{ $kamar->ukuran_kamar ?? 'Tidak dicantumkan' }}</p>
                <p class="card-text small mb-1">Status: {{ $kamar->status_kamar }}</p>
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
                    <a href="{{ route('kamar.show', $kamar->id_kamar) }}" class="btn btn-outline-secondary btn-sm">
                        Halaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
