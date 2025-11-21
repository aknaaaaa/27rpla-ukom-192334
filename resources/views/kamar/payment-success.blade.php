@extends('layouts.test')

@section('title', 'Pembayaran Berhasil')

@section('content')
<style>
    .success-shell {
        margin-top: 90px;
        padding: 32px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f5fbff, #eef5ff);
        border: 1px solid #d4e4ff;
        box-shadow: 0 12px 30px rgba(45,140,255,0.15);
    }
    .success-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e1e7f5;
        padding: 30px;
        text-align: center;
    }
    .success-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #d4f6e6;
        color: #28a745;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin-bottom: 20px;
    }
    .count-text {
        font-size: 14px;
        color: #6c7a92;
        margin-top: 12px;
    }
</style>

<div class="container">
    <div class="success-shell">
        <div class="success-card">
            <div class="success-icon">&#10003;</div>
            <h2 class="fw-bold">Pembayaran Berhasil</h2>
            <p class="text-muted mb-3">Terima kasih telah melakukan pembayaran. Detail pemesanan bisa Anda lihat di halaman riwayat.</p>
            <a href="{{ route('profile.profile', ['tab' => 'history']) }}" class="btn btn-primary mt-2">Lihat Riwayat Sekarang</a>
            <div class="count-text">Mengalihkan ke riwayat pemesanan...</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        @auth
        const target = "{{ route('profile.profile', ['tab' => 'history']) }}";
        setTimeout(() => {
            window.location.href = target;
        }, 5000);
        @else
        // jika session login habis, arahkan ke login agar tidak diam di halaman kosong
        const loginUrl = "{{ route('layouts.login') }}";
        setTimeout(() => {
            window.location.href = loginUrl;
        }, 5000);
        @endauth
    });
    </script>
@endsection
