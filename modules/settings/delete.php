<?php
require '../../includes/auth.php';
require '../../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Cek apakah data ada
$query = mysqli_query($conn, "SELECT * FROM settings WHERE id = $id");
$setting = mysqli_fetch_assoc($query);

if (!$setting) {
    header("Location: index.php?status=notfound");
    exit;
}

// Hapus data
mysqli_query($conn, "DELETE FROM settings WHERE id = $id");
header("Location: index.php?status=deleted");
exit;
