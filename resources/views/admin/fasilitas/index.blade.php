@php $active = 'fasilitas'; @endphp
@extends('admin.layouts.admin')

@section('title', 'Fasilitas Kamar')

@section('extra-css')
<style>
    .page-head {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        margin-bottom:16px;
    }
    .eyebrow { text-transform: uppercase; letter-spacing: 0.28em; font-size: 11px; color: #7b7b7b; margin:0 0 6px 0; }
    .muted { color:#7a7a7a; margin:2px 0 0 0; }
    .btn-primary {
        background: linear-gradient(110deg, #0f172a, #1f2937);
        color: #fff;
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-shadow: 0 12px 28px rgba(0,0,0,0.16);
    }
    .btn-ghost, .btn-danger {
        border: 1px solid #d9d9d9;
        padding: 8px 12px;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
    }
    .btn-danger { color: #c53030; border-color: #f0c7c7; background: #fff7f7; }
    .grid { display:grid; grid-template-columns: 340px 1fr; gap:14px; }
    .panel {
        background:#fff;
        border:1px solid #e3e3e3;
        border-radius:14px;
        padding:18px;
        box-shadow:0 12px 26px rgba(0,0,0,0.06);
    }
    .form-group { margin-bottom:12px; }
    .form-group label { font-size:12px; letter-spacing:0.5px; display:block; margin-bottom:6px; }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        border:1px solid #d6d6d6;
        border-radius:8px;
        padding:10px 12px;
        background:#fafafa;
    }
    .form-group textarea { min-height: 90px; resize: vertical; }
    .list { display:grid; gap:12px; }
    .facility-card {
        border:1px solid #e5e5e5;
        border-radius:12px;
        padding:14px;
        background: linear-gradient(145deg, #fff, #fafafa);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .facility-card h5 { margin:0; letter-spacing:0.5px; }
    .pill { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; background:#f3f3f3; font-size:12px; }
    .card-actions { display:flex; gap:8px; justify-content:flex-end; flex-wrap:wrap; }
    .alert { border-radius:10px; padding:10px 12px; margin-bottom:12px; }
    .alert.success { background:#e7f8ef; color:#196038; border:1px solid #c1e7d0; }
    .alert.error { background:#fdecea; color:#b00020; border:1px solid #fac7c1; }
    @media (max-width: 960px) { .grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Inventori</p>
            <h1 style="margin:0;">Fasilitas</h1>
            <p class="muted">Kelola daftar fasilitas per kategori. Biarkan kolom kamar kosong agar bisa dipilih saat membuat kamar.</p>
        </div>
        <button class="btn-primary" type="button" onclick="resetForm()">Reset form</button>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">
            <ul style="margin:0; padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid">
        <div class="panel">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:6px;">
                <div>
                    <p class="eyebrow" style="margin:0 0 4px 0;">Form</p>
                    <h4 id="formTitle" style="margin:0;">Tambah fasilitas</h4>
                </div>
                <button class="btn-ghost" type="button" onclick="resetForm()">Bersihkan</button>
            </div>
            <form id="facilityForm" method="POST" action="{{ route('admin.fasilitas.store') }}">
                @csrf
                <input type="hidden" name="_method" id="facilityMethod" value="">
                <div class="form-group">
                    <label>Nama fasilitas</label>
                    <input type="text" name="nama_fasilitas" id="facilityName" value="{{ old('nama_fasilitas') }}" placeholder="Contoh: Sarapan, Smart TV" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" id="facilityKategori" required>
                        <option value="">-- Pilih kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('id_kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nilai / Kapasitas (opsional)</label>
                    <input type="number" name="nilai_fasilitas" id="facilityNilai" value="{{ old('nilai_fasilitas') }}" placeholder="Mis: 2 (jumlah orang, unit, dsb)">
                </div>
                <div class="form-group">
                    <label>Kunci ke kamar (opsional)</label>
                    <select name="id_kamar" id="facilityKamar">
                        <option value="">Tersedia untuk semua kamar kategori terkait</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id_kamar }}" {{ old('id_kamar') == $kamar->id_kamar ? 'selected' : '' }}>
                                {{ $kamar->nama_kamar }}
                            </option>
                        @endforeach
                    </select>
                    <small class="muted">Biarkan kosong agar fasilitas bisa dipilih saat membuat kamar baru.</small>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="facilityDesc" placeholder="Catatan singkat (opsional)">{{ old('deskripsi') }}</textarea>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;">
                    <button type="button" class="btn-ghost" onclick="resetForm()">Batal</button>
                    <button type="submit" class="btn-primary" id="facilitySubmit">Simpan fasilitas</button>
                </div>
            </form>
        </div>
        <div class="panel">
            <h4 style="margin:0 0 10px 0;">Daftar Fasilitas</h4>
            <div class="list">
                @forelse($fasilitas as $item)
                    <div class="facility-card"
                         data-id="{{ $item->id_fasilitas }}"
                         data-name="{{ $item->nama_fasilitas }}"
                         data-kategori="{{ $item->id_kategori }}"
                         data-kamar="{{ $item->id_kamar }}"
                         data-nilai="{{ $item->nilai_fasilitas }}"
                         data-deskripsi="{{ $item->deskripsi }}">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                            <div>
                                <p class="eyebrow" style="margin:0 0 4px 0;">Fasilitas</p>
                                <h5>{{ $item->nama_fasilitas }}</h5>
                            </div>
                            <span class="pill">{{ $item->kategori?->name ?? 'Tanpa kategori' }}</span>
                        </div>
                        <p class="muted" style="margin:6px 0 4px 0;">
                            {{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}
                        </p>
                        <div class="muted" style="font-size:12px;">
                            <strong>Kamar:</strong>
                            {{ $item->kamar?->nama_kamar ?? 'Semua kamar di kategori ini' }}
                            @if($item->nilai_fasilitas)
                                | <strong>Nilai:</strong> {{ $item->nilai_fasilitas }}
                            @endif
                        </div>
                        <div class="card-actions" style="margin-top:10px;">
                            <button type="button" class="btn-ghost" onclick="setEdit(this)">Edit</button>
                            <button type="button" class="btn-danger" data-delete="{{ $item->id_fasilitas }}">Hapus</button>
                        </div>
                    </div>
                @empty
                    <p class="muted" style="margin:0;">Belum ada fasilitas.</p>
                @endforelse
            </div>
        </div>
    </div>

    <form id="deleteFacilityForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('extra-js')
<script>
    const facilityForm = document.getElementById('facilityForm');
    const facilityMethod = document.getElementById('facilityMethod');
    const facilityName = document.getElementById('facilityName');
    const facilityKategori = document.getElementById('facilityKategori');
    const facilityKamar = document.getElementById('facilityKamar');
    const facilityNilai = document.getElementById('facilityNilai');
    const facilityDesc = document.getElementById('facilityDesc');
    const facilitySubmit = document.getElementById('facilitySubmit');
    const formTitle = document.getElementById('formTitle');
    const deleteForm = document.getElementById('deleteFacilityForm');
    const updateUrlTemplate = "{{ route('admin.fasilitas.update', ['fasilita' => '__ID__']) }}";
    const deleteUrlTemplate = "{{ route('admin.fasilitas.destroy', ['fasilita' => '__ID__']) }}";

    function resetForm() {
        facilityForm.action = "{{ route('admin.fasilitas.store') }}";
        facilityMethod.value = '';
        facilityName.value = '';
        facilityKategori.value = '';
        facilityKamar.value = '';
        facilityNilai.value = '';
        facilityDesc.value = '';
        facilitySubmit.textContent = 'Simpan fasilitas';
        formTitle.textContent = 'Tambah fasilitas';
    }

    function setEdit(button) {
        const card = button.closest('.facility-card');
        if (!card) return;
        facilityForm.action = updateUrlTemplate.replace('__ID__', card.dataset.id);
        facilityMethod.value = 'PUT';
        facilityName.value = card.dataset.name || '';
        facilityKategori.value = card.dataset.kategori || '';
        facilityKamar.value = card.dataset.kamar || '';
        facilityNilai.value = card.dataset.nilai || '';
        facilityDesc.value = card.dataset.deskripsi || '';
        facilitySubmit.textContent = 'Perbarui fasilitas';
        formTitle.textContent = 'Edit fasilitas';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('[data-delete]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-delete');
            if (!id) return;
            if (!confirm('Hapus fasilitas ini?')) return;
            deleteForm.action = deleteUrlTemplate.replace('__ID__', id);
            deleteForm.submit();
        });
    });

    @if($errors->any())
        // Keep user on the form with previous values
        window.scrollTo({ top: 0, behavior: 'smooth' });
    @endif
    @if($editId ?? false)
        (function() {
            const target = document.querySelector(`.facility-card[data-id="{{ $editId }}"]`);
            if (target) {
                setEdit(target.querySelector('.btn-ghost'));
            }
        })();
    @endif
</script>
@endsection
