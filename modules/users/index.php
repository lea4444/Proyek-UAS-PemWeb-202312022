<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<style>
    body {
        background: url('https://i.ibb.co/Jj5nbzs/old-paper-texture.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Georgia', serif;
        color: #4b3621;
    }

    h2 {
        font-size: 2rem;
        font-weight: bold;
        border-bottom: 2px dashed #a1887f;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    .container {
        background-color: rgba(255, 250, 240, 0.9);
        border: 1px solid #d7ccc8;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .btn-vintage {
        background-color: #d7ccc8;
        color: #3e2723;
        border: 1px solid #a1887f;
        border-radius: 6px;
        font-weight: bold;
        font-size: 14px;
        transition: 0.3s ease;
    }

    .btn-vintage:hover {
        background-color: #bcaaa4;
        color: #fff;
    }

    .table-vintage {
        background-color: #fffef9;
        border: 1px solid #d7ccc8;
    }

    .table-vintage th {
        background-color: #e0cfc1;
        color: #3e2723;
    }

    .table-vintage td {
        vertical-align: middle;
    }

    .table-vintage tr:hover {
        background-color: #f3e5ab;
    }

    .header-icon {
        color: #795548;
    }
</style>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-people-fill header-icon me-2"></i> Daftar Pengguna</h2>
        <a href="create.php" class="btn btn-vintage"><i class="bi bi-plus-circle me-1"></i> Tambah User</a>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-vintage text-center">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 25%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td class="text-capitalize"><?= $row['role']; ?></td>
                    <td>
                        <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-vintage">Detail</a>
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-vintage">Edit</a>
                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-vintage"
                           onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
