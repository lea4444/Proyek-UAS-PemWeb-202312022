<?php
session_start();
require '../../config/database.php';

$user_id = $_SESSION['user_id'] ?? 0;

$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
$stmt->bind_param("sssi", $name, $phone, $address, $user_id);

if ($stmt->execute()) {
    header("Location: profile.php?success=1");
} else {
    echo "Gagal memperbarui profil.";
}
