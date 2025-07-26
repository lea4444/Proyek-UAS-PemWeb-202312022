<?php
session_start();
require '../../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_item_id = $_POST['order_item_id'];
    $reason = $_POST['reason'];

    // Validasi input
    if (empty($order_item_id) || empty($reason)) {
        die("Data tidak lengkap.");
    }

    // Simpan ke tabel returns (tanpa kolom status)
    $query = "INSERT INTO returns (order_item_id, reason, return_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $order_item_id, $reason);

    if ($stmt->execute()) {
        echo "<script>alert('Permintaan pengembalian berhasil dikirim.'); window.location.href='returns.php';</script>";
    } else {
        echo "Gagal menyimpan pengembalian: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
