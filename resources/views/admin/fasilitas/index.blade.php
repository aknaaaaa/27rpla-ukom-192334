@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Fasilitas</h3>

    <a href="{{ route('fasilitas.create') }}" class="btn btn-primary mb-3">Tambah Fasilitas</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Kamar</th>
                <th>Nama Fasilitas</th>
                <th>Nilai</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($fasilitas as $f)
            <tr>
                <td>{{ $f->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $f->kamar->nama_kamar ?? '-' }}</td>
                <td>{{ $f->nama_fasilitas }}</td>
                <td>{{ $f->nilai_fasilitas }}</td>
                <td>{{ $f->deskripsi }}</td>

                <td>
                    <a href="{{ route('fasilitas.edit', $f->id_fasilitas) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('fasilitas.destroy', $f->id_fasilitas) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus fasilitas ini?')" 
                                class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
