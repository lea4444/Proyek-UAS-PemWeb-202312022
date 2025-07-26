# 📦 INSTALLATION - Literaid

Dokumentasi instalasi aplikasi web Literaid.

---

## 🖥️ Persyaratan Sistem

- PHP 7.4 atau lebih baru
- MySQL 5.7 atau lebih baru
- Apache Web Server (rekomendasi: XAMPP)
- Browser modern (Chrome, Firefox, Edge)

---

## ⚙️ Langkah-Langkah Instalasi

### 1. Clone atau Download Proyek
```
git clone https://github.com/lea4444/Proyek-UAS-PemWeb-202312022.git
```

Atau unduh file ZIP dari GitHub dan ekstrak ke folder `htdocs`.

### 2. Konfigurasi Database
- Buka `phpMyAdmin`
- Buat database baru: `literaid`
- Import file `sql/literaid.sql`

### 3. Jalankan Aplikasi
- Buka browser dan akses:
```
http://localhost/literaid/index.php
```

---

## 🛠️ Konfigurasi Tambahan

- Pastikan file `config/database.php` sudah sesuai:
```php
$host = 'localhost';
$db   = 'literaid';
$user = 'root';
$pass = '';
```

- Folder `uploads/` harus bisa ditulis untuk menyimpan gambar.