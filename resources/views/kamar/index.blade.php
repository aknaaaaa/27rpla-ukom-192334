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
    background: #b89376;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 14px;
}

.btn-masuk:hover {
    opacity: 0.9;
    color: white;
}

.btn-daftar {
    background: #272727;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 14px;
}

.btn-daftar:hover {
    opacity: 0.9;
    color: white;
}

/* Navbar container */
.navbar-custom {
    background: white;
}

/* Back Button */
.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: all 0.3s;
}

.back-button:hover {
    background: #f5f5f5;
    color: #333;
}

.back-button svg {
    width: 18px;
    height: 18px;
}

/* Filter Container */
.filter-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 32px;
}

.filter-section h6 {
    font-size: 14px;
    font-weight: 600;
    color: #666;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-section input[type="date"] {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px;
    font-size: 14px;
    width: 100%;
}

.malam-badge {
    background: #B1DCF0;
    color: #3C5BB1;
    border: 2px solid #3C5BB1;
    border-radius: 8px;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 14px;
    display: inline-block;
}

/* Room Card */
.room-card {
    background: #E8DED3;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.3s;
}

.room-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.room-card-content {
    padding: 20px;
}

.room-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.room-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.detail-badge {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #333;
    cursor: pointer;
}

.room-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
    letter-spacing: 1px;
}

.room-subtitle {
    font-size: 11px;
    color: #d63384;
    font-weight: 600;
    margin-bottom: 4px;
}

.room-info-title {
    font-size: 13px;
    font-weight: 700;
    color: #1a1a1a;
    margin-top: 16px;
    margin-bottom: 8px;
}

.room-info-list {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 13px;
    color: #333;
}

.room-info-list li {
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.room-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.room-price {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
}

.room-price-label {
    font-size: 12px;
    color: #666;
    font-weight: 400;
}

.room-note {
    font-size: 11px;
    color: #999;
    font-style: italic;
}

.btn-pilih {
    background: #2d2d2d;
    color: white;
    border: none;
    padding: 10px 32px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s;
}

.btn-pilih:hover {
    background: #1a1a1a;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

/* Container Adjustments */
.main-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px 15px;
}

</style>

@include('components.navbar')

<div class="main-container" style="margin-top: 80px;">
    <!-- Back Button -->
    <div class="mb-4">
        <a class="back-button" href="{{ url('/') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>BACK</span>
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="filter-section">
        <form method="GET" action="{{ route('kamar.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <h6>CHECK IN</h6>
                    <input type="date" id="checkin" name="checkin" 
                           value="{{ request('checkin') }}" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <h6>CHECK OUT</h6>
                    <input type="date" id="checkout" name="checkout" 
                           value="{{ request('checkout') }}" class="form-control" required>
                </div>
                <div class="col-md-4 text-center">
                    <div id="malamDisplay" class="malam-badge mb-2" style="display:none;">0 Malam</div>
                </div>
            </div>
        </form>
    </div>

    {{-- Room Cards --}}
    <div class="row">
            <div class="col-12">
                <div class="room-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="room-image-wrapper">
                                <img src="#" 
                                     class="room-image" alt="#">
                                <span class="detail-badge">Detail</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="room-card-content">
                                <h3 class="room-title">BODOD KAMAR</h3>
                                <p class="room-subtitle">SARAPAN TIDAK TERSEDIA</p>
                                <p class="room-subtitle">TIDAK BISA REFUND & RESCHEDULE</p>
                                
                                <p class="room-info-title">INFORMASI SINGKAT</p>
                                <ul class="room-info-list">
                                    <li>👤 <span>1 ORANG</span></li>
                                    <li>📏 <span>1 meter</span></li>
                                    <li>🛏️ <span>SINGLE</span></li>
                                </ul>

                                <div class="room-footer">
                                    <div>
                                        <div class="room-price">
                                            Rp100.000.000
                                            <span class="room-price-label">/ MALAM</span>
                                        </div>
                                        <p class="room-note mb-0">SISA 1 KAMAR</p>
                                    </div>
                                    <form action="POST" method="POST">

                                        @csrf
                                        <button class="btn-pilih" type="submit">Pilih</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>

<script>
    // Hitung otomatis jumlah malam
    const checkInInput = document.getElementById('checkin');
    const checkOutInput = document.getElementById('checkout');
    const malamBadge = document.getElementById('malamDisplay');

    function updateMalam() {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (checkIn && checkOut && checkOut > checkIn) {
            const diffTime = checkOut - checkIn;
            const diffDays = Math.floor(diffTime / (1000 * 3600 * 24));
            malamBadge.textContent = diffDays + " Malam";
            malamBadge.style.display = 'inline-block';
        } else {
            malamBadge.style.display = 'none';
        }
    }

    checkInInput.addEventListener('change', updateMalam);
    checkOutInput.addEventListener('change', updateMalam);

    // Tampilkan langsung saat halaman reload jika ada tanggal
    window.addEventListener('DOMContentLoaded', updateMalam);
</script>
@endsection