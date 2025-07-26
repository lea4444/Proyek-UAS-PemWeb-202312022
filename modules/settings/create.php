<?php
require '../../includes/auth.php';
require '../../includes/header.php';
require '../../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $value = trim($_POST['value']);

    if ($name === '') {
        $error = "Nama pengaturan tidak boleh kosong.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM settings WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Nama pengaturan sudah ada.";
        } else {
            $stmt = $conn->prepare("INSERT INTO settings (name, value) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $value);
            if ($stmt->execute()) {
                header("Location: index.php?status=success");
                exit;
            } else {
                $error = "Gagal menyimpan pengaturan.";
            }
        }
    }
}
?>

<style>
    body {
        background-color: #f3efe3;
        font-family: 'Georgia', serif;
    }

    .vintage-header {
        background-color: #d7c8b6;
        padding: 10px 20px;
        border-left: 10px solid #7b5e42;
        border-radius: 8px;
        color: #4b3621;
    }

    .vintage-card {
        background-color: #fdfaf6;
        border: 1px solid #b6a489;
        border-radius: 8px;
        padding: 20px;
    }

    .btn-vintage {
        background-color: #7b5e42;
        color: #fff;
        border: none;
    }

    .btn-vintage:hover {
        background-color: #5c4433;
    }
</style>

<div class="container py-4">
    <div class="vintage-header mb-3">
        <h2 class="m-0"><i class="bi bi-plus-square me-2"></i> Tambah Pengaturan</h2>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="vintage-card shadow-sm">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Pengaturan</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nilai</label>
                <input type="text" name="value" class="form-control">
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-vintage">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require '../../includes/footer.php'; ?>
