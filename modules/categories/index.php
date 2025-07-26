<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$result = mysqli_query($conn, "SELECT * FROM categories");
?>

<style>
    .vintage-card {
        background-color: #fcf8f3;
        border: 2px solid #d3c7b2;
        border-radius: 10px;
        font-family: 'Georgia', serif;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .vintage-heading {
        font-family: 'Georgia', serif;
        color: #5b4636;
        border-bottom: 2px solid #d3c7b2;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .vintage-btn {
        font-family: 'Georgia', serif;
        border-radius: 8px;
    }

    .vintage-table thead {
        background-color: #e5d8c6;
        color: #3b2f2f;
    }

    .vintage-table tbody tr:hover {
        background-color: #f3ece2;
    }
</style>

<div class="container py-4">
    <h2 class="vintage-heading"><i class="bi bi-bookmarks-fill me-2"></i>Daftar Kategori Buku</h2>

    <a href="create.php" class="btn btn-outline-success vintage-btn mb-3">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
    </a>

    <div class="card vintage-card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center vintage-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th>Nama Kategori</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td class="text-start"><?= htmlspecialchars($row['name']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning vintage-btn me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger vintage-btn"
                                       onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-muted fst-italic">Belum ada kategori yang ditambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
