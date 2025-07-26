<?php
session_start();
require '../../config/database.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$order_id = intval($_GET['id'] ?? 0);

// Ambil data order dan customer
$query = "
    SELECT o.*, c.name AS customer_name, c.address, c.phone
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    WHERE o.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Ambil data item pesanan
$queryItems = "
    SELECT oi.*, b.title, b.price 
    FROM order_items oi
    JOIN books b ON oi.book_id = b.id
    WHERE oi.order_id = ?
";
$stmtItems = $conn->prepare($queryItems);
$stmtItems->bind_param("i", $order_id);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #<?= $order['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f4e3;
            font-family: 'Georgia', serif;
            color: #3b2f2f;
        }
        h3 {
            border-bottom: 2px dashed #8b5e3c;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #fffdf7;
            border: 1px solid #dec7a4;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(139, 94, 60, 0.2);
        }
        .btn {
            font-family: 'Courier New', monospace;
            background-color: #8b5e3c;
            color: #fff;
            border: none;
        }
        .btn:hover {
            background-color: #a9745d;
        }
        .table {
            background-color: #fffaf0;
            border: 1px solid #d2b48c;
        }
        .table th {
            background-color: #e0c097;
            color: #3b2f2f;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="card p-4">
        <h3>🧾 Detail Pesanan #<?= $order['id'] ?></h3>
        <p><strong>Nama:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>
        <p><strong>No. Telepon:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p><strong>Tanggal:</strong> <?= $order['order_date'] ?></p>
        <p><strong>Status:</strong> <?= $order['status'] ?></p>
        <p><strong>Total:</strong> Rp<?= number_format($order['total'], 0, ',', '.') ?></p>

        <hr>
        <h5>📚 Daftar Buku</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $resultItems->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp<?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="orders.php" class="btn mt-3">🔙 Kembali ke Riwayat</a>
    </div>
</div>
</body>
</html>
