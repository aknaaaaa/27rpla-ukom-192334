@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Kategori Baru</h3>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kamar</label>
            <select name="id_kamar" class="form-control" required>
                <option value="">-- Pilih Kamar --</option>
                @foreach ($kamars as $k)
                <option value="{{ $k->id_kamar }}">{{ $k->nama_kamar }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
