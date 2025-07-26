<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$query = "
    SELECT o.*, c.name AS customer_name, u.username 
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.order_date DESC
";
$result = mysqli_query($conn, $query);
?>

<div class="container py-4" style="font-family: 'Georgia', serif;">
    <h2 class="fw-bold text-secondary mb-4 border-bottom border-2 pb-2" style="font-style: italic;">
        <i class="bi bi-receipt-cutoff"></i> Daftar Transaksi
    </h2>

    <a href="create.php" class="btn btn-outline-success mb-3">
        <i class="bi bi-plus-circle"></i> Buat Transaksi
    </a>

    <div class="card shadow border-2 border-dark" style="background-color: #fefcf8;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" style="background-color: #fffdf8;">
                    <thead class="table-warning" style="font-weight: bold;">
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Admin</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= date('d M Y', strtotime($row['order_date'])) ?></td>
                            <td class="text-end"><?= 'Rp ' . number_format($row['total'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge 
                                    <?= $row['status'] == 'pending' ? 'bg-secondary' : 
                                        ($row['status'] == 'paid' ? 'bg-warning text-dark' : 
                                        'bg-success') ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($result) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-muted fst-italic">Belum ada transaksi.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
