@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Fasilitas</h3>

    <form action="{{ route('fasilitas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kamar (Opsional)</label>
            <select name="id_kamar" class="form-control">
                <option value="">-- Tidak Ada --</option>
                @foreach ($kamars as $ka)
                <option value="{{ $ka->id_kamar }}">{{ $ka->nama_kamar }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Fasilitas</label>
            <input type="text" name="nama_fasilitas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nilai (Opsional)</label>
            <input type="number" step="0.01" name="nilai_fasilitas" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>

    </form>
</div>
@endsection
