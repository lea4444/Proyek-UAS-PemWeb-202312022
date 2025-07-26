<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$customers = mysqli_query($conn, "SELECT * FROM customers");
$books = mysqli_query($conn, "SELECT * FROM books WHERE stock > 0");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $user_id = $_SESSION['user']['id'];
    $items = $_POST['items'];

    $total = 0;
    foreach ($items as $book_id => $qty) {
        if ($qty > 0) {
            $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id = $book_id"));
            $subtotal = $book['price'] * $qty;
            $total += $subtotal;
        }
    }

    mysqli_query($conn, "INSERT INTO orders (customer_id, user_id, total) VALUES ($customer_id, $user_id, $total)");
    $order_id = mysqli_insert_id($conn);

    foreach ($items as $book_id => $qty) {
        if ($qty > 0) {
            $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id = $book_id"));
            $subtotal = $book['price'] * $qty;
            mysqli_query($conn, "INSERT INTO order_items (order_id, book_id, quantity, subtotal) 
                                VALUES ($order_id, $book_id, $qty, $subtotal)");
            mysqli_query($conn, "UPDATE books SET stock = stock - $qty WHERE id = $book_id");
        }
    }

    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5" style="font-family: 'Georgia', serif;">
    <div class="card border-0 shadow-sm" style="background-color: #fdf6ec;">
        <div class="card-header" style="background-color: #a98467;">
            <h4 class="text-white mb-0">📚 Buat Transaksi</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Pilih Pelanggan</label>
                    <select name="customer_id" class="form-select" required>
                        <?php while($c = mysqli_fetch_assoc($customers)): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">📖 Tambah Buku</h5>
                <?php while($b = mysqli_fetch_assoc($books)): ?>
                    <div class="mb-3 p-3 border rounded" style="background-color: #fffef6;">
                        <label class="form-label fw-semibold"><?= htmlspecialchars($b['title']) ?></label>
                        <div class="text-muted mb-1">Stok: <?= $b['stock'] ?> | Harga: Rp<?= number_format($b['price'], 0, ',', '.') ?></div>
                        <input type="number" name="items[<?= $b['id'] ?>]" class="form-control w-25" min="0" max="<?= $b['stock'] ?>" value="0">
                    </div>
                <?php endwhile; ?>

                <button type="submit" class="btn btn-success">💾 Simpan Transaksi</button>
                <a href="index.php" class="btn btn-outline-dark ms-2">← Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
