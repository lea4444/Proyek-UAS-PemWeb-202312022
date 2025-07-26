<?php
session_start();
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<script>alert('Keranjang kosong!'); window.location.href='shop.php';</script>";
    exit;
}

$total = 0;
foreach ($cart as $book_id => $qty) {
    $book_id = intval($book_id);
    $qty = intval($qty);
    $result = mysqli_query($conn, "SELECT price FROM books WHERE id = $book_id");
    $row = mysqli_fetch_assoc($result);
    $total += $row['price'] * $qty;
}

$order_query = "INSERT INTO orders (customer_id, user_id, order_date, total, status) 
                VALUES ($user_id, NULL, NOW(), $total, 'pending')";
mysqli_query($conn, $order_query);
$order_id = mysqli_insert_id($conn);

foreach ($cart as $book_id => $qty) {
    $book_id = intval($book_id);
    $qty = intval($qty);
    $result = mysqli_query($conn, "SELECT price FROM books WHERE id = $book_id");
    $row = mysqli_fetch_assoc($result);
    $price = $row['price'];

    $query = "INSERT INTO order_items (order_id, book_id, quantity, price) 
              VALUES ($order_id, $book_id, $qty, $price)";
    mysqli_query($conn, $query);
}

unset($_SESSION['cart']);

include_once __DIR__ . '/../../modules/activity_logs/functions.php';
log_activity($conn, $user_id, 'Melakukan checkout dan membuat pesanan');

echo "<script>alert('Checkout berhasil!'); window.location.href='orders.php';</script>";
