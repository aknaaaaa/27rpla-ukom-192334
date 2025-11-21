<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar - Popup</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --text: #2c2c2c;
            --muted: #9a9a9a;
            --shadow: 0 14px 22px rgba(0,0,0,0.08);
            --border: #d8d8d8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Aboreto', sans-serif;
            background: linear-gradient(160deg, #f7f7f7 0%, #ededed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 1;
        }
        .modal {
            position: relative;
            z-index: 2;
            width: min(760px, 100%);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow);
            padding: 20px;
            max-height: 90vh;
            overflow: auto;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }
        .title {
            font-size: 22px;
            margin: 0;
        }
        .muted { color: var(--muted); font-size: 13px; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #cfcfcf;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s ease;
            background: #2c2c2c;
            color: #fff;
        }
        .btn:hover { transform: translateY(-1px); opacity: 0.92; }
        .btn.outline {
            background: #fff;
            color: #2c2c2c;
        }
        .form-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }
        .field label {
            display: block;
            font-size: 12px;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid #cfcfcf;
            background: #f4f4f4;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
        }
        .field textarea { min-height: 90px; resize: vertical; }
        .image-preview {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px;
            background: #f8f8f8;
            border: 1px dashed var(--border);
            border-radius: 10px;
        }
        .image-preview img {
            width: 140px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .alert {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #e1b97f;
            background: #fff6e8;
            color: #8a5a0a;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="modal">
        <div class="header-row">
            <div>
                <h1 class="title">Edit Kamar</h1>
                <p class="muted">Perbarui informasi kamar yang sudah ada.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <a class="btn outline" href="{{ route('admin.rooms') }}"><i class="bi bi-arrow-left"></i> Kembali</a>
                <button form="editRoomForm" class="btn"><i class="bi bi-save"></i> Simpan</button>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert">
                <strong>Periksa input:</strong>
                <ul style="margin:6px 0 0 14px; padding:0; font-size:13px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editRoomForm" action="{{ route('admin.rooms.update', $room->id_kamar) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field">
                    <label>Nama kamar</label>
                    <input type="text" name="nama_kamar" value="{{ old('nama_kamar', $room->nama_kamar) }}" required>
                </div>
                <div class="field">
                    <label>Harga per malam</label>
                    <input type="number" name="harga_permalam" value="{{ old('harga_permalam', $room->harga_permalam) }}" min="0" required>
                </div>
                <div class="field">
                    <label>Ukuran kamar</label>
                    <input type="text" name="ukuran_kamar" value="{{ old('ukuran_kamar', $room->ukuran_kamar) }}">
                </div>
                <div class="field">
                    <label>Status kamar</label>
                    <select name="status_kamar">
                        @foreach (['Tersedia','Telah di reservasi','Maintenance'] as $status)
                            <option value="{{ $status }}" {{ old('status_kamar', $room->status_kamar) === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field" style="grid-column: 1 / -1;">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi">{{ old('deskripsi', $room->deskripsi) }}</textarea>
                </div>
                <div class="field" style="grid-column: 1 / -1;">
                    <label>Gambar (biarkan kosong jika tidak diganti)</label>
                    <div class="image-preview">
                        <img src="{{ $room->gambar }}" alt="Gambar kamar" onerror="this.style.display='none'">
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
