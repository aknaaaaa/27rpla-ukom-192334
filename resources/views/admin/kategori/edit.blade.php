@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kategori</h3>

    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Kamar</label>
            <select name="id_kamar" class="form-control" required>
                @foreach ($kamars as $k)
                <option value="{{ $k->id_kamar }}" 
                    @if ($kategori->id_kamar == $k->id_kamar) selected @endif>
                    {{ $k->nama_kamar }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control"
                   value="{{ $kategori->nama_kategori }}" required>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
