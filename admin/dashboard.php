<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
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

        .card.dashboard-card {
            background-color: #fffaf0;
            border: 1px solid #decbb7;
            box-shadow: 0 3px 6px rgba(0,0,0,0.08);
            border-radius: 10px;
            transition: all 0.25s ease-in-out;
        }

        .card.dashboard-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .card-icon {
            font-size: 34px;
        }

        .card-title {
            font-weight: bold;
            color: #5c3d2e;
        }

        a.text-danger .card {
            border: 2px dashed #c0392b;
            background-color: #fef2f2;
        }

        a.text-danger .card-title {
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="dashboard-header text-center">
            <h2 class="mb-2">📜 Dashboard Admin</h2>
            <p class="mb-0">Halo, <strong><?= $_SESSION['username'] ?></strong></p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="../modules/users/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">👤</div>
                            <h5 class="card-title">Manajemen User</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/books/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">📚</div>
                            <h5 class="card-title">Daftar Buku</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/categories/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">🏷️</div>
                            <h5 class="card-title">Kategori Buku</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/costumers/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">🧍‍♂️</div>
                            <h5 class="card-title">Pelanggan</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/orders/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">💰</div>
                            <h5 class="card-title">Transaksi</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/order_items/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">📦</div>
                            <h5 class="card-title">Item Pesanan</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/returns/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">↩️</div>
                            <h5 class="card-title">Pengembalian</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/suppliers/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">🚚</div>
                            <h5 class="card-title">Pemasok</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/activity_logs/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">📜</div>
                            <h5 class="card-title">Log Aktivitas</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../modules/settings/" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">⚙️</div>
                            <h5 class="card-title">Pengaturan</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="../auth/logout.php" class="text-decoration-none text-danger">
                    <div class="card dashboard-card text-center p-4">
                        <div class="card-body">
                            <div class="card-icon mb-2">🚪</div>
                            <h5 class="card-title">Logout</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
