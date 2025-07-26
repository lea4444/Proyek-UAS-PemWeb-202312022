<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = mysqli_query($conn, "INSERT INTO customers (name, phone, address) 
                                  VALUES ('$name', '$phone', '$address')");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo '<div class="alert alert-danger mt-3">Gagal menambahkan pelanggan.</div>';
    }
}
?>

<div class="container mt-4">
    <div class="card shadow" style="border: 1px solid #c8b6a6; background-color: #fdfaf6;">
        <div class="card-header" style="background-color: #a47148; color: #fff;">
            <h4 class="mb-0" style="font-family: 'Georgia', serif;">Tambah Pelanggan</h4>
        </div>
        <div class="card-body" style="font-family: 'Georgia', serif;">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" style="background-color: #fff8f0; border-color: #d3c1a1;" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" style="background-color: #fff8f0; border-color: #d3c1a1;" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="3" style="background-color: #fff8f0; border-color: #d3c1a1;" required></textarea>
                </div>

                <button type="submit" class="btn" style="background-color: #6b4c3b; color: white;">Simpan</button>
                <a href="index.php" class="btn btn-outline-secondary ms-2">← Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
