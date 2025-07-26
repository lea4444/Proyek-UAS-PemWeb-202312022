<?php
session_start();
require '../../config/database.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$query = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));

    $update = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $update->bind_param("ssi", $username, $email, $user_id);

    if ($update->execute()) {
        $_SESSION['username'] = $username;
        header('Location: profile.php?success=1');
        exit;
    } else {
        $error = "Gagal memperbarui profil.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f1e4;
            font-family: 'Georgia', serif;
        }

        .vintage-card {
            background-color: #fff8dc;
            border: 2px solid #d2b48c;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 3px 3px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-vintage {
            background-color: #a67c52;
            color: white;
            border: none;
        }

        .btn-vintage:hover {
            background-color: #8b6f47;
        }

        h3 {
            font-weight: bold;
            color: #5e412f;
        }

        label {
            font-weight: bold;
            color: #4b3b2a;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="vintage-card">
        <h3 class="mb-4">✍️ Edit Profil</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control" name="username" id="username" value="<?= $user['username'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= $user['email'] ?>" required>
            </div>

            <button type="submit" class="btn btn-vintage">💾 Simpan Perubahan</button>
            <a href="profile.php" class="btn btn-secondary">↩ Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
