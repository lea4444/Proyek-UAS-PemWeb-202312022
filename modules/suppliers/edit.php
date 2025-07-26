<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM suppliers WHERE id = $id");
$supplier = mysqli_fetch_assoc($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $query = mysqli_query($conn, "UPDATE suppliers SET 
                    name = '$name',
                    contact = '$contact',
                    address = '$address'
                    WHERE id = $id");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger container mt-4'>❌ Gagal mengedit supplier.</div>";
    }
}
?>

<div class="container mt-5" style="font-family: 'Georgia', serif;">
    <div class="card border-0 shadow" style="background-color: #fdfaf6; border-radius: 10px;">
        <div class="card-header" style="background-color: #704214; color: #fff; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h4 class="mb-0">✍️ Edit Data Supplier</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">📛 Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($supplier['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">📞 Kontak</label>
                    <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($supplier['contact']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">🏠 Alamat</label>
                    <textarea name="address" class="form-control" rows="4" required><?= htmlspecialchars($supplier['address']); ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-primary">💾 Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-outline-secondary">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
