<?php
session_start();
require '../../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT username, email, name, phone, address FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f1ea;
            font-family: 'Georgia', serif;
        }

        .card-vintage {
            background-color: #fffaf0;
            border: 2px solid #d2b48c;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-vintage {
            background-color: #8b5e3c;
            color: white;
            border: none;
        }

        .btn-vintage:hover {
            background-color: #6f422a;
        }

        h3 {
            font-weight: bold;
            color: #4b3621;
        }

        p {
            font-size: 1.1rem;
        }

        .label {
            font-weight: bold;
            color: #3e2f23;
        }

        .back-button {
            background-color: #c19a6b;
            color: white;
        }

        .back-button:hover {
            background-color: #a67c52;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="mb-4">
        <a href="../../user/dashboard.php" class="btn back-button">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="card card-vintage p-4">
        <h3><i class="bi bi-person-fill"></i> Profil Saya</h3>
        <hr class="mb-4">
        <p><span class="label">Nama Lengkap:</span> <?= htmlspecialchars($user['name'] ?? '-') ?></p>
        <p><span class="label">Username:</span> <?= htmlspecialchars($user['username']) ?></p>
        <p><span class="label">Email:</span> <?= htmlspecialchars($user['email']) ?></p>
        <p><span class="label">Telepon:</span> <?= htmlspecialchars($user['phone'] ?? '-') ?></p>
        <p><span class="label">Alamat:</span><br><?= nl2br(htmlspecialchars($user['address'] ?? '-')) ?></p>

        <div class="mt-4">
            <a href="edit_profile.php" class="btn btn-warning me-2">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </a>
            <a href="change_password.php" class="btn btn-secondary">
                <i class="bi bi-key"></i> Ubah Password
            </a>
        </div>
    </div>
</div>
</body>
</html>
