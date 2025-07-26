<?php
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Hitung total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Literaid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff9e6;
            font-family: 'Georgia', serif;
        }
        .table thead {
            background-color: #ffe28a;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <h2 class="mb-4">🛒 Keranjang Belanja Anda</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Buku berhasil ditambahkan ke keranjang.</div>
    <?php endif; ?>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-warning">Keranjang belanja Anda masih kosong. <a href="shop.php">Belanja sekarang</a></div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rp<?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>Rp<?= number_format($total, 0, ',', '.') ?></th>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <a href="shop.php" class="btn btn-secondary">← Lanjut Belanja</a>
            <div>
                <a href="clear_cart.php" class="btn btn-danger" onclick="return confirm('Kosongkan keranjang?')">🗑 Hapus Keranjang</a>
                <a href="checkout.php" class="btn btn-success">💳 Checkout Sekarang</a>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
