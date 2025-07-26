<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
$cat = mysqli_fetch_assoc($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $query = mysqli_query($conn, "UPDATE categories SET name = '$name' WHERE id = $id");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo '<div class="alert alert-danger mt-3">Gagal mengedit kategori.</div>';
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
        <h4 class="mb-4">Edit Kategori</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label label">Nama Kategori</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($cat['name']); ?>" required>
            </div>

            <button type="submit" class="btn btn-vintage">Update</button>
            <a href="index.php" class="btn btn-secondary ms-2">← Kembali</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
