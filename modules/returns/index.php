<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$query = "
    SELECT r.*, b.title, o.id AS order_id
    FROM returns r
    LEFT JOIN order_items oi ON r.order_item_id = oi.id
    LEFT JOIN books b ON oi.book_id = b.id
    LEFT JOIN orders o ON oi.order_id = o.id
    ORDER BY r.return_date DESC
";

$result = mysqli_query($conn, $query);
?>

<style>
    body {
        background-color: #f9f5ec;
        font-family: 'Georgia', serif;
    }
    .vintage-heading {
        color: #5c3a21;
        border-bottom: 3px double #c8b08a;
        padding-bottom: 10px;
    }
    .vintage-card {
        background: linear-gradient(to bottom, #fdfaf6, #f4ede3);
        border: 2px solid #c8b08a;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
    }
    .vintage-table thead {
        background-color: #e5d2b8;
        color: #5c3a21;
    }
    .vintage-table tbody tr:hover {
        background-color: #f1e7d0;
    }
    .btn-outline-primary {
        border-color: #a1866f;
        color: #5c3a21;
    }
    .btn-outline-primary:hover {
        background-color: #a1866f;
        color: white;
    }
    .btn-outline-danger {
        border-color: #b76e79;
        color: #752f3e;
    }
    .btn-outline-danger:hover {
        background-color: #b76e79;
        color: white;
    }
</style>

<div class="container py-4">
    <h2 class="fw-bold vintage-heading mb-4">
        <i class="bi bi-arrow-return-left"></i> Daftar Retur Buku
    </h2>

    <a href="create.php" class="btn btn-outline-primary mb-3">+ Tambah Retur</a>

    <div class="card vintage-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle vintage-table">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Judul Buku</th>
                            <th>Alasan</th>
                            <th>Tanggal Retur</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td class="text-center"><?= $row['id'] ?></td>
                            <td class="text-center">#<?= $row['order_id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['reason']) ?></td>
                            <td><?= date('d M Y', strtotime($row['return_date'])) ?></td>
                            <td class="text-center">
                                <a href="delete.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Hapus retur ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile ?>
                        <?php if (mysqli_num_rows($result) === 0): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data retur.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
