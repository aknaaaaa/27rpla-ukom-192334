@extends('layouts.app')
@section('title', 'Pembayaran - D\'Kasuari')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Daftar Pemesanan Anda</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Kode Booking</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total Hari</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pemesanans as $p)
                <tr>
                    <td>{{ $p->booking_code }}</td>
                    <td>{{ $p->kamar->nama_kamar }}</td>
                    <td>{{ $p->check_in }}</td>
                    <td>{{ $p->check_out }}</td>
                    <td>{{ $p->total_hari }}</td>
                    <td>
                        <form action="{{ route('pemesanan.update', $p->id_pemesanan) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <input type="date" name="check_in" value="{{ $p->check_in }}" required>
                            <input type="date" name="check_out" value="{{ $p->check_out }}" required>
                            <button class="btn btn-warning btn-sm">Ubah</button>
                        </form>

                        <form action="{{ route('pemesanan.destroy', $p->id_pemesanan) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesanan ini?')">Hapus</button>
                        </form>
                    </td>

                </tr>

                {{-- Modal Ubah --}}
                <div class="modal fade" id="editModal{{ $p->id_pemesanan }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('pemesanan.update', $p->id_pemesanan) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Pemesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Check-in</label>
                                    <input type="date" name="check_in" value="{{ $p->check_in }}" class="form-control mb-2">

                                    <label>Check-out</label>
                                    <input type="date" name="check_out" value="{{ $p->check_out }}" class="form-control mb-2">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada pemesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

