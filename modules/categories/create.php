<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if ($name === '') {
        $error = 'Nama kategori tidak boleh kosong.';
    } else {
        $query = mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$name')");

        if ($query) {
            header("Location: index.php");
            exit;
        } else {
            $error = 'Kategori gagal ditambahkan. Mungkin nama sudah digunakan.';
        }
    }
}
?>

<div class="container mt-4">
    <div class="card shadow" style="border: 1px solid #c8b6a6; background-color: #fdfaf6;">
        <div class="card-header" style="background-color: #a47148; color: #fff;">
            <h4 class="mb-0" style="font-family: 'Georgia', serif;">Tambah Kategori</h4>
        </div>
        <div class="card-body" style="font-family: 'Georgia', serif;">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="name" name="name" style="background-color: #fff8f0; border-color: #d3c1a1;" required>
                </div>

                <button type="submit" class="btn" style="background-color: #6b4c3b; color: white;">Simpan</button>
                <a href="index.php" class="btn btn-outline-secondary ms-2">← Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
