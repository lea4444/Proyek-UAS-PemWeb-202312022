<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$categories = mysqli_query($conn, "SELECT * FROM categories");
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $image = $_POST['image'];

    $query = mysqli_query($conn, "INSERT INTO books 
        (title, author, description, price, stock, category_id, supplier_id, image)
        VALUES ('$title', '$author', '$description', $price, $stock, $category_id, $supplier_id, '$image')");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo '<div class="alert alert-danger mt-3">Gagal menambahkan buku.</div>';
    }
}
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
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-vintage {
        background-color: #a67c52;
        color: #fff;
        border: none;
    }

    .btn-vintage:hover {
        background-color: #8b6a41;
    }

    .label {
        color: #5b4433;
        font-weight: 600;
    }
</style>

<div class="container mt-5">
    <div class="card-vintage">
        <h4 class="mb-4">Tambah Buku Baru</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label label">Judul</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Penulis</label>
                <input type="text" class="form-control" name="author" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label label">Harga</label>
                <input type="number" step="0.01" class="form-control" name="price" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Stok</label>
                <input type="number" class="form-control" name="stock" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Kategori</label>
                <select class="form-select" name="category_id" required>
                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label label">Supplier</label>
                <select class="form-select" name="supplier_id" required>
                    <?php while ($sup = mysqli_fetch_assoc($suppliers)): ?>
                        <option value="<?= $sup['id']; ?>"><?= $sup['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label label">URL Gambar Buku</label>
                <input type="text" class="form-control" name="image">
            </div>

            <button type="submit" class="btn btn-vintage">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">← Kembali</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
