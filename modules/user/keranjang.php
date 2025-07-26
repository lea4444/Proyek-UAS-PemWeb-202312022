<?php
session_start();
require '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$books = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_map('intval', array_keys($cart)));
    $result = mysqli_query($conn, "SELECT * FROM books WHERE id IN ($ids)");

    while ($row = mysqli_fetch_assoc($result)) {
        $book_id = $row['id'];
        $quantity = isset($cart[$book_id]) ? (int)$cart[$book_id] : 1;
        $price = isset($row['price']) ? (int)$row['price'] : 0;

        $row['quantity'] = $quantity;
        $row['subtotal'] = $price * $quantity;

        $books[] = $row;
        $total += $row['subtotal'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f5ec;
            font-family: 'Georgia', serif;
            color: #4b3621;
        }
        .vintage-box {
            background-color: #fffaf0;
            border: 2px solid #d2b48c;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead {
            background-color: #f5e4c3;
        }
        .btn-vintage {
            background-color: #a67c52;
            color: #fff;
            border: none;
        }
        .btn-vintage:hover {
            background-color: #8b5e3c;
        }
        h3 {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-control {
            background-color: #fdf6ec;
            border: 1px solid #c8b08b;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="vintage-box">
        <h3>🛒 Keranjang Belanja</h3>

        <?php if (empty($books)): ?>
            <div class="alert alert-warning">Keranjang kosong.</div>
            <a href="shop.php" class="btn btn-secondary">← Kembali Belanja</a>
        <?php else: ?>
            <form action="submit_order.php" method="POST">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td style="width: 100px;">
                                    <input type="hidden" name="book_id[]" value="<?= $book['id'] ?>">
                                    <input type="number" name="quantity[]" value="<?= $book['quantity'] ?>" min="1" class="form-control" required>
                                </td>
                                <td>Rp<?= number_format($book['price'], 0, ',', '.') ?></td>
                                <td>Rp<?= number_format($book['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h5 class="mt-3">Total: <strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></h5>
                <div class="mt-3">
                    <button type="submit" class="btn btn-vintage">🧾 Checkout</button>
                    <a href="shop.php" class="btn btn-secondary">← Lanjut Belanja</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
