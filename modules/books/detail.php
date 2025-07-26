<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT books.*, categories.name AS category, suppliers.name AS supplier 
                              FROM books
                              LEFT JOIN categories ON books.category_id = categories.id
                              LEFT JOIN suppliers ON books.supplier_id = suppliers.id
                              WHERE books.id = $id");
$book = mysqli_fetch_assoc($query);

// Logika folder otomatis berdasarkan category_id (2 = Nonfiksi)
$folder = ($book['category_id'] == 2) ? 'buku_nonfiksi' : 'buku_fiksi';
$image_path = "../../uploads/$folder/" . $book['image'];
?>

<style>
    body {
        background-color: #fdfaf5;
        font-family: 'Georgia', serif;
    }

    .card-vintage {
        background-color: #fffaf0;
        border: 1px solid #e6d3b3;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .label-vintage {
        font-weight: 600;
        color: #6b4c3b;
    }

    .badge-vintage {
        background-color: #b29079;
        color: white;
    }

    .btn-vintage {
        background-color: #a67c52;
        border: none;
        color: white;
    }

    .btn-vintage:hover {
        background-color: #8b6a41;
    }

    .img-vintage {
        border-radius: 1rem;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }

    .placeholder-cover {
        height: 300px;
        background-color: #e0e0e0;
        text-align: center;
        line-height: 300px;
        font-size: 18px;
        color: #888;
        border-radius: 1rem;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
</style>

<div class="container mt-5">
    <div class="card-vintage">
        <h4 class="mb-4">Detail Buku</h4>
        <div class="row">
            <?php if (!empty($book['image']) && file_exists($image_path)): ?>
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="<?= $image_path ?>" alt="Gambar Buku" class="img-fluid img-vintage" style="max-height: 300px;">
                </div>
                <div class="col-md-8">
            <?php else: ?>
                <div class="col-12">
                    <div class="placeholder-cover">No Cover</div>
            <?php endif; ?>

            <p><span class="label-vintage">Judul:</span> <?= htmlspecialchars($book['title']); ?></p>
            <p><span class="label-vintage">Penulis:</span> <?= htmlspecialchars($book['author']); ?></p>
            <p><span class="label-vintage">Harga:</span> <span class="badge badge-vintage">Rp<?= number_format($book['price'], 2); ?></span></p>
            <p><span class="label-vintage">Stok:</span> <?= $book['stock']; ?> pcs</p>
            <p><span class="label-vintage">Kategori:</span> <?= htmlspecialchars($book['category']); ?></p>
            <p><span class="label-vintage">Supplier:</span> <?= htmlspecialchars($book['supplier']); ?></p>
            <p><span class="label-vintage">Deskripsi:</span><br><?= nl2br(htmlspecialchars($book['description'])); ?></p>
        </div>
        </div>

        <div class="mt-4 text-end">
            <a href="index.php" class="btn btn-secondary rounded-pill">← Kembali</a>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
