# Quick Start - Admin Kamar Kategori & Fasilitas

## 🚀 Quick Setup (5 Menit)

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Buat Kategori (via Artisan Tinker)
```bash
php artisan tinker
```

```php
use App\Models\Kategori;

Kategori::create(['name' => 'Standar']);
Kategori::create(['name' => 'Superior']);
Kategori::create(['name' => 'Deluxe']);
```

### 3. Buat Fasilitas via Admin Panel
- Buka: `http://localhost:8000/admin/kategori`
- Klik kategori → Tambah Fasilitas
- Contoh:
  - **Standar**: WiFi, AC, TV
  - **Deluxe**: WiFi, AC, TV, Mini Bar, AC Premium

### 4. Test Buat Kamar
- Buka: `http://localhost:8000/admin/rooms`
- Klik "Buat kamar baru"
- Pilih kategori → Fasilitas otomatis muncul!
- Centang fasilitas yang diinginkan
- Submit

---

## 📁 File Penting

| File | Tujuan |
|------|--------|
| `app/Models/Kategori.php` | Model kategori |
| `app/Models/kamar.php` | Model kamar (updated) |
| `app/Models/fasilitas.php` | Model fasilitas (updated) |
| `app/Http/Controllers/AdminKamarController.php` | Controller kamar (updated) |
| `routes/api.php` | API endpoint (updated) |
| `resources/views/admin/rooms/index.blade.php` | UI kamar (updated) |

---

## 🔗 API Endpoint

```
GET /api/kategoris/{kategoriId}/fasilitas
```

Contoh:
```
GET /api/kategoris/1/fasilitas
```

Response:
```json
[
  {"id_fasilitas": 1, "nama_fasilitas": "WiFi", "deskripsi": "..."},
  {"id_fasilitas": 2, "nama_fasilitas": "AC", "deskripsi": null}
]
```

---

## 🎯 Workflow

### Create Kamar
```
1. Klik "Buat kamar baru"
2. Isi Nama Kamar
3. Pilih Kategori (fasilitas muncul otomatis)
4. Centang Fasilitas yang diinginkan
5. Isi data lain (harga, stok, status, deskripsi, image)
6. Submit → Kamar tersimpan dengan fasilitas
```

### Edit Kamar
```
1. Klik "Edit" pada kamar
2. Bisa ubah kategori
3. Fasilitas otomatis update sesuai kategori baru
4. Re-select fasilitas yang diinginkan
5. Submit → Kamar ter-update
```

### Manage Fasilitas
```
1. Buka Admin > Kategori
2. Klik kategori yang ingin diisi fasilitas
3. Klik "Tambah Fasilitas"
4. Isi nama & deskripsi
5. Submit
```

---

## ✨ Fitur Utama

✅ Dynamic kategori dropdown di form kamar  
✅ Fasilitas muncul otomatis saat kategori dipilih (via AJAX)  
✅ Multi-select checkbox untuk fasilitas  
✅ Full CRUD untuk kategori & fasilitas  
✅ Fasilitas ditampilkan di kamar card  
✅ Responsive design untuk mobile  

---

## 🛠️ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Fasilitas tidak muncul | Pastikan kategori punya fasilitas di database |
| API error 404 | Jalankan `php artisan serve` |
| Kategori tidak ada di dropdown | Buat kategori terlebih dahulu |
| Database error | Run `php artisan migrate` |

---

## 📚 Full Documentation

Lihat file: `PANDUAN_LENGKAP_ADMIN_KAMAR.md`

---

**Ready to go! 🎉**
