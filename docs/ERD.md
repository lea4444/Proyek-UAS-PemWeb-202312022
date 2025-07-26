
# Entity Relationship Diagram (ERD) - Aplikasi Literaid

Diagram ini menggambarkan struktur database sistem aplikasi manajemen toko buku **Literaid**. Database terdiri dari beberapa tabel utama yang saling berelasi, digunakan untuk mengelola pengguna, buku, kategori, pesanan, pengembalian, dan aktivitas sistem.

---

## 📋 Tabel & Penjelasan

### 1. `users`
Menyimpan data pengguna sistem (admin dan user).
- `id` : Primary Key
- `name`, `email`, `password`, `photo`
- `role` : enum(`admin`, `user`)
- `created_at` : Timestamp pembuatan

### 2. `customers`
Informasi pelanggan toko buku.
- `id` : Primary Key
- `name`, `email`, `phone`, `address`

### 3. `categories`
Kategori buku seperti fiksi, non-fiksi, dll.
- `id` : Primary Key
- `name` : Nama kategori

### 4. `books`
Daftar buku yang tersedia.
- `id` : Primary Key
- `title`, `author`, `price`, `stock`, `cover`
- `category_id` : Relasi ke `categories`
- `created_at` : Timestamp

### 5. `orders`
Data transaksi pemesanan.
- `id` : Primary Key
- `customer_id` : Relasi ke `customers`
- `user_id` : Relasi ke `users`
- `order_date`, `total`, `status`

### 6. `order_items`
Item buku dalam pesanan.
- `id` : Primary Key
- `order_id` : Relasi ke `orders`
- `book_id` : Relasi ke `books`
- `quantity`, `price`

### 7. `returns`
Data pengembalian buku oleh pelanggan.
- `id` : Primary Key
- `order_id` : Relasi ke `orders`
- `reason`, `return_date`, `status`

### 8. `suppliers`
Informasi pemasok buku.
- `id` : Primary Key
- `name`, `phone`, `address`

### 9. `settings`
Pengaturan konfigurasi aplikasi.
- `id` : Primary Key
- `name`, `value`

### 10. `activity_logs`
Mencatat aktivitas pengguna.
- `id` : Primary Key
- `user_id` : Relasi ke `users`
- `activity`, `timestamp`

---

## 🔗 Relasi Antar Tabel

- `users` ➝ `orders`, `activity_logs`
- `customers` ➝ `orders`
- `orders` ➝ `order_items`, `returns`
- `books` ➝ `order_items`
- `categories` ➝ `books`
- `suppliers` ➝ Tidak langsung direlasikan (bisa ditambahkan ke `books`)

---

## 🧩 Catatan

- Setiap entitas menggunakan primary key `id` berbentuk integer auto-increment.
- Relasi antar entitas dirancang dengan **foreign key** untuk menjaga integritas data antar tabel (misalnya: `orders.customer_id → customers.id`).
- Beberapa kolom menggunakan tipe **ENUM** seperti `role` (admin/user), `status` (pending/paid/done), atau `return_status` (requested/approved/rejected) untuk memastikan nilai data yang konsisten dan valid.
- Tabel `activity_logs` mencatat semua aktivitas penting dari pengguna, terutama admin, demi kebutuhan audit atau keamanan.
- Struktur database ini fleksibel dan bisa dikembangkan lebih lanjut, misalnya dengan menambahkan sistem diskon, wishlist, atau rating buku.

---

> 🛠️ *Diagram ini dibuat menggunakan*: [dbdiagram.io](https://dbdiagram.io)  
> 📁 *Nama Proyek*: **Literaid**