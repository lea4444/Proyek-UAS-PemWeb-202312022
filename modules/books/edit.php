<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'];
$book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id = $id"));
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

    $query = mysqli_query($conn, "UPDATE books SET
        title='$title',
        author='$author',
        description='$description',
        price=$price,
        stock=$stock,
        category_id=$category_id,
        supplier_id=$supplier_id,
        image='$image'
        WHERE id = $id");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Gagal mengedit buku.</div>";
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
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    label {
        font-weight: 600;
        color: #6b4c3b;
    }

    .form-control, .form-select {
        background-color: #f9f3ea;
        border: 1px solid #d2b48c;
    }

    .btn-primary {
        background-color: #a67c52;
        border: none;
    }

    .btn-primary:hover {
        background-color: #8b6a41;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-vintage">
                <h4 class="mb-4">Edit Buku</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Penulis</label>
                        <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($book['description']); ?></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Harga</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="<?= $book['price']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control" value="<?= $book['stock']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?= $cat['id']; ?>" <?= $book['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            <?php while ($sup = mysqli_fetch_assoc($suppliers)): ?>
                                <option value="<?= $sup['id']; ?>" <?= $book['supplier_id'] == $sup['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($sup['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>Gambar (URL)</label>
                        <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($book['image']); ?>">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary rounded-pill">← Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
