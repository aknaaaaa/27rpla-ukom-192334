# 🏨 PANDUAN FITUR ADMIN KAMAR - KATEGORI & FASILITAS

## 📋 Ringkasan Perubahan

Saya telah mengimplementasikan sistem manajemen kategori dan fasilitas untuk admin kamar dengan fitur dinamis. Ketika admin memilih kategori saat membuat atau mengedit kamar, fasilitas yang tersedia untuk kategori tersebut akan otomatis ditampilkan.

---

## ✨ Fitur Utama

### 1. **Manage Kategori Kamar**
- **Lokasi**: Admin Panel → Kategori Management
- **Fitur**:
  - ✅ Buat kategori baru
  - ✅ Edit nama kategori
  - ✅ Hapus kategori (fasilitas terkait juga otomatis terhapus)

### 2. **Manage Fasilitas per Kategori**
- **Lokasi**: Admin Panel → Kategori Management → Tambah Fasilitas
- **Fitur**:
  - ✅ Tambah fasilitas untuk setiap kategori
  - ✅ Edit/Hapus fasilitas
  - ✅ Setiap fasilitas terikat pada satu kategori

### 3. **Create/Edit Kamar dengan Fasilitas Dinamis** ⭐
- **Lokasi**: Admin Panel → Rooms Management
- **Alur**:
  ```
  1. Klik "Buat kamar baru"
  2. Isi nama kamar
  3. PILIH KATEGORI → Fasilitas otomatis muncul! 
  4. Centang fasilitas yang ingin ditambahkan
  5. Isi data lainnya (harga, stok, status, deskripsi, gambar)
  6. Klik "Simpan kamar"
  ```

---

## 🗄️ Database Structure

### ✓ Tabel `categories` (SUDAH ADA)
```sql
CREATE TABLE categories (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### ✓ Tabel `kamars` (UPDATED - Migration Baru)
```sql
ALTER TABLE kamars ADD COLUMN id_kategori BIGINT UNSIGNED NULLABLE;
ALTER TABLE kamars ADD FOREIGN KEY (id_kategori) REFERENCES categories(id) ON DELETE SET NULL;
```

### ✓ Tabel `fasilitas` (SUDAH ADA)
```sql
CREATE TABLE fasilitas (
  id_fasilitas BIGINT PRIMARY KEY AUTO_INCREMENT,
  id_kategori BIGINT UNSIGNED NOT NULL,
  id_kamar BIGINT UNSIGNED NULLABLE,  -- untuk assign ke kamar tertentu
  nama_fasilitas VARCHAR(100) NOT NULL,
  nilai_fasilitas VARCHAR(100),
  deskripsi VARCHAR(255),
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (id_kategori) REFERENCES categories(id) ON DELETE CASCADE,
  FOREIGN KEY (id_kamar) REFERENCES kamars(id_kamar) ON DELETE SET NULL
);
```

---

## 🔧 File-File yang Diubah/Dibuat

### Model Files:
1. ✅ **`app/Models/Kategori.php`** - Model baru dengan relasi ke fasilitas
2. ✅ **`app/Models/kamar.php`** - Update relasi & tambah kolom id_kategori
3. ✅ **`app/Models/fasilitas.php`** - Update relasi dengan tipe yang benar

### Controller Files:
1. ✅ **`app/Http/Controllers/AdminKamarController.php`** - Update store/update untuk handle kategori & fasilitas
2. ✅ **`app/Http/Controllers/KategoriController.php`** - Update untuk manage kategori & fasilitas
3. ✅ **Method baru**: `getFasilitas($kategoriId)` - untuk AJAX fetch

### View Files:
1. ✅ **`resources/views/admin/rooms/index.blade.php`** - Update form dengan:
   - Dynamic kategori dropdown
   - Dynamic fasilitas checkboxes
   - JavaScript untuk handle perubahan kategori

### Routes:
1. ✅ **`routes/api.php`** - Tambah endpoint: `/api/kategoris/{id}/fasilitas`
2. ✅ **`routes/web.php`** - Routes sudah ada (resource routes)

### Migration:
1. ✅ **`database/migrations/2025_11_27_000000_add_id_kategori_to_kamars_table.php`** - Tambah kolom id_kategori

---

## 🚀 Instalasi & Setup

### Step 1: Run Migration
```bash
php artisan migrate
```

Ini akan menambahkan kolom `id_kategori` ke tabel `kamars`.

### Step 2: Buat Data Kategori (Opsional)
```bash
php artisan tinker

>>> use App\Models\Kategori;
>>> Kategori::create(['name' => 'Standar']);
>>> Kategori::create(['name' => 'Superior']);
>>> Kategori::create(['name' => 'Deluxe']);
>>> Kategori::create(['name' => 'Suite']);
>>> exit();
```

### Step 3: Buat Data Fasilitas
Buka Admin Panel → Kategori Management → Pilih kategori → Tambah Fasilitas

Contoh:
- Kategori: Standar → Fasilitas: WiFi, AC, TV
- Kategori: Deluxe → Fasilitas: WiFi, AC, TV, Mini Bar, Jacuzzi

### Step 4: Coba Buat Kamar Baru
Buka Admin Panel → Rooms → Klik "Buat kamar baru" → Pilih kategori → Lihat fasilitas muncul!

---

## 📡 API Endpoint

### Fetch Fasilitas by Kategori
```
GET /api/kategoris/{kategoriId}/fasilitas
```

**Response:**
```json
[
  {
    "id_fasilitas": 1,
    "nama_fasilitas": "WiFi",
    "deskripsi": "Internet berkecepatan tinggi"
  },
  {
    "id_fasilitas": 2,
    "nama_fasilitas": "AC",
    "deskripsi": null
  }
]
```

---

## 🎨 Frontend Features

### Dynamic Fasilitas Loading
```javascript
// Automatically triggered when kategori is changed
async function loadFasilitas() {
  const kategoriId = kategoriSelect.value;
  const response = await fetch(`/api/kategoris/${kategoriId}/fasilitas`);
  const fasilitas = await response.json();
  // Render checkboxes for each fasilitas
}
```

### Form Handling
- **Create**: Form kosongi default, kategori kosong, fasilitas kosong
- **Edit**: Form pre-filled dengan data, fasilitas yang terpilih ditandai

---

## 🔗 Model Relationships

### Kategori Model
```php
public function fasilitas(): HasMany {
    return $this->hasMany(Fasilitas::class, 'id_kategori', 'id');
}
```

### Kamar Model
```php
public function kategoriRelasi(): BelongsTo {
    return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
}

public function fasilitas(): HasMany {
    return $this->hasMany(Fasilitas::class, 'id_kamar', 'id_kamar');
}
```

### Fasilitas Model
```php
public function kategori(): BelongsTo {
    return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
}

public function kamar(): BelongsTo {
    return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
}
```

---

## 💾 Validasi & Constraints

### Store/Update Kamar:
```php
$validated = $request->validate([
    'nama_kamar' => 'required|string|max:100|unique:kamars',
    'id_kategori' => 'required|exists:categories,id',  // ← BARU
    'harga_permalam' => 'required|numeric|min:0',
    'stok' => 'required|integer|min:1',
    'ukuran_kamar' => 'nullable|string',
    'deskripsi' => 'nullable|string',
    'status_kamar' => 'nullable|in:Tersedia,Telah di reservasi,Maintenance',
    'image' => 'required|image|max:4096',
    'fasilitas' => 'nullable|array',             // ← BARU
    'fasilitas.*' => 'exists:fasilitas,id_fasilitas',  // ← BARU
]);
```

---

## 🧪 Testing

### Test 1: Buat Kategori dan Fasilitas
1. Masuk Admin Panel
2. Buka Kategori Management
3. Buat 3 kategori: "Standar", "Deluxe", "Suite"
4. Tambah fasilitas untuk masing-masing:
   - Standar: WiFi, AC
   - Deluxe: WiFi, AC, TV, Mini Bar
   - Suite: WiFi, AC, TV, Jacuzzi, Butler Service

### Test 2: Buat Kamar dengan Fasilitas
1. Buka Admin Rooms
2. Klik "Buat kamar baru"
3. Isi nama: "Kamar Deluxe 101"
4. Pilih kategori: "Deluxe"
5. ✅ Perhatikan fasilitas muncul (WiFi, AC, TV, Mini Bar)
6. Centang: WiFi, AC, TV
7. Isi data lainnya
8. Klik "Simpan kamar"
9. ✅ Verifikasi kamar tersimpan dengan fasilitas yang dipilih

### Test 3: Edit Kamar & Ganti Kategori
1. Edit kamar yang baru dibuat
2. Ganti kategori dari "Deluxe" ke "Suite"
3. ✅ Fasilitas berubah menjadi (WiFi, AC, TV, Jacuzzi, Butler Service)
4. Update dan verifikasi

---

## ⚙️ Maintenance & Troubleshooting

### Jika Fasilitas Tidak Muncul:
- ✅ Verifikasi API endpoint berfungsi: `http://localhost:8000/api/kategoris/1/fasilitas`
- ✅ Check browser console untuk error (F12)
- ✅ Pastikan kategori punya fasilitas di database

### Jika Migration Error:
```bash
php artisan migrate:rollback
php artisan migrate
```

### Reset Semua Data:
```bash
php artisan migrate:reset
php artisan migrate
```

---

## 📝 Catatan Penting

1. **Backward Compatibility**: Kolom `kategori` (string) tetap ada untuk compatibility dengan data lama
2. **Cascade Delete**: Menghapus kategori akan otomatis menghapus fasilitas terkait
3. **Soft Delete**: Fasilitas tidak di-soft delete, tapi di-hard delete
4. **Multiple Kamar**: Satu fasilitas bisa digunakan untuk multiple kamar
5. **Re-assignment**: Fasilitas yang sudah assigned ke kamar lama bisa di-unassign via update

---

## 🎯 Ringkasan Fitur

| Fitur | Status | Lokasi |
|-------|--------|--------|
| Manage Kategori | ✅ Done | Admin → Kategori |
| Manage Fasilitas | ✅ Done | Admin → Kategori |
| Create Kamar dengan Fasilitas | ✅ Done | Admin → Rooms |
| Edit Kamar dengan Fasilitas | ✅ Done | Admin → Rooms → Edit |
| Dynamic Fasilitas Dropdown | ✅ Done | Form (JavaScript) |
| API Endpoint Fasilitas | ✅ Done | `/api/kategoris/{id}/fasilitas` |
| Database Migration | ✅ Done | Migration file |

---

## 📞 Support

Jika ada pertanyaan atau masalah, cek:
1. Laravel Error Log: `storage/logs/laravel.log`
2. Browser Console: F12 → Console Tab
3. Database: Verifikasi data di categories, kamars, fasilitas table

---

**Happy coding! 🚀**
