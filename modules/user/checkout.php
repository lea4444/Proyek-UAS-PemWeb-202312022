]<?php
session_start();
require '../../config/database.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_date = date("Y-m-d H:i:s");
$status = 'pending';
$total = 0;

// Ambil data user dari tabel users
$queryUser = $conn->prepare("SELECT name, phone, address FROM users WHERE id = ?");
$queryUser->bind_param("i", $user_id);
$queryUser->execute();
$userData = $queryUser->get_result()->fetch_assoc();

// Cek apakah user sudah ada di tabel customers
$check = $conn->prepare("SELECT id FROM customers WHERE name = ? AND phone = ?");
$check->bind_param("ss", $userData['name'], $userData['phone']);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $customer_id = $row['id'];
} else {
    // Tambahkan ke tabel customers
    $stmt = $conn->prepare("INSERT INTO customers (name, phone, address) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $userData['name'], $userData['phone'], $userData['address']);
    if (!$stmt->execute()) {
        die("Gagal menambahkan customer: " . $stmt->error);
    }
    $customer_id = $stmt->insert_id;
}

// Hitung total harga dari cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Keranjang kosong.");
}

foreach ($_SESSION['cart'] as $book_id => $item) {
    $total += $item['price'] * $item['quantity'];
}

// Simpan order ke tabel orders
$stmt = $conn->prepare("INSERT INTO orders (customer_id, user_id, order_date, total, status) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Gagal mempersiapkan order: " . $conn->error);
}
$stmt->bind_param("iisss", $customer_id, $user_id, $order_date, $total, $status);
if (!$stmt->execute()) {
    die("Gagal menyimpan data pesanan: " . $stmt->error);
}
$order_id = $stmt->insert_id;

// Simpan item ke order_items
$stmtItem = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
if (!$stmtItem) {
    die("Gagal mempersiapkan item: " . $conn->error);
}

foreach ($_SESSION['cart'] as $book_id => $item) {
    $quantity = $item['quantity'];
    $subtotal = $item['price'] * $quantity;
    $stmtItem->bind_param("iiid", $order_id, $book_id, $quantity, $subtotal);
    if (!$stmtItem->execute()) {
        die("Gagal menyimpan item pesanan: " . $stmtItem->error);
    }
}

// Bersihkan keranjang
unset($_SESSION['cart']);

// Redirect atau tampilkan pesan sukses
echo "<script>alert('Checkout berhasil!'); window.location.href='orders.php';</script>";
?>
