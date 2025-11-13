@extends('layouts.app')

@section('title', 'Daftar Kamar - D\'Kasuari')

@section('content')
<style>
.back{
    position: fixed; top: 100px; left: 18px;
    z-index: 5; display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 12px; font-size: 14px; font-weight: 600;
    color: #2b2b2b; background: #fff;
    border-radius: 8px; text-decoration: none;
    box-shadow: 0 4px 16px rgba(0,0,0,.16);
    border: 1px solid rgba(0,0,0,.06);
}
.back svg{ width:16px; height:16px }
</style>

<div class="container" style="margin-top: 75px;">
    <a class="back" href="{{ url('/') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Back</span>
    </a>

    {{-- Form Check-in / Check-out --}}
    <div class="d-flex justify-content-center mb-5">
        <form method="GET" action="{{ route('kamar.index') }}" class="d-flex gap-3 align-items-center">
            <div>
                <label>Check In</label>
                <input type="date" name="checkin" value="{{ request('checkin') }}" class="form-control">
            </div>
            <div>
                <label>Check Out</label>
                <input type="date" name="checkout" value="{{ request('checkout') }}" class="form-control">
            </div>
            <button class="btn btn-dark mt-3">Cari</button>
        </form>
    </div>

    {{-- Daftar kamar --}}
    <div class="row">
        @forelse ($kamars as $kamar)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border rounded p-3" style="background: #f8f3ef;">
                    <div class="d-flex">
                        <img src="{{ asset('storage/'.$kamar->gambar) }}" class="rounded" width="180" height="130">
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
                                <form method="POST" action="{{ route('pemesanan.store', $kamar->id_kamar) }}">
                                    @csrf
                                    <input type="hidden" name="checkin" value="{{ request('checkin') }}">
                                    <input type="hidden" name="checkout" value="{{ request('checkout') }}">
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
@endsection
