@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Fasilitas</h3>

    <form action="{{ route('fasilitas.update', $fasilita->id_fasilitas) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
                @foreach ($kategoris as $k)
                <option value="{{ $k->id_kategori }}" 
                    @if($k->id_kategori == $fasilita->id_kategori) selected @endif>
                    {{ $k->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kamar (Opsional)</label>
            <select name="id_kamar" class="form-control">
                <option value="">-- Tidak Ada --</option>
                @foreach ($kamars as $ka)
                <option value="{{ $ka->id_kamar }}" 
                    @if($ka->id_kamar == $fasilita->id_kamar) selected @endif>
                    {{ $ka->nama_kamar }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Fasilitas</label>
            <input type="text" name="nama_fasilitas" class="form-control"
                   value="{{ $fasilita->nama_fasilitas }}" required>
        </div>

        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" step="0.01" name="nilai_fasilitas" class="form-control" 
                   value="{{ $fasilita->nilai_fasilitas }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $fasilita->deskripsi }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>

    </form>
</div>
@endsection
