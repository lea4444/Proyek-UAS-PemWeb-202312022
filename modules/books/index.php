<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
include '../../includes/header.php';

$query = "SELECT books.id, books.title, books.author, books.price, categories.name AS category 
          FROM books 
          LEFT JOIN categories ON books.category_id = categories.id 
          ORDER BY books.id ASC";
$result = mysqli_query($conn, $query);

// Fungsi format rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>

<style>
    body {
        background: url('https://i.ibb.co/Jj5nbzs/old-paper-texture.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Georgia', serif;
        color: #4b3621;
    }

    .container {
        background-color: rgba(255, 250, 240, 0.95);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        margin-top: 40px;
    }

    h2 {
        font-weight: bold;
        color: #5d4037;
        border-bottom: 2px dashed #a1887f;
        padding-bottom: 10px;
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
        font-weight: bold;
    }

    .table-vintage td {
        vertical-align: middle;
    }

    .table-vintage tr:hover {
        background-color: #f5e6cc;
    }

    .card {
        border-radius: 10px;
    }

    .btn-outline-info, .btn-outline-warning, .btn-outline-danger {
        font-weight: bold;
    }

    .btn-outline-info:hover {
        background-color: #4dd0e1;
        color: white;
    }

    .btn-outline-warning:hover {
        background-color: #ffb74d;
        color: white;
    }

    .btn-outline-danger:hover {
        background-color: #e57373;
        color: white;
    }
</style>

<div class="container">
    <h2><i class="bi bi-book-half me-2"></i> Daftar Buku</h2>

    <a href="create.php" class="btn btn-vintage mb-3"><i class="bi bi-plus-circle"></i> Tambah Buku</a>

    <div class="card shadow-sm border border-2" style="background-color: #fdfaf6;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle table-vintage text-center">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= formatRupiah($row['price']) ?></td>
                            <td>
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-info">Detail</a>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
