<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$result = mysqli_query($conn, "SELECT * FROM customers");
?>

<style>
    body {
        background: #f4ecd8;
        font-family: 'Georgia', serif;
    }

    .vintage-heading {
        font-family: 'Georgia', serif;
        font-weight: bold;
        font-size: 28px;
        color: #3e2c1c;
        border-bottom: 3px double #b19777;
        padding-bottom: 10px;
        margin-bottom: 25px;
        text-shadow: 1px 1px 0 #eee;
    }

    .vintage-btn {
        font-family: 'Georgia', serif;
        border-radius: 6px;
        background-color: #d9c5a0;
        border: 1px solid #a89274;
        color: #3e2c1c;
        transition: 0.2s;
    }

    .vintage-btn:hover {
        background-color: #cdb48c;
        color: #000;
    }

    .vintage-card {
        background-color: #fdf9f1;
        border: 2px solid #cab797;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
    }

    .vintage-table thead {
        background-color: #e3d3b3;
        color: #3e2c1c;
        font-weight: bold;
        border-bottom: 2px solid #bba07a;
    }

    .vintage-table tbody tr {
        border-bottom: 1px solid #e6d5b7;
    }

    .vintage-table tbody tr:hover {
        background-color: #f5efe3;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .btn-icon i {
        margin-right: 4px;
    }
</style>

<div class="container py-4">
    <h2 class="vintage-heading">
        <i class="bi bi-person-lines-fill me-2"></i> Daftar Pelanggan
    </h2>

    <a href="create.php" class="btn vintage-btn btn-icon mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Pelanggan
    </a>

    <div class="vintage-card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center vintage-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td class="text-start"><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['phone']); ?></td>
                            <td class="text-start"><?= htmlspecialchars($row['address']); ?></td>
                            <td>
                                <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-sm vintage-btn btn-icon me-1">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm vintage-btn btn-icon me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm vintage-btn btn-icon"
                                   onclick="return confirm('Yakin hapus pelanggan ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($result) === 0): ?>
                        <tr>
                            <td colspan="5" class="text-muted fst-italic">Belum ada data pelanggan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
