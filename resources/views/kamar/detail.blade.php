@extends('layouts.app')

@section('title', $kamar['nama'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="{{ asset($kamar['foto']) }}" class="img-fluid rounded shadow-sm mb-3" alt="{{ $kamar['nama'] }}">
    </div>
    <div class="col-md-6">
        <h2 class="fw-bold text-uppercase">{{ $kamar['nama'] }}</h2>
        <p class="text-muted mb-1">Rp{{ number_format($kamar['harga'], 0, ',', '.') }} / Malam</p>
        <p>{{ $kamar['deskripsi'] }}</p>

        <h5 class="mt-4 fw-semibold">Fasilitas</h5>
        @include('kamar.components.fasilitas', ['fasilitas' => $kamar['fasilitas']])

        <div class="mt-4">
            <a href="{{ route('kamar.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <button class="btn btn-dark">Pilih</button>
        </div>
    </div>
</div>
@endsection
