<?php
$input = 'admin123'; // password yg kamu ketik
$hashFromDB = '$2y$10$gqVvlcGquZ75Yw.DT2slCOhnnp6CH24uRfkrwpuAg0W.vyXtzzHT6'; // dari database

if (password_verify($input, $hashFromDB)) {
    echo "✅ Cocok!";
} else {
    echo "❌ Tidak cocok!";
}