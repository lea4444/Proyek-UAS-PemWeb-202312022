<?php
session_start();
require '../../config/database.php';

// Cek jika user belum login (optional)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// Ambil input dari form
$book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($book_id < 1 || $quantity < 1) {
    header("Location: shop.php?error=invalid_input");
    exit;
}

// Ambil data buku dari database
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    header("Location: shop.php?error=book_not_found");
    exit;
}

if ($book['stock'] < $quantity) {
    header("Location: shop.php?error=not_enough_stock");
    exit;
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Jika buku sudah ada di keranjang, tambahkan jumlahnya
if (isset($_SESSION['cart'][$book_id])) {
    $_SESSION['cart'][$book_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$book_id] = [
        'title' => $book['title'],
        'price' => (int)$book['price'],
        'image' => $book['image'],
        'category_id' => $book['category_id'],
        'quantity' => $quantity
    ];
}

// Kembali ke halaman belanja
header("Location: shop.php?success=1");
exit;
