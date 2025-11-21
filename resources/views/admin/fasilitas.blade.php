<div class="card mt-4">
    <div class="card-header">Fasilitas</div>
    <div class="card-body">
        <a href="#" class="btn btn-primary mb-3">Tambah Fasilitas</a>
        <table class="table">
            <tr>
                <th>Fasilitas</th>
                <th>Aksi</th>
            </tr>
            @foreach($facilities as $facility)
            <tr>
                <td>{{ $facility->name }}</td>
                <td>
                    <button class="btn btn-sm btn-warning">Edit</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
