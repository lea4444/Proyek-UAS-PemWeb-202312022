<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

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

<div class="container mt-5" style="font-family: 'Georgia', serif;">
    <div class="card shadow-sm border-0" style="background-color: #fdf6ec;">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">📄 Detail Transaksi #<?= htmlspecialchars($order['id']) ?></h4>
        </div>

        <div class="card-body">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-white h-100">
                        <h6 class="text-muted mb-2">🧑 Pelanggan</h6>
                        <p class="mb-0"><?= htmlspecialchars($order['customer_name']) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-white h-100">
                        <h6 class="text-muted mb-2">👤 Admin</h6>
                        <p class="mb-0"><?= htmlspecialchars($order['username']) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-white h-100">
                        <h6 class="text-muted mb-2">📅 Tanggal Pemesanan</h6>
                        <p class="mb-0"><?= htmlspecialchars($order['order_date']) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-white h-100">
                        <h6 class="text-muted mb-2">📦 Status</h6>
                        <span class="badge bg-<?= $order['status'] === 'paid' ? 'success' : ($order['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                            <?= htmlspecialchars(strtoupper($order['status'])) ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="p-3 border rounded bg-white h-100">
                        <h6 class="text-muted mb-2">💰 Total Pembayaran</h6>
                        <p class="mb-0 fs-5 fw-bold">Rp<?= number_format($order['total'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>

            <h5 class="mb-3">📚 Daftar Buku</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($item = mysqli_fetch_assoc($items)): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['title']) ?></td>
                            <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-secondary">← Kembali</a>
                <a href="print_orders.php?id=<?= $order['id'] ?>" target="_blank" class="btn btn-primary">🖨️ Cetak Struk</a>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
