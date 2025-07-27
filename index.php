<?php
session_start();

// Jika sudah login, arahkan ke dashboard sesuai role
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit;
    } elseif ($_SESSION['role'] === 'user') {
        header('Location: user/dashboard.php');
        exit;
    }
}

// Jika belum login, arahkan ke halaman login
header('Location: auth/login.php');
exit;