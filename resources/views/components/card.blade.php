<div class="card shadow-sm mb-4 border-0">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="{{ asset($kamar['foto']) }}" class="img-fluid rounded-start" alt="{{ $kamar['nama'] }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title text-uppercase">{{ $kamar['nama'] }}</h5>
                <p class="text-muted small mb-1">SARAPAN TIDAK TERSEDIA</p>
                <p class="text-muted small">TIDAK BISA REFUND & RESCHEDULE</p>

                <p class="mb-1"><strong>{{ $kamar['kapasitas'] }}</strong> orang • {{ $kamar['ukuran'] }}</p>
                <p class="mb-2 text-end fw-bold">Rp{{ number_format($kamar['harga'], 0, ',', '.') }} / Malam</p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('kamar.show', $kamar['id']) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                    <button class="btn btn-dark btn-sm">Pilih</button>
                </div>
            </div>
        </div>
    </div>
</div>
