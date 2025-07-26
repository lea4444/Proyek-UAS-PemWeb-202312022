<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = intval($_GET['id']);
$data = mysqli_query($conn, "SELECT * FROM customers WHERE id = $id");
$cust = mysqli_fetch_assoc($data);
?>

<div class="container mt-5">
    <div class="card shadow border-0" style="background-color: #f9f5ec;">
        <div class="card-header" style="background-color: #b08968;">
            <h4 class="text-white mb-0">📖 Detail Pelanggan</h4>
        </div>
        <div class="card-body" style="font-family: 'Georgia', serif;">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($cust['id']); ?></dd>

                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($cust['name']); ?></dd>

                <dt class="col-sm-3">Telepon</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($cust['phone']); ?></dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9"><?= nl2br(htmlspecialchars($cust['address'])); ?></dd>
            </dl>

            <a href="index.php" class="btn btn-outline-dark mt-3">← Kembali</a>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
