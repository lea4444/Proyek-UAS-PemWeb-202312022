<?php
function log_activity($user_id, $activity) {
    include __DIR__ . '/../../config/database.php';
    $user_id = intval($user_id);
    $activity = mysqli_real_escape_string($conn, $activity);
    $query = "INSERT INTO activity_logs (user_id, activity, log_time) VALUES ($user_id, '$activity', NOW())";
    mysqli_query($conn, $query);
}
