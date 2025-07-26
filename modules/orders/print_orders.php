<?php
require '../../config/database.php';

$id = intval($_GET['id']);
$order = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT o.*, c.name AS customer_name, u.username 
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    LEFT JOIN users u ON o.user_id = u.id
    WHERE o.id = $id
"));

$items = mysqli_query($conn, "
    SELECT oi.*, b.title, b.price 
    FROM order_items oi
    LEFT JOIN books b ON oi.book_id = b.id
    WHERE oi.order_id = $id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi #<?= $order['id'] ?></title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f8f5f0;
            color: #3e3e3e;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 28px;
            color: #6a4e42;
        }

        .header small {
            font-style: italic;
            color: #7c6f64;
        }

        .info {
            background-color: #fdfaf6;
            border: 2px dashed #bba58f;
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .info p {
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fffefa;
            font-size: 15px;
        }

        th, td {
            border: 1px solid #bfae9f;
            padding: 10px;
        }

        th {
            background-color: #e6ded3;
            color: #4a3c32;
        }

        tr:nth-child(even) {
            background-color: #f9f5f0;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 17px;
            margin-top: 20px;
            color: #5a4638;
        }

        .no-print {
            margin-top: 30px;
            text-align: center;
        }

        .no-print button, .no-print a {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            margin: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }

        .no-print button {
            background-color: #6c4f3d;
        }

        .no-print a {
            background-color: #4a372d;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Literaid Bookstore</h2>
        <small>Struk Transaksi</small>
    </div>

    <div class="info">
        <p><strong>ID Pesanan:</strong> #<?= htmlspecialchars($order['id']) ?></p>
        <p><strong>Pelanggan:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Admin:</strong> <?= htmlspecialchars($order['username']) ?></p>
        <p><strong>Tanggal:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $grand_total = 0; while($item = mysqli_fetch_assoc($items)):
                $subtotal = $item['price'] * $item['quantity'];
                $grand_total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p class="total">Total: Rp<?= number_format($grand_total, 0, ',', '.') ?></p>

    <div class="no-print">
        <button onclick="window.print()">🖨 Cetak</button>
        <a href="index.php">← Kembali</a>
    </div>

</body>
</html>
