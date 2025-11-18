@extends('layouts.app')

@section('title', $kamar->nama_kamar)

@section('content')
<div class="row mt-5">
    <div class="col-md-6">
        <img src="{{ $kamar->gambar ?: asset('images/default.jpg') }}"
             class="img-fluid rounded shadow-sm mb-3"
             alt="{{ $kamar->nama_kamar }}">
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h2 class="fw-bold text-uppercase">{{ $kamar->nama_kamar }}</h2>
                <p class="text-muted mb-1">Rp{{ number_format($kamar->harga_permalam, 0, ',', '.') }} / Malam</p>
                <p class="mb-1">Ukuran: {{ $kamar->ukuran_kamar ?? 'Tidak dicantumkan' }}</p>
                <p class="mb-3">Status: {{ $kamar->status_kamar }}</p>
                <p>{{ $kamar->deskripsi ?? 'Belum ada deskripsi.' }}</p>

                <div class="mt-4">
                    <a href="{{ route('kamar.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button class="btn btn-dark"
                            type="button"
                            data-requires-auth="true"
                            data-url="{{ route('kamar.show', $kamar->id_kamar) }}"
                            data-nama="{{ $kamar->nama_kamar }}"
                            data-gambar="{{ $kamar->gambar ?: asset('images/default.jpg') }}">
                        Pilih
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.auth-alert')
@endsection
