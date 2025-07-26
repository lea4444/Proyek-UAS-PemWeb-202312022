<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$query = "SELECT * FROM settings ORDER BY name ASC";
$result = mysqli_query($conn, $query);
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

    .form-control {
        font-family: 'Georgia', serif;
        font-size: 0.95rem;
    }

    .btn-vintage {
        background-color: #7b5e42;
        color: #fff;
        border: none;
    }

    .btn-vintage:hover {
        background-color: #5c4433;
    }

    .btn-sm {
        font-size: 0.8rem;
        padding: 3px 10px;
    }
</style>

<div class="container py-4">
    <div class="vintage-header d-flex justify-content-between align-items-center">
        <h2 class="fw-bold m-0">
            <i class="bi bi-gear-fill me-2"></i> Pengaturan Aplikasi
        </h2>
        <a href="create.php" class="btn btn-vintage btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah
        </a>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success">Perubahan berhasil disimpan.</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
        <div class="alert alert-success">Pengaturan berhasil dihapus.</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'notfound'): ?>
        <div class="alert alert-danger">Data tidak ditemukan.</div>
    <?php endif; ?>

    <form method="POST" action="save.php">
        <div class="card vintage-card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle vintage-table">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 30%;">Nama Pengaturan</th>
                                <th>Nilai</th>
                                <th style="width: 18%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td>
                                    <input type="text" class="form-control" name="settings[<?= $row['id'] ?>]" value="<?= htmlspecialchars($row['value']) ?>">
                                </td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus pengaturan ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if (mysqli_num_rows($result) === 0): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada pengaturan tersedia.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-vintage px-4">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
