<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$result = mysqli_query($conn, "SELECT * FROM suppliers");
?>

<style>
    body {
        background-color: #f3efe3;
        font-family: 'Georgia', serif;
    }

    .vintage-header {
        background-color: #d7c8b6;
        padding: 10px 20px;
        border-left: 10px solid #7b5e42;
        border-radius: 8px;
        color: #4b3621;
        margin-bottom: 20px;
    }

    .vintage-card {
        background-color: #fdfaf6;
        border: 1px solid #b6a489;
        border-radius: 8px;
    }

    .vintage-table thead {
        background-color: #e8dccb;
        color: #5c4433;
    }

    .btn-outline-primary {
        border-color: #7b5e42;
        color: #7b5e42;
    }

    .btn-outline-primary:hover {
        background-color: #7b5e42;
        color: white;
    }

    .btn-outline-secondary, .btn-outline-danger {
        font-size: 0.875rem;
    }
</style>

<div class="container py-4">
    <div class="vintage-header">
        <h2 class="fw-bold m-0">
            📚 Daftar Penerbit / Supplier
        </h2>
    </div>

    <a href="create.php" class="btn btn-outline-primary mb-3">+ Tambah Supplier</a>

    <div class="card vintage-card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle vintage-table">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="text-center"><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['contact']); ?></td>
                            <td><?= htmlspecialchars($row['address']); ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($result) === 0): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data supplier.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
