<div class="card shadow-sm mb-3">
    <div class="row g-0 align-items-center">
        <div class="col-md-4">
            <img src="{{ asset('images/' . $kamar['gambar']) }}" 
                 class="img-fluid rounded-start" 
                 alt="{{ $kamar['nama'] }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title text-uppercase fw-bold">{{ $kamar['nama'] }}</h5>
                <p class="card-text small mb-1">👤 {{ $kamar['kapasitas'] }} Orang</p>
                <p class="card-text small mb-1">📏 {{ $kamar['luas'] }} m²</p>
                <p class="card-text mb-2 fw-semibold text-dark">
                    Rp{{ number_format($kamar['harga'], 0, ',', '.') }} / Malam
                </p>
                <button class="btn btn-dark btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#kamarDetailModal"
                        data-nama="{{ $kamar['nama'] }}"
                        data-deskripsi="{{ $kamar['deskripsi'] }}">
                    Detail
                </button>
            </div>
        </div>
    </div>
</div>
