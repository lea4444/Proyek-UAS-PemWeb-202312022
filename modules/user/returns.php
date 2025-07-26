<?php
session_start();
require '../../config/database.php';

$user_id = $_SESSION['user_id'] ?? 1;

// Ambil item pesanan yang bisa dikembalikan
$query = "
    SELECT oi.id AS order_item_id, o.id AS order_id, o.order_date, b.title 
    FROM order_items oi
    JOIN orders o ON oi.id = oi.id
    JOIN books b ON oi.book_id = b.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ajukan Pengembalian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f0e3;
      font-family: 'Georgia', serif;
    }
    .vintage-container {
      max-width: 800px;
      margin: 30px auto;
      background-color: #fffaf0;
      border: 1px solid #d2b48c;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 4px 4px 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: #5a3e1b;
      font-weight: bold;
    }
    label {
      color: #4e342e;
      font-weight: 600;
    }
    select, textarea {
      background-color: #fefcf7;
      border: 1px solid #c0a98e;
    }
    .btn-vintage {
      background-color: #c19a6b;
      border: none;
      color: white;
    }
    .btn-vintage:hover {
      background-color: #a67b5b;
    }
    .form-label::after {
      content: " *";
      color: red;
    }
    .alert {
      border-radius: 8px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="vintage-container">
    <div class="mb-3">
      <a href="../../user/dashboard.php" class="btn btn-secondary btn-sm">&larr; Kembali ke Dashboard</a>
    </div>

    <h2>🔁 Ajukan Pengembalian Buku</h2>
    <p class="text-muted">Silakan pilih buku yang ingin dikembalikan dan berikan alasan yang sesuai.</p>

    <?php if ($result->num_rows === 0): ?>
      <div class="alert alert-info">Tidak ada item pesanan yang tersedia untuk pengembalian.</div>
    <?php else: ?>
      <form action="submit_return.php" method="post">
        <div class="mb-3">
          <label for="order_item_id" class="form-label">Pilih Buku</label>
          <select name="order_item_id" id="order_item_id" class="form-select" required>
            <option value="" disabled selected>-- Pilih Buku dari Pesanan --</option>
            <?php while ($row = $result->fetch_assoc()): ?>
              <option value="<?= $row['order_item_id'] ?>">
                <?= htmlspecialchars($row['title']) ?> (Pesanan #<?= $row['order_id'] ?> - <?= date('d M Y', strtotime($row['order_date'])) ?>)
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="reason" class="form-label">Alasan Pengembalian</label>
          <textarea name="reason" id="reason" rows="4" class="form-control" placeholder="Contoh: Buku rusak, salah kirim, dll." required></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-vintage">Kirim Permintaan</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
