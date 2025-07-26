<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$orders = mysqli_query($conn, "SELECT id FROM orders ORDER BY id DESC");
$books = mysqli_query($conn, "SELECT * FROM books WHERE stock > 0");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];

    $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price, stock FROM books WHERE id = $book_id"));
    if ($quantity > $book['stock']) {
        echo "<div class='alert alert-danger container mt-4'>📕 Stok tidak cukup untuk buku tersebut.</div>";
    } else {
        $subtotal = $book['price'] * $quantity;

        mysqli_query($conn, "INSERT INTO order_items (order_id, book_id, quantity, subtotal) 
                             VALUES ($order_id, $book_id, $quantity, $subtotal)");

        mysqli_query($conn, "UPDATE books SET stock = stock - $quantity WHERE id = $book_id");
        mysqli_query($conn, "UPDATE orders SET total = total + $subtotal WHERE id = $order_id");

        header("Location: index.php");
        exit;
    }
}
?>

<div class="container mt-5" style="font-family: 'Georgia', serif;">
    <div class="card border-0 shadow" style="background-color: #fdf6f0; border-radius: 10px;">
        <div class="card-header" style="background-color: #a97155; color: #fff; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h4 class="mb-0">🛒 Tambah Item ke Order</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">🆔 Pilih Order</label>
                    <select name="order_id" class="form-select" required>
                        <?php while($o = mysqli_fetch_assoc($orders)): ?>
                            <option value="<?= $o['id'] ?>">#<?= $o['id'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">📘 Pilih Buku</label>
                    <select name="book_id" class="form-select" required>
                        <?php while($b = mysqli_fetch_assoc($books)): ?>
                            <option value="<?= $b['id'] ?>">
                                <?= htmlspecialchars($b['title']) ?> (stok: <?= $b['stock'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">🔢 Jumlah</label>
                    <input type="number" name="quantity" min="1" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn" style="background-color: #a97155; color: white;">+ Tambah Item</button>
                    <a href="index.php" class="btn btn-outline-dark">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
