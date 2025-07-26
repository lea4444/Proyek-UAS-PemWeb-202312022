<?php
require_once '../../config/database.php';

function get_all_settings() {
    global $conn;
    $query = "SELECT * FROM settings ORDER BY name ASC";
    return mysqli_query($conn, $query);
}

function get_setting_by_id($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM settings WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function update_setting($id, $value) {
    global $conn;
    $stmt = $conn->prepare("UPDATE settings SET value = ? WHERE id = ?");
    $stmt->bind_param('si', $value, $id);
    return $stmt->execute();
}
