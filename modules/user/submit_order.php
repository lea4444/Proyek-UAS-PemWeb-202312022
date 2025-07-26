<?php
session_start();
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_ids = $_POST['book_id'];
    $quantities = $_POST['quantity'];

    if (empty($book_ids) || empty($quantities)) {
        die("Data tidak lengkap.");
    }

    // 1. Simpan ke tabel orders
    $order_date = date('Y-m-d H:i:s');
    $status = 'pending';
    $total = 0;

    // Hitung total dari cart
    foreach ($book_ids as $index => $book_id) {
        $quantity = (int) $quantities[$index];
        $query = "SELECT price FROM books WHERE id = ?";
        $stmt_price = $conn->prepare($query);
        $stmt_price->bind_param("i", $book_id);
        $stmt_price->execute();
        $stmt_price->bind_result($price);
        $stmt_price->fetch();
        $stmt_price->close();

        $total += $price * $quantity;
    }

    $stmt_order = $conn->prepare("INSERT INTO orders (user_id, order_date, status, total) VALUES (?, ?, ?, ?)");
    $stmt_order->bind_param("issi", $user_id, $order_date, $status, $total);
    if ($stmt_order->execute()) {
        $order_id = $stmt_order->insert_id;

        // 2. Simpan ke tabel order_items
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");

        foreach ($book_ids as $index => $book_id) {
            $quantity = (int) $quantities[$index];

            // Ambil harga buku lagi
            $query = "SELECT price FROM books WHERE id = ?";
            $stmt_price = $conn->prepare($query);
            $stmt_price->bind_param("i", $book_id);
            $stmt_price->execute();
            $stmt_price->bind_result($price);
            $stmt_price->fetch();
            $stmt_price->close();

            $stmt_item->bind_param("iiid", $order_id, $book_id, $quantity, $price);
            if (!$stmt_item->execute()) {
                die("Gagal menyimpan detail pesanan: " . $stmt_item->error);
            }
        }

        $stmt_item->close();
        $stmt_order->close();

        // 3. Hapus keranjang dari session
        unset($_SESSION['cart']);

        // 4. Redirect ke halaman riwayat pesanan
        header("Location: orders.php");
        exit;

    } else {
        die("Gagal menyimpan pesanan: " . $stmt_order->error);
    }
} else {
    header("Location: cart.php");
    exit;
}
?>
