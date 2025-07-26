<?php
session_start();
require '../../config/database.php';

// Cek role untuk link dashboard
$dashboard_link = "#";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $dashboard_link = "../../admin/dashboard.php";
    } elseif ($_SESSION['role'] === 'user') {
        $dashboard_link = "../../user/dashboard.php";
    }
}

// Ambil daftar buku
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY title ASC");
$books = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
} else {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Literaid - Belanja Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff9e6;
            font-family: 'Georgia', serif;
        }
        .card {
            background-color: #fff6da;
        }
        .card-title {
            font-weight: bold;
        }
        .btn-outline-success:hover {
            background-color: #198754;
            color: #fff;
        }
        .placeholder-cover {
            height: 250px;
            background-color: #e0e0e0;
            text-align: center;
            line-height: 250px;
            font-size: 18px;
            color: #888;
        }
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><img src="../../assets/icon-book.png" width="32"> Daftar Buku Tersedia</h2>
        <div>
            <a href="<?= $dashboard_link ?>" class="btn btn-secondary me-2">🏠 Dashboard</a>
            <a href="keranjang.php" class="btn btn-primary">🛒 Lihat Keranjang</a>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Buku berhasil ditambahkan ke keranjang.</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Gagal menambahkan buku ke keranjang.</div>
    <?php elseif (isset($_GET['success_checkout'])): ?>
        <div class="alert alert-info">Checkout berhasil! Terima kasih sudah belanja.</div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($books as $book): ?>
        <div class="col">
            <div class="card h-100 shadow-sm border-warning">
                <?php
                    // Asumsikan category_id = 2 untuk nonfiksi, selain itu dianggap fiksi
                    $folder = ($book['category_id'] == 2) ? 'buku_nonfiksi' : 'buku_fiksi';
                    $image_path = "../../uploads/$folder/" . $book['image'];
                ?>

                <?php if (!empty($book['image']) && file_exists($image_path)): ?>
                    <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="card-img-top">
                <?php else: ?>
                    <div class="placeholder-cover">No Cover</div>
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                    <p class="card-text">Penulis: <?= htmlspecialchars($book['author']) ?></p>
                    <p class="card-text fw-bold">Rp<?= number_format($book['price'], 0, ',', '.') ?></p>
                    <p class="card-text">Stok: <?= $book['stock'] ?></p>

                    <?php if ($book['stock'] > 0): ?>
                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit" class="btn btn-outline-success">Tambah ke Keranjang</button>
                        </form>
                    <?php else: ?>
                        <span class="badge bg-danger">Stok Habis</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
