<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

// Ambil semua order item
$orderItems = mysqli_query($conn, "
    SELECT oi.id, b.title, o.id AS order_id
    FROM order_items oi
    LEFT JOIN books b ON oi.book_id = b.id
    LEFT JOIN orders o ON oi.order_id = o.id
    ORDER BY oi.id DESC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_item_id = $_POST['order_item_id'];
    $reason = $_POST['reason'];

    $query = "INSERT INTO returns (order_item_id, reason) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $order_item_id, $reason);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5" style="font-family: 'Georgia', serif;">
    <div class="card border-0 shadow-sm" style="background-color: #fffaf0; border-radius: 10px;">
        <div class="card-header" style="background-color: #a47148; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h4 class="mb-0">📦 Tambah Retur Pesanan</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">🧾 Pilih Item Pesanan</label>
                    <select name="order_item_id" class="form-select" required>
                        <?php while ($item = mysqli_fetch_assoc($orderItems)) : ?>
                            <option value="<?= $item['id'] ?>">Order #<?= $item['order_id'] ?> - <?= htmlspecialchars($item['title']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">📝 Alasan Retur</label>
                    <textarea name="reason" class="form-control" rows="4" required></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn" style="background-color: #a47148; color: white;">✔ Simpan Retur</button>
                    <a href="index.php" class="btn btn-outline-dark">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
