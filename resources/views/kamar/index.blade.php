@extends('layouts.app')

@section('title', 'Daftar Kamar - D\'Kasuari')

@section('content')
<style>
/* logo elegan */
.navbar-brand-logo {
    font-family: "Mea Culpa", cursive;
    font-size: 32px;
    margin: 0;
    line-height: 1;
}

/* alamat kecil */
.navbar-address {
    font-family: "Aboreto", serif;
    font-size: 11px;
    opacity: 0.9;
}

/* tombol */
.btn-masuk {
    background: #b89376; /* coklat muda seperti gambar */
    color: white;
    border-color: black;
    padding: 8px  twenty 16px;
    border-radius: 10px;
}

.btn-masuk:hover {
    opacity: 0.8;
}

.btn-daftar {
    background: #272727; /* hitam keabu */
    color: white;
    padding: 8px 16px;
    border-radius: 10px;
}

.btn-daftar:hover {
    opacity: 0.85;
}

/* Navbar container */
.navbar-custom {
    background: white;
}

.back {
    position: fixed; top: 100px; left: 18px;
    z-index: 5; display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 12px; font-size: 14px; font-weight: 600;
    color: #2b2b2b; background: #fff;
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(0,0,0,.16);
}
.back svg { width:16px; height:16px }

.filter-container {
    background-color: #99938F;
    border-radius: 12px;
    padding: 20px;
    max-width: 800px;
}

.malam-badge {
    background-color: #B1DCF0;
    border: 2px solid #3C5BB1;
    border-radius: 12px;
    padding: 8px 16px;
    font-weight: 600;
    color: #3C5BB1;
    margin-top: 28px;
    white-space: nowrap;
}

.kamar-card {
    background-color: #D6C0B3;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s ease;
}

.kamar-card:hover { transform: translateY(-3px); }

label {
    font-weight: 600;
    color: white;
}

</style>

@include('components.navbar')

<div class="container" style="margin-top: 75px;">
    <a class="back" href="{{ url('/') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Back</span>
    </a>

    {{-- Form Check-in / Check-out --}}
    <div class="d-flex justify-content-center mb-5">
        <form method="GET" action="{{ route('kamar.index') }}" 
              class="filter-container d-flex gap-3 align-items-center flex-wrap justify-content-center">
            <div>
                <label for="checkin">Check In</label>
                <input type="date" id="checkin" name="checkin" 
                       value="{{ request('checkin') }}" class="form-control">
            </div>
            <div>
                <label for="checkout">Check Out</label>
                <input type="date" id="checkout" name="checkout" 
                       value="{{ request('checkout') }}" class="form-control">
            </div>

            <div id="malamDisplay" class="malam-badge" style="display:none;">0 Malam</div>

            <div>
                <button type="submit" class="btn btn-dark mt-3">Cari</button>
            </div>
        </form>
    </div>

    {{-- Daftar kamar --}}
    <div class="row">
        @forelse ($kamars as $kamar)
            <div class="col-md-6 mb-4">
                <div class="card kamar-card p-3">
                    <div class="d-flex">
                        <img src="{{ asset('images/'.$kamar->gambar) }}" 
                             class="rounded" width="180" height="130" alt="{{ $kamar->nama_kamar }}">
                        <div class="ms-3 flex-grow-1">
                            <h5 class="fw-bold">{{ strtoupper($kamar->nama_kamar) }}</h5>
                            <p class="text-muted small mb-1">SARAPAN TIDAK TERSEDIA</p>
                            <p class="text-muted small mb-1">TIDAK BISA REFUND & RESCHEDULE</p>
                            <p class="fw-semibold">INFORMASI SINGKAT</p>
                            <ul class="small mb-2">
                                <li>👤 1 Orang</li>
                                <li>📏 {{ $kamar->ukuran_kamar }}</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Rp{{ number_format($kamar->harga_permalam, 0, ',', '.') }}</strong> / Malam
                                </div>
                                <form method="POST" action="#">
                                    @csrf
                                    <button class="btn btn-dark px-4 py-1">Pilih</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Tidak ada kamar tersedia untuk tanggal ini.</p>
        @endforelse
    </div>
</div>

<script>
    // hitung otomatis jumlah malam
    const checkInInput = document.getElementById('checkin');
    const checkOutInput = document.getElementById('checkout');
    const malamBadge = document.getElementById('malamDisplay');

    function updateMalam() {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (checkIn && checkOut && checkOut > checkIn) {
            const diffTime = checkOut - checkIn;
            const diffDays = diffTime / (1000 * 3600 * 24);
            malamBadge.textContent = diffDays + " Malam";
            malamBadge.style.display = 'inline-block';
        } else {
            malamBadge.style.display = 'none';
        }
    }

    checkInInput.addEventListener('change', updateMalam);
    checkOutInput.addEventListener('change', updateMalam);

    // tampilkan langsung saat halaman reload jika ada tanggal
    window.addEventListener('DOMContentLoaded', updateMalam);
</script>
@endsection
