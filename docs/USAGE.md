# 📚 Panduan Penggunaan Aplikasi Literaid

Dokumen ini menjelaskan cara menggunakan aplikasi **Literaid** (Toko Buku Online), mulai dari login sebagai admin atau user, hingga mengelola data buku, pesanan, pengembalian, laporan, dan pengaturan.

---

## 👥 Peran Pengguna (User Roles)

| Role      | Deskripsi                                                                 |
|-----------|--------------------------------------------------------------------------|
| **Admin** | Mengelola data buku, kategori, pengguna, pelanggan, pemasok, pengaturan, dan melihat laporan. |
| **User**  | Berbelanja buku, melihat riwayat pesanan, ajukan pengembalian, dan kelola profil pribadi.     |

---

## 🔐 Login & Registrasi

### User
- **Registrasi**: `auth/register.php` → Daftar akun baru
- **Login**: `auth/login.php` → Masuk akun user
- **Setelah login**: Dialihkan ke dashboard user (`user/dashboard.php`)

### Admin
- **Login**: `auth/login.php` → Masuk dengan role admin
- **Setelah login**: Dialihkan ke dashboard admin (`admin/dashboard.php`)

---

## 🛍️ Alur Penggunaan User (Pelanggan)

1. **Belanja Buku**
   - `user/shop.php`
   - Menampilkan daftar buku berdasarkan kategori

2. **Lihat Detail Buku**
   - Klik salah satu buku → menampilkan detail & deskripsi

3. **Tambah ke Keranjang**
   - Tombol "Tambah ke Keranjang" menyimpan buku ke `$_SESSION['cart']`

4. **Lihat Keranjang**
   - `cart.php` → Menampilkan isi keranjang, ubah jumlah atau hapus item

5. **Checkout**
   - `checkout.php`
   - Jika belum punya data customer → isi form nama, HP, alamat → simpan ke `customers`
   - Data transaksi disimpan ke `orders` dan `order_items`

6. **Riwayat Pesanan**
   - `user/orders.php` → Menampilkan pesanan user

7. **Detail Pesanan & Cetak Struk**
   - Klik salah satu pesanan → `orders_detail.php` → Cetak via `print_orders.php`

8. **Ajukan Pengembalian**
   - `user/returns.php` → Ajukan pengembalian buku jika pesanan bermasalah

9. **Profil Saya**
   - `user/profile.php` → Ubah data profil, ubah password, upload foto profil

---

## ⚙️ Alur Penggunaan Admin

1. **Dashboard Admin**
   - `admin/dashboard.php` → Ringkasan data dan grafik

2. **Manajemen Modul (CRUD)**
   - Users: `modules/users/`
   - Books: `modules/books/`
   - Categories: `modules/categories/`
   - Customers: `modules/customers/`
   - Orders: `modules/orders/`
   - Order Items: `modules/order_items/`
   - Returns: `modules/returns/`
   - Suppliers: `modules/suppliers/`
   - Settings: `modules/settings/`
   - Activity Logs: `modules/activity_logs/`

3. **Laporan**
   - Laporan Pesanan: `reports/orders_report.php`
   - Laporan Pengembalian: `reports/returns_report.php`
   - Laporan Pengguna: `reports/users_report.php`

---

## 🗃️ Struktur Database (Tabel Utama)

- `users` – Data admin dan user (login)
- `customers` – Data pelanggan (nama, no HP, alamat)
- `books` – Daftar buku (judul, penulis, harga, stok, gambar)
- `categories` – Kategori buku
- `orders` – Data transaksi pemesanan buku
- `order_items` – Detail item dalam tiap pesanan
- `returns` – Pengajuan pengembalian buku
- `suppliers` – Daftar pemasok buku
- `settings` – Pengaturan aplikasi (logo, info toko, dll)
- `activity_logs` – Catatan log aktivitas admin/user

---

## 🖼️ Gambar Buku

- Gambar buku disimpan di folder: `uploads/books/`
- Nama file disimpan di kolom `photo` pada tabel `books`

---

## 📝 Tips Penggunaan

- Pastikan file `literaid.sql` sudah di-*import* ke MySQL.
- Jalankan aplikasi di localhost menggunakan XAMPP atau Laragon.
- Jika session terlogout otomatis, periksa durasi session dan level akses.
- Gunakan akun admin untuk mengakses semua fitur backend.

