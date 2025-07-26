<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

// Ambil data item pesanan
$query = "
    SELECT 
        oi.*, 
        o.id AS order_number, 
        b.title, 
        (oi.quantity * oi.price) AS subtotal 
    FROM order_items oi
    LEFT JOIN orders o ON oi.order_id = o.id
    LEFT JOIN books b ON oi.book_id = b.id
    ORDER BY oi.id DESC
";
$result = mysqli_query($conn, $query);
?>

<style>
    body {
        background-color: #f9f5e9;
        font-family: 'Georgia', serif;
        color: #333;
    }

    .vintage-card {
        background: #fffef9;
        border: 1px solid #d8cfc4;
        box-shadow: 0 4px 8px rgba(128, 96, 56, 0.1);
        border-radius: 8px;
    }

    .vintage-title {
        font-family: 'Georgia', serif;
        font-size: 24px;
        font-weight: bold;
        color: #5c4328;
        border-bottom: 2px solid #d3bfa4;
        padding-bottom: 8px;
        margin-bottom: 16px;
    }

    .vintage-button {
        background-color: #c8a97e;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
    }

    .vintage-button:hover {
        background-color: #a67c52;
        color: white;
    }

    table.vintage-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        background-color: #fffefc;
    }

    table.vintage-table th, table.vintage-table td {
        border: 1px solid #c8b49a;
        padding: 10px;
        text-align: center;
    }

    table.vintage-table th {
        background-color: #f1e5cd;
        color: #5a3c20;
    }

    .no-data {
        font-style: italic;
        color: #888;
        padding: 20px 0;
    }
</style>

<div class="container py-4">
    <div class="vintage-title">
        <i class="bi bi-cart-check"></i> Daftar Item Pesanan
    </div>

    <a href="create.php" class="vintage-button mb-3 d-inline-block">+ Tambah Item Manual</a>

    <div class="vintage-card p-3">
        <div class="table-responsive">
            <table class="vintage-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Judul Buku</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td>#<?= $row['order_number'] ?></td>
                        <td style="text-align: left;"><?= htmlspecialchars($row['title']) ?></td>
                        <td style="text-align: right;">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td style="text-align: right;">Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                        <td>
                            <a href="delete.php?id=<?= $row['id'] ?>" 
                               class="vintage-button btn-sm"
                               onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr>
                        <td colspan="7" class="no-data">Belum ada item pesanan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
