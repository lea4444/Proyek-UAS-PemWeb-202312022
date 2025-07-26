<?php
session_start();
require '../../config/database.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil role user
$queryRole = "SELECT role FROM users WHERE id = ?";
$stmtRole = $conn->prepare($queryRole);
$stmtRole->bind_param("i", $user_id);
$stmtRole->execute();
$resultRole = $stmtRole->get_result();
$user = $resultRole->fetch_assoc();
$role = $user['role'] ?? 'user'; // default jika tidak ada

// Ambil daftar pesanan user
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f4e3;
            font-family: 'Georgia', serif;
            color: #3b2f2f;
        }

        h3 {
            font-weight: bold;
            border-bottom: 3px double #8b5e3c;
            padding-bottom: 10px;
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

        .table td {
            vertical-align: middle;
        }

        .alert-info {
            background-color: #fff8dc;
            border-color: #e6d3b3;
            color: #5c4033;
        }

        a.btn-info {
            background-color: #6b4226;
            color: #fff;
        }

        a.btn-info:hover {
            background-color: #915f3d;
        }

        .container {
            border: 1px solid #dec7a4;
            background-color: #fffdf7;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(139, 94, 60, 0.2);
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📚 Riwayat Pesanan</h3>
        <a href="../../<?= ($role === 'admin') ? 'admin' : 'user' ?>/dashboard.php" class="btn">🔙 Kembali ke Dashboard</a>
    </div>

    <?php if (empty($orders)) : ?>
        <div class="alert alert-info">Belum ada pesanan.</div>
    <?php else : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td>Rp<?= number_format($order['total'], 0, ',', '.') ?></td>
                        <td><?= $order['status'] ?></td>
                        <td>
                            <a href="orders_detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
