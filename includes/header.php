<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: /literaid/auth/login.php");
    exit;
}

// Tentukan tautan dashboard berdasarkan role
$dashboardLink = '/literaid/dashboard.php'; // default fallback
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $dashboardLink = '/literaid/admin/dashboard.php';
    } elseif ($_SESSION['role'] === 'user') {
        $dashboardLink = '/literaid/user/dashboard.php';
    }
}

// Ambil site_name dari tabel settings
require_once __DIR__ . '/../config/database.php';
$siteName = 'literaid'; // fallback default

$query = mysqli_query($conn, "SELECT value FROM settings WHERE name = 'site_name' LIMIT 1");
if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $siteName = htmlspecialchars($row['value']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $siteName ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm px-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= $dashboardLink ?>">
      📖 <?= $siteName ?>
    </a>

    <div class="d-flex ms-auto">
      <a href="<?= $dashboardLink ?>" class="btn btn-outline-secondary me-2">Dashboard</a>
      <a href="/literaid/auth/logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>
</nav>

<!-- Container awal konten -->
<div class="container mt-4">
