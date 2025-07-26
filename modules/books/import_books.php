<?php
require '../../config/database.php'; // Sesuaikan dengan lokasi koneksi kamu

$csvFile = realpath(__DIR__ . '/../../uploads/buku.csv');
echo "📂 Mencoba akses file di: $csvFile<br>";

if (!file_exists($csvFile)) {
    die("❌ File tidak ditemukan.");
}

$file = fopen($csvFile, 'r');

// Ambil header
$header = fgetcsv($file, 1000, ';');
$total = 0;

while (($row = fgetcsv($file, 1000, ';')) !== false) {
    if (count($row) < 7) {
        echo "⚠️ Baris tidak lengkap, dilewati.<br>";
        continue;
    }

    // Sesuai urutan: name;description;price;stock;image;category_id;supplier_id
    $title         = mysqli_real_escape_string($conn, $row[0]);
    $description  = mysqli_real_escape_string($conn, $row[1]);
    $price        = (int) $row[2];
    $stock        = (int) $row[3];
    $image        = mysqli_real_escape_string($conn, $row[4]);
    $category_id  = (int) $row[5];
    $supplier_id  = (int) $row[6];

    $sql = "INSERT INTO books (title, description, price, stock, image, category_id, supplier_id)
            VALUES ('$title', '$description', $price, $stock, '$image', $category_id, $supplier_id)";

    if (mysqli_query($conn, $sql)) {
        $total++;
    } else {
        echo "❌ Gagal insert: " . mysqli_error($conn) . "<br>";
    }
}

fclose($file);
echo "✅ Import selesai. Total buku ditambahkan: $total";
?>
