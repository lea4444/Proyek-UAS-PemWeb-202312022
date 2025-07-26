<?php
require_once __DIR__ . '/../config/database.php';

// Ambil semua pengaturan
function get_all_settings() {
    global $conn;
    $query = "SELECT * FROM settings ORDER BY name ASC";
    return mysqli_query($conn, $query);
}

// Ambil satu pengaturan berdasarkan ID
function get_setting_by_id($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM settings WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Ambil nilai pengaturan berdasarkan nama
function get_setting($name) {
    global $conn;
    $stmt = $conn->prepare("SELECT value FROM settings WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['value'] ?? null;
}

// Tambah pengaturan baru
function create_setting($name, $value) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO settings (name, value) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $value);
    return $stmt->execute();
}

// Update nilai pengaturan
function update_setting($id, $value) {
    global $conn;
    $stmt = $conn->prepare("UPDATE settings SET value = ? WHERE id = ?");
    $stmt->bind_param('si', $value, $id);
    return $stmt->execute();
}

// Cek apakah nama pengaturan sudah ada
function setting_exists($name) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM settings WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}
