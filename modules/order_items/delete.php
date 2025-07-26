<?php
include '../../includes/auth.php';
include '../../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data order_items terlebih dahulu
    $item = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT * FROM order_items WHERE id = $id
    "));

    if ($item) {
        $order_id = $item['order_id'];
        $book_id = $item['book_id'];
        $quantity = $item['quantity'];
        $subtotal = $item['subtotal'];

        // Kembalikan stok buku
        mysqli_query($conn, "
            UPDATE books SET stock = stock + $quantity WHERE id = $book_id
        ");

        // Kurangi total pada tabel orders
        mysqli_query($conn, "
            UPDATE orders SET total = total - $subtotal WHERE id = $order_id
        ");

        // Hapus item dari order_items
        mysqli_query($conn, "DELETE FROM order_items WHERE id = $id");
    }
}

header("Location: index.php");
exit;
