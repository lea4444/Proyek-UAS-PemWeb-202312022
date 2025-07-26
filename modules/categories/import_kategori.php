<?php
// Fix path ke database
include('../../config/database.php');

// Lokasi file CSV
$filename = 'data/kategori.csv';

if (!file_exists($filename)) {
    die("❌ File CSV tidak ditemukan di: $filename");
}

$file = fopen($filename, 'r');

if (!$file) {
    die("❌ Gagal membuka file CSV.");
}

include '../../includes/header.php';

echo "<div class='container mt-5'>";
echo "<h3>📦 Proses Import Kategori</h3>";

$row = 0;
$imported = 0;

while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    // Lewati baris header
    if ($row == 0) {
        $row++;
        continue;
    }

    $nama_kategori = mysqli_real_escape_string($conn, $data[0]);

    // Cek apakah kategori sudah ada
    $check = mysqli_query($conn, "SELECT * FROM categories WHERE name='$nama_kategori'");
    if (mysqli_num_rows($check) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$nama_kategori')");
        if ($insert) {
            echo "✅ Kategori <strong>$nama_kategori</strong> berhasil diimpor.<br>";
            $imported++;
        } else {
            echo "❌ Gagal impor kategori <strong>$nama_kategori</strong>.<br>";
        }
    } else {
        echo "⚠️ Kategori <strong>$nama_kategori</strong> sudah ada, dilewati.<br>";
    }

    $row++;
}

fclose($file);

echo "<hr><strong>Total berhasil diimpor: $imported kategori.</strong>";
echo "</div>";

include '../../includes/footer.php';
?>