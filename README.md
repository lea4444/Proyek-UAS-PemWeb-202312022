# 📚 Literaid - Aplikasi Web Toko Buku

Literaid adalah aplikasi web toko buku berbasis PHP dan MySQL yang dirancang untuk mempermudah proses pengelolaan data buku, transaksi penjualan, pelanggan, serta pelaporan. Aplikasi ini mendukung peran admin dan pengguna biasa, dengan antarmuka modern menggunakan Bootstrap.

---

## 🔍 Fitur Utama

### 🔐 Autentikasi
- Login & Logout menggunakan session
- Role-based access control: `admin` dan `user`

### 🧑‍💼 Fitur Admin
- Dashboard statistik penjualan & data pengguna
- CRUD Data:
  - Buku (`modules/books`)
  - Kategori (`modules/categories`)
  - Pelanggan (`modules/customers`)
  - User (`modules/users`)
  - Supplier (`modules/suppliers`)
  - Log Aktivitas (`modules/activity_logs`)
- Monitoring Pesanan & Pengembalian
- Laporan Transaksi & Export Struk

### 👤 Fitur Pengguna
- Belanja Buku & Tambah ke Keranjang (`user/shop.php`)
- Lihat Riwayat Pesanan (`user/orders.php`)
- Ajukan Pengembalian Buku (`user/returns.php`)
- Kelola Profil dan Foto (`user/profile.php`)
- Ubah Password

### 🌐 Lainnya
- Upload gambar buku, profil
- Desain responsif menggunakan Bootstrap
- Struktur database relasional terstruktur
- Navigasi menu interaktif & estetika klasik (dashboard user)

---

## 🗂️ Struktur Folder

```
literaid/
├── admin/               → (Opsional) Admin interface tambahan
├── assets/              → Gambar, CSS, JS, ikon
├── auth/                → Login, logout, dan proteksi session
├── config/              → Koneksi database (`database.php`)
├── docs/                → Dokumentasi dan gambar ERD
│   ├── ERD.png
│   ├── INSTALLATION.md
│   └── UGASE.md
├── includes/            → File umum seperti header, navbar, footer
├── modules/             → Modul CRUD (users, books, orders, dll)
├── sql/                 → Struktur database SQL
│   └── literaid.sql
├── uploads/             → Upload gambar buku dan user
├── user/                → Dashboard dan fitur pengguna biasa
│   ├── shop.php
│   ├── orders.php
│   ├── returns.php
│   └── profile.php
├── index.php            → Landing page
├── hash.php             → Tools hashing password
├── test_hash.php        → Uji hash password
└── README.md
```

---

## 💻 Teknologi

- **PHP** 7.4+
- **MySQL** 5.7+
- **Bootstrap** 4/5
- **HTML5**, **CSS3**
- **JavaScript** (vanilla)

---

## ⚙️ Cara Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/lea4444/Proyek-UAS-PemWeb-202312022.git
cd literaid
```

2. **Import Database**
- Buka phpMyAdmin
- Buat database baru `literaid`
- Import file `sql/literaid.sql`

3. **Jalankan Aplikasi**
- Pindahkan folder `literaid/` ke dalam folder `htdocs/` (XAMPP)
- Buka di browser:
```
http://localhost/literaid/index.php
```

---

## 👥 Akun Default (Opsional)

| Role  | Email              | Password   |
|-------|--------------------|------------|
| Admin | admin@example.com  | admin123   |
| User  | user@example.com   | user123    |

---

## 🗺️ Entity Relationship Diagram (ERD)

![ERD](./docs/ERD.png)

---

## 📌 Contoh Commit Message

```
[Fitur] Tambah keranjang belanja dan checkout
[Fix] Perbaikan validasi login
[Update] Dashboard admin kategori dan laporan
[Docs] Tambah README dan ERD
```

---

## 🧾 Lisensi

Aplikasi ini dibuat untuk keperluan pembelajaran akademik.

---

## 📬 Kontak

- **Nama:** Vilea Fernanda
- **NIM:** 202312022
- **Program Studi:** Teknik Informatika
- **Repo GitHub:** https://github.com/lea4444/Proyek-UAS-PemWeb-202312022.git