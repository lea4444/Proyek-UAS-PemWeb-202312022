<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $query = mysqli_query($conn, "INSERT INTO suppliers (name, contact, address) 
                                  VALUES ('$name', '$contact', '$address')");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger container mt-4'>❌ Gagal menambahkan supplier.</div>";
    }
}
?>

<div class="container mt-5" style="font-family: 'Georgia', serif;">
    <div class="card border-0 shadow" style="background-color: #fdfaf6; border-radius: 10px;">
        <div class="card-header" style="background-color: #704214; color: #fff; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h4 class="mb-0">📦 Tambah Supplier / Penerbit</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">📛 Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">📞 Kontak</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">🏠 Alamat</label>
                    <textarea name="address" class="form-control" rows="4" required></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-primary">💾 Simpan</button>
                    <a href="index.php" class="btn btn-outline-secondary">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
