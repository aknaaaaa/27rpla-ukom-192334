<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root{
            --text:#2c2c2c;
            --muted:#9a9a9a;
            --border:#d3d3d3;
            --bg:#f9f9f9;
        }
        *{box-sizing:border-box;}
        body{
            margin:0;
            font-family:'Aboreto',sans-serif;
            background:var(--bg);
            color:var(--text);
        }
        .dashboard-shell{display:flex;min-height:100vh;}
        .sidebar{
            width:230px;
            background:#fff;
            box-shadow:8px 0 26px rgba(0,0,0,0.06);
            padding:28px 22px;
            position:relative;
            z-index:2;
            transition: transform 0.25s ease;
        }
        .brand{margin-bottom:18px;}
        .brand__name{
            font-family:'Mea Culpa',cursive;
            font-size:28px;
            margin:0;
            line-height:1.1;
        }
        .brand__address{
            display:flex;
            align-items:center;
            gap:8px;
            font-size:12px;
            letter-spacing:0.4px;
            color:var(--muted);
            text-transform:uppercase;
        }
        .menu{margin-top:40px;display:grid;gap:18px;}
        .menu__item{
            display:flex;
            align-items:center;
            gap:12px;
            color:var(--text);
            text-decoration:none;
            letter-spacing:1px;
            font-size:13px;
            text-transform:uppercase;
            transition:color .2s ease,transform .2s ease;
        }
        .menu__item:hover{color:#000;transform:translateX(4px);}
        .menu__item.is-active{font-weight:600;}
        .menu__icon{font-size:20px;width:22px;text-align:center;}
        .main{
            flex:1;
            position:relative;
            padding:24px 34px 40px;
            background:#fcfcfc;
        }
        .card{
            background:#fff;
            border:1px solid var(--border);
            border-radius:14px;
            box-shadow:0 14px 22px rgba(0,0,0,0.06);
            padding:20px;
            max-width:820px;
            margin:0 auto;
        }
        .top-line{border-bottom:1px solid #e0e0e0;margin:8px 0 20px;}
        .header-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:12px;flex-wrap:wrap;}
        .btn{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:10px 14px;
            border-radius:12px;
            border:1px solid #1b4332;
            background:#2d2b2b;
            color:#fff;
            text-decoration:none;
            letter-spacing:1px;
            cursor:pointer;
            transition:opacity .15s ease,transform .15s ease;
            font-family:aboreto;
        }
        .btn:hover{opacity:.9;transform:translateY(-1px);}
        .btn.secondary{background:#fff;color:#2d2b2b;border-color:#c1c1c1;}
        form .grid{display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));}
        .field label{display:block;font-size:12px;letter-spacing:0.6px;margin-bottom:6px;}
        .field input,.field select,.field textarea{
            width:100%;
            border:1px solid #cfcfcf;
            background:#f4f4f4;
            border-radius:8px;
            padding:10px 12px;
            font-size:13px;
        }
        .field textarea{min-height:90px;resize:vertical;}
        .image-preview{
            display:flex;
            align-items:center;
            gap:14px;
            padding:10px;
            background:#f8f8f8;
            border:1px dashed var(--border);
            border-radius:10px;
        }
        .image-preview img{
            width:120px;
            height:90px;
            object-fit:cover;
            border-radius:8px;
            border:1px solid #ddd;
        }
        .alert{
            padding:10px 12px;
            border-radius:8px;
            margin-bottom:12px;
            border:1px solid;
        }
        .alert.ok{background:#d8f3dc;border-color:#b7e4c7;color:#1b4332;}
        .alert.err{background:#fde2e4;border-color:#f8d7da;color:#b00020;}
        .actions-inline{display:flex;gap:10px;margin-top:16px;}
        .flash-stack{
            position:fixed;
            top:20px;
            right:20px;
            display:grid;
            gap:10px;
            z-index:120;
        }
        .flash{
            min-width:260px;
            max-width:360px;
            padding:12px 14px;
            border-radius:10px;
            border:1px solid #b7e4c7;
            background:#d8f3dc;
            color:#1b4332;
            box-shadow:0 10px 22px rgba(0,0,0,0.12);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            letter-spacing:0.4px;
        }
        .flash button{
            background:transparent;
            border:none;
            color:inherit;
            cursor:pointer;
            font-size:16px;
            line-height:1;
        }
        .hamburger{
            position:fixed;
            top:16px;
            left:16px;
            width:42px;
            height:42px;
            border-radius:10px;
            border:1px solid #cfcfcf;
            background:#fff;
            display:none;
            align-items:center;
            justify-content:center;
            font-size:22px;
            z-index:120;
            box-shadow:0 10px 16px rgba(0,0,0,0.08);
            cursor:pointer;
        }
        @media (max-width: 960px){
            .dashboard-shell{flex-direction:column;}
            .sidebar{
                position:fixed;
                inset:0 auto 0 0;
                width:250px;
                transform:translateX(-100%);
                box-shadow:0 6px 16px rgba(0,0,0,0.12);
                background:#fff;
                z-index:110;
                padding-top:72px;
            }
            .sidebar.is-open{transform:translateX(0);}
            .sidebar .menu{grid-template-columns:1fr;}
            .hamburger{display:inline-flex;}
            .main{padding:18px;}
            form .grid{grid-template-columns:repeat(auto-fit,minmax(180px,1fr));}
        }
        @media (max-width: 650px){
            .main{padding:18px;}
            .header-row{align-items:flex-start;}
            .actions-inline{flex-direction:column;}
            .actions-inline .btn{width:100%;justify-content:center;}
        }
    </style>
</head>
<body>
    @if(session('ok'))
        <div class="flash-stack" id="flashStack">
            <div class="flash">
                <span>{{ session('ok') }}</span>
                <button type="button" aria-label="Tutup notifikasi" onclick="this.closest(\'.flash\')?.remove()">&times;</button>
            </div>
        </div>
    @endif
    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'rooms'])

        <main class="main">
            <div class="top-line"></div>
            <div class="card">
                <div class="header-row">
                    <div>
                        <h3 style="margin:0;letter-spacing:1px;">Edit Kamar</h3>
                        <div style="color:var(--muted);font-size:12px;">Perbarui data kamar dan simpan perubahan.</div>
                    </div>
                    <a class="btn secondary" href="{{ route('admin.rooms') }}"><i class="bi bi-arrow-left"></i> Kembali</a>
                </div>

                @if ($errors->any())
                    <div class="alert err">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.rooms.update', $room->id_kamar) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid">
                        <div class="field">
                            <label>Nama kamar</label>
                            <input type="text" name="nama_kamar" value="{{ old('nama_kamar', $room->nama_kamar) }}" required>
                        </div>
                        <div class="field">
                            <label>Harga per malam</label>
                            <input type="number" name="harga_permalam" min="0" step="1000" value="{{ old('harga_permalam', $room->harga_permalam) }}" required>
                        </div>
                        <div class="field">
                            <label>Ukuran kamar</label>
                            <input type="text" name="ukuran_kamar" value="{{ old('ukuran_kamar', $room->ukuran_kamar) }}" placeholder="contoh: 10 m2">
                        </div>
                        <div class="field">
                            <label>Status</label>
                            <select name="status_kamar">
                                @php($statusAktif = old('status_kamar', $room->status_kamar ?? 'Tersedia'))
                                <option value="Tersedia" {{ $statusAktif === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Telah di reservasi" {{ $statusAktif === 'Telah di reservasi' ? 'selected' : '' }}>Telah di reservasi</option>
                                <option value="Maintenance" {{ $statusAktif === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                        <div class="field" style="grid-column:1 / -1;">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Detail singkat kamar">{{ old('deskripsi', $room->deskripsi) }}</textarea>
                        </div>
                        <div class="field" style="grid-column:1 / -1;">
                            <label>Gambar</label>
                            <div class="image-preview">
                                <img src="{{ $room->gambar ?? asset('images/discover%20(1).jpg') }}" alt="{{ $room->nama_kamar }}">
                                <div style="flex:1;">
                                    <div style="font-size:12px;color:var(--muted);margin-bottom:6px;">Gambar sekarang</div>
                                    <input type="file" name="image" accept="image/*">
                                    <div style="font-size:11px;color:var(--muted);margin-top:4px;">Kosongkan jika tidak ingin mengganti.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions-inline">
                        <button type="submit" class="btn"><i class="bi bi-save"></i> Simpan perubahan</button>
                        <a class="btn secondary" href="{{ route('admin.rooms') }}">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flashStack = document.getElementById('flashStack');
            if (!flashStack) return;
            setTimeout(() => flashStack.remove(), 4200);
        });
        // Sidebar toggle on mobile
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            toggle?.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar?.classList.toggle('is-open');
            });
            document.addEventListener('click', function (e) {
                if (window.innerWidth > 960) return;
                if (!sidebar?.classList.contains('is-open')) return;
                if (!sidebar.contains(e.target) && e.target !== toggle) {
                    sidebar.classList.remove('is-open');
                }
            });
        });
    </script>
</body>
</html>
