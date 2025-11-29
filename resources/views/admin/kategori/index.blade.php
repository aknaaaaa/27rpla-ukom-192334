@php $active = 'kategori'; @endphp
@extends('admin.layouts.admin')

@section('title', 'Kategori Kamar')

@section('extra-css')
<style>
    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }
    .eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.3em;
        font-size: 11px;
        color: #7d7d7d;
        margin: 0 0 6px 0;
    }
    .muted { color: #7a7a7a; margin: 4px 0 0 0; }
    .btn-primary {
        background: linear-gradient(120deg, #111, #333);
        color: #fff;
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        cursor: pointer;
        letter-spacing: 0.6px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.15);
    }
    .btn-ghost, .btn-danger {
        border: 1px solid #d7d7d7;
        background: #fff;
        color: #222;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: 0.4px;
    }
    .btn-danger { border-color: #f4c7c7; color: #c53030; background: #fff7f7; }
    .panel {
        background: #fff;
        border: 1px solid #dedede;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 12px 26px rgba(0,0,0,0.05);
    }
    .grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 16px;
    }
    .form-group { margin-bottom: 12px; }
    .form-group label { font-size: 12px; letter-spacing: 0.6px; display: block; margin-bottom: 6px; }
    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d6d6d6;
        border-radius: 8px;
        background: #fafafa;
    }
    .category-list { display: grid; gap: 12px; }
    .category-card {
        border: 1px solid #e3e3e3;
        border-radius: 12px;
        padding: 14px;
        background: linear-gradient(145deg, #fff, #fafafa);
        box-shadow: 0 10px 18px rgba(0,0,0,0.04);
    }
    .category-card h5 { margin: 0; letter-spacing: 0.5px; }
    .category-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #f2f2f2;
        font-size: 12px;
    }
    .chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 10px 0;
    }
    .chip {
        background: #111;
        color: #fff;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        letter-spacing: 0.4px;
    }
    .card-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.35);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
        z-index: 40;
    }
    .modal.is-open { display: flex; }
    .modal-card {
        width: min(420px, 100%);
        background: #fff;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 20px 36px rgba(0,0,0,0.2);
        border: 1px solid #dcdcdc;
    }
    .alert {
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 12px;
    }
    .alert.success { background: #e7f8ef; color: #196038; border: 1px solid #c1e7d0; }
    .alert.error { background: #fdecea; color: #b00020; border: 1px solid #fac7c1; }
    @media (max-width: 960px) { .grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Inventori</p>
            <h1 style="margin:0;">Kategori Kamar</h1>
            <p class="muted">Rapikan kategori serta fasilitas bawaan agar kamar konsisten.</p>
        </div>
        <button class="btn-primary" type="button" onclick="openKategoriModal()">Tambah kategori</button>
    </div>

    @if(session('ok'))
        <div class="alert success">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">
            <ul style="margin:0; padding-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid">
        <div class="panel">
            <h4 style="margin:0 0 10px 0;">Tambah Kategori</h4>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Mis: Deluxe, Family Suite" required>
                    <small class="muted">Gunakan nama ringkas agar mudah dibaca di kartu kamar.</small>
                </div>
                <button class="btn-primary" type="submit">Simpan kategori</button>
            </form>
        </div>
        <div class="panel">
            <h4 style="margin:0 0 12px 0;">Daftar Kategori</h4>
            <div class="category-list">
                @forelse($kategoris as $kategori)
                    <div class="category-card" data-id="{{ $kategori->id }}" data-name="{{ $kategori->name }}">
                        <div class="category-top">
                            <div>
                                <p class="eyebrow" style="margin-bottom:4px;">Kategori</p>
                                <h5>{{ $kategori->name }}</h5>
                            </div>
                            <span class="pill">{{ $kategori->fasilitas->count() }} fasilitas</span>
                        </div>
                        @if($kategori->fasilitas->count())
                            <div class="chips">
                                @foreach($kategori->fasilitas as $f)
                                    <span class="chip">{{ $f->nama_fasilitas }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="muted" style="margin:8px 0;">Belum ada fasilitas untuk kategori ini.</p>
                        @endif
                        <div class="card-actions">
                            <button type="button" class="btn-ghost" onclick="openKategoriModal(this)" data-id="{{ $kategori->id }}" data-name="{{ $kategori->name }}">Edit</button>
                            <button type="button" class="btn-danger" data-delete="{{ $kategori->id }}">Hapus</button>
                        </div>
                    </div>
                @empty
                    <p class="muted" style="margin:0;">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal" id="kategoriModal">
        <div class="modal-card">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px; margin-bottom:10px;">
                <div>
                    <p class="eyebrow" style="margin:0 0 4px 0;">Form</p>
                    <h4 id="kategoriModalTitle" style="margin:0;">Tambah kategori</h4>
                </div>
                <button type="button" class="btn-ghost" onclick="closeKategoriModal()">Tutup</button>
            </div>
            <form id="kategoriForm" method="POST" action="{{ route('admin.kategori.store') }}">
                @csrf
                <input type="hidden" name="_method" id="kategoriMethod" value="">
                <div class="form-group">
                    <label>Nama kategori</label>
                    <input type="text" id="kategoriNameInput" name="name" value="{{ old('name') }}" required>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end;">
                    <button type="button" class="btn-ghost" onclick="closeKategoriModal()">Batal</button>
                    <button type="submit" class="btn-primary" id="kategoriSubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <form id="deleteKategoriForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('extra-js')
<script>
    const kategoriModal = document.getElementById('kategoriModal');
    const kategoriForm = document.getElementById('kategoriForm');
    const kategoriMethod = document.getElementById('kategoriMethod');
    const kategoriTitle = document.getElementById('kategoriModalTitle');
    const kategoriNameInput = document.getElementById('kategoriNameInput');
    const kategoriSubmit = document.getElementById('kategoriSubmit');
    const deleteForm = document.getElementById('deleteKategoriForm');
    const updateUrlTemplate = "{{ route('admin.kategori.update', ['kategori' => '__ID__']) }}";
    const deleteUrlTemplate = "{{ route('admin.kategori.destroy', ['kategori' => '__ID__']) }}";

    function closeKategoriModal() {
        kategoriModal?.classList.remove('is-open');
        kategoriForm.action = "{{ route('admin.kategori.store') }}";
        kategoriMethod.value = '';
        kategoriTitle.textContent = 'Tambah kategori';
        kategoriSubmit.textContent = 'Simpan';
    }

    function openKategoriModal(button = null) {
        kategoriModal?.classList.add('is-open');
        kategoriForm.action = "{{ route('admin.kategori.store') }}";
        kategoriMethod.value = '';
        kategoriTitle.textContent = 'Tambah kategori';
        kategoriSubmit.textContent = 'Simpan';
        kategoriNameInput.value = button?.dataset?.name || '';

        const id = button?.dataset?.id;
        if (id) {
            kategoriForm.action = updateUrlTemplate.replace('__ID__', id);
            kategoriMethod.value = 'PUT';
            kategoriTitle.textContent = 'Edit kategori';
            kategoriSubmit.textContent = 'Perbarui';
        }
    }

    document.querySelectorAll('[data-delete]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-delete');
            if (!id) return;
            if (!confirm('Hapus kategori ini beserta fasilitasnya?')) return;
            deleteForm.action = deleteUrlTemplate.replace('__ID__', id);
            deleteForm.submit();
        });
    });

    @if(session('edit_id'))
        (function() {
            const id = "{{ session('edit_id') }}";
            const targetCard = document.querySelector(`.category-card[data-id="${id}"]`);
            if (targetCard) {
                openKategoriModal(targetCard);
            }
        })();
    @endif
    @if($errors->any())
        openKategoriModal();
    @endif
</script>
@endsection
