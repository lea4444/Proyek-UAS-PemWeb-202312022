<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}
$username = $_SESSION['username'] ?? 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fdf6e3;
            font-family: 'Georgia', serif;
            color: #5b4636;
        }

        .dashboard-header {
            background-color: #fff8e1;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 2px solid #e0c68c;
            box-shadow: 0 4px 8px rgba(124, 96, 50, 0.2);
        }

        .dashboard-header h2 {
            font-weight: bold;
            color: #8b5e3c;
        }

        .card-link {
            display: block;
            background-color: #fffaf0;
            border: 1px solid #decbb7;
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 15px;
            color: #5b4636;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .card-link:hover {
            background-color: #f5ecd7;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .card-link .icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .logout-link {
            border: 1px dashed #c0392b;
            background-color: #fef2f2;
            color: #c0392b !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="dashboard-header text-center">
            <h2 class="text-success">📚 Dashboard Pengguna</h2>
            <p>Halo, <strong><?= htmlspecialchars($username) ?></strong></p>
        </div>

        <div class="mb-4">
            <a href="../modules/user/shop.php" class="card-link">
                <span class="icon">🛒</span> Belanja Buku
            </a>
            <a href="../modules/user/orders.php" class="card-link">
                <span class="icon">📦</span> Riwayat Pesanan
            </a>
            <a href="../modules/user/returns.php" class="card-link">
                <span class="icon">↩️</span> Ajukan Pengembalian
            </a>
            <a href="../modules/user/profile.php" class="card-link">
                <span class="icon">👤</span> Profil Saya
            </a>
            <a href="../auth/logout.php" class="card-link logout-link">
                <span class="icon">🚪</span> Logout
            </a>
        </div>
    </div>
</body>
</html>
