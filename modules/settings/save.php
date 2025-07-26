<?php
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['settings'])) {
    foreach ($_POST['settings'] as $id => $value) {
        $id = intval($id);
        $value = mysqli_real_escape_string($conn, $value);
        $query = "UPDATE settings SET value = '$value' WHERE id = $id";
        mysqli_query($conn, $query);
    }

    header("Location: index.php?status=success");
    exit;
} else {
    header("Location: index.php?status=error");
    exit;
}
