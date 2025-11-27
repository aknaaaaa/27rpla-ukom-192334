# Admin Kamar - Kategori dan Fasilitas Management

Fitur ini memungkinkan admin untuk mengelola kamar hotel dengan sistem kategori dan fasilitas yang dinamis.

## Fitur Utama

### 1. Manage Kategori
- Buat kategori kamar baru (contoh: Standar, Superior, Deluxe, dll)
- Edit nama kategori
- Hapus kategori beserta seluruh fasilitas yang terkait

Akses ke: **Admin > Kategori** atau route `/admin/kategori`

### 2. Manage Fasilitas per Kategori
- Tambah fasilitas untuk setiap kategori
- Edit atau hapus fasilitas
- Setiap fasilitas terikat ke kategori tertentu

### 3. Create/Edit Kamar dengan Fasilitas Dinamis

#### Alur Membuat Kamar Baru:
1. Klik tombol **"Buat kamar baru"**
2. Isi data kamar:
   - **Nama Kamar**: nama unik untuk kamar
   - **Kategori**: pilih kategori dari dropdown
3. Setelah memilih kategori, **daftar fasilitas akan otomatis muncul**
4. Pilih fasilitas yang tersedia untuk kamar ini
5. Isi data lainnya (harga, stok, status, deskripsi, gambar)
6. Klik **"Simpan kamar"**

#### Alur Edit Kamar:
1. Klik tombol **"Edit"** pada kamar yang ingin diubah
2. Ubah kategori jika diperlukan
3. Daftar fasilitas akan **otomatis update** sesuai kategori yang dipilih
4. Pilih ulang fasilitas yang diinginkan
5. Klik **"Update kamar"**

## Database Structure

### Tabel `categories`
```sql
- id (primary key)
- name (nama kategori)
- created_at
- updated_at
```

### Tabel `fasilitas`
```sql
- id_fasilitas (primary key)
- id_kategori (foreign key ke categories)
- id_kamar (foreign key ke kamars, nullable)
- nama_fasilitas
- nilai_fasilitas
- deskripsi
- created_at
- updated_at
```

### Tabel `kamars` (updated)
```sql
- id_kamar (primary key)
- id_kategori (foreign key ke categories, baru)
- kategori (string, tetap untuk compatibility)
- nama_kamar
- harga_permalam
- ukuran_kamar
- deskripsi
- gambar
- status_kamar
- stok
- created_at
- updated_at
```

## API Endpoints

### Get Fasilitas by Kategori
```
GET /api/kategoris/{kategoriId}/fasilitas
```
Mengembalikan daftar fasilitas untuk kategori tertentu.

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
    "deskripsi": "Pendingin ruangan"
  }
]
```

## Models Relationships

### Kategori Model
```php
- hasMany(Fasilitas) // Relasi ke fasilitas
```

### Kamar Model
```php
- belongsTo(Kategori) // Relasi ke kategori (kategoriRelasi)
- hasMany(Fasilitas) // Relasi ke fasilitas kamar
```

### Fasilitas Model
```php
- belongsTo(Kategori) // Relasi ke kategori
- belongsTo(Kamar) // Relasi ke kamar
```

## JavaScript Functions

### loadFasilitas()
Memuat daftar fasilitas berdasarkan kategori yang dipilih di dropdown.
- Triggered saat user mengganti kategori
- Fetch data dari API `/api/kategoris/{kategoriId}/fasilitas`
- Render checkbox untuk setiap fasilitas
- Jika tidak ada fasilitas, tampilkan pesan "Tidak ada fasilitas tersedia"

### openModal()
Membuka modal form untuk membuat kamar baru

### openEditModal(button)
Membuka modal form untuk edit kamar dan load fasilitas terkait

### resetForm()
Reset semua field form ke nilai default

## Cara Setup

1. Pastikan migration sudah di-run:
```bash
php artisan migrate
```

2. Seeder kategori dan fasilitas (opsional):
```bash
php artisan db:seed --class=KategoriSeeder
```

3. Routes sudah dikonfigurasi di `routes/api.php` dan `routes/web.php`

4. Controller: `AdminKamarController` dan `KategoriController`

## Tips Penggunaan

1. **Buat kategori terlebih dahulu** sebelum membuat kamar
2. **Tambah fasilitas untuk masing-masing kategori** agar tersedia saat membuat kamar
3. Satu fasilitas bisa **digunakan untuk multiple kamar** dalam kategori yang sama
4. Saat menghapus kategori, **semua fasilitas terkait juga akan terhapus**
5. Fasilitas yang sudah assigned ke kamar akan **tetap ada** meskipun kategorinya berubah

## Development Notes

- Gunakan API endpoint untuk fetch fasilitas secara real-time
- Frontend menggunakan vanilla JavaScript tanpa jQuery
- CSS styling sudah included di dalam file view
- Responsive design untuk mobile dan tablet
