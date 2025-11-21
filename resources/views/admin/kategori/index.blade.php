@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Kategori Kamar</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Kamar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $k)
            <tr>
                <td>{{ $k->id_kategori }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>{{ $k->kamar->nama_kamar ?? '-' }}</td>
                <td>
                    <a href="{{ route('kategori.edit', $k->id_kategori) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus kategori ini?')" class="btn btn-danger">
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
