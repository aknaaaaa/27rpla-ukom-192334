@props(['kamar', 'checkin' => null, 'checkout' => null])

<div class="card shadow-sm border rounded p-3" style="background: #f8f3ef;">
    <div class="d-flex">
        <img src="{{ asset($kamar['gambar']) }}" class="rounded" width="180" height="130">
        <div class="ms-3 flex-grow-1">
            <h5 class="fw-bold">{{ strtoupper($kamar['nama_kamar']) }}</h5>
            <p class="text-muted small mb-1">SARAPAN TIDAK TERSEDIA</p>
            <p class="text-muted small mb-1">TIDAK BISA REFUND & RESCHEDULE</p>
            <p class="fw-semibold">INFORMASI SINGKAT</p>
            <ul class="small mb-2">
                <li>👤 {{ $kamar['kapasitas'] ?? '1 Orang' }}</li>
                <li>📏 {{ $kamar['ukuran_kamar'] ?? '3x4 m' }}</li>
            </ul>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Rp{{ number_format($kamar['harga_permalam'], 0, ',', '.') }}</strong> / Malam
                </div>
                <form method="POST" action="{{ route('pemesanan.store', $kamar['id_kamar']) }}">
                    @csrf
                    <input type="hidden" name="checkin" value="{{ $checkin }}">
                    <input type="hidden" name="checkout" value="{{ $checkout }}">
                    <button class="btn btn-dark px-4 py-1">Pilih</button>
                </form>
            </div>
        </div>
    </div>
</div>
