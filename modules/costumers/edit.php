<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = intval($_GET['id']);
$data = mysqli_query($conn, "SELECT * FROM customers WHERE id = $id");
$customer = mysqli_fetch_assoc($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = mysqli_query($conn, "UPDATE customers SET 
                    name = '$name',
                    phone = '$phone',
                    address = '$address'
                    WHERE id = $id");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal mengedit pelanggan.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="card shadow border-0" style="background-color: #f9f5ec;">
        <div class="card-header" style="background-color: #d4a373;">
            <h4 class="text-white mb-0">✏️ Edit Pelanggan</h4>
        </div>
        <div class="card-body" style="font-family: 'Georgia', serif;">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($customer['name']); ?>" class="form-control" required style="background-color: #fffaf3;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']); ?>" class="form-control" required style="background-color: #fffaf3;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" required style="background-color: #fffaf3;"><?= htmlspecialchars($customer['address']); ?></textarea>
                </div>

                <button type="submit" class="btn" style="background-color: #6c584c; color: #fff;">💾 Simpan</button>
                <a href="index.php" class="btn btn-outline-secondary ms-2">← Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
