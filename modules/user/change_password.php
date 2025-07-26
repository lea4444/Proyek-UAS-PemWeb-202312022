<?php
session_start();
require '../../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($current_password, $user['password'])) {
        $error = "Password lama salah.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashed_password, $user_id);
        if ($update->execute()) {
            $success = "Password berhasil diubah.";
        } else {
            $error = "Gagal mengubah password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f3e8;
            font-family: 'Georgia', serif;
        }
        .card {
            background-color: #fffaf0;
            border: 1px solid #c2b280;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(139, 69, 19, 0.2);
        }
        h3 {
            color: #5b3a29;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
        }
        .btn-primary:hover {
            background-color: #a0522d;
        }
        .btn-secondary {
            background-color: #d2b48c;
            border-color: #d2b48c;
            color: #000;
        }
        .btn-secondary:hover {
            background-color: #c0a16b;
        }
        label {
            font-weight: bold;
            color: #4b3621;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card p-4 mx-auto" style="max-width: 600px;">
        <h3 class="mb-4 text-center"><i class="bi bi-lock-fill"></i> Ubah Password</h3>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Password Lama</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="profile.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
