<?php
session_start();
include '../config/database.php'; // koneksi DB
include '../modules/activity_logs/functions.php'; // fungsi log

if (isset($_SESSION['user_id'])) {
    log_activity($conn, $_SESSION['user_id'], 'Logout dari sistem');
}

session_unset();
session_destroy();
header("Location: login.php");
exit;
