<?php
$host = "localhost";
$user = "root";
$pass = "1234";
$dbname = "literaid";

// Koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
