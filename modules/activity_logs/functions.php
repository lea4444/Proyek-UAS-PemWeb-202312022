<?php
function log_activity($conn, $user_id, $activity) {
    if (!$conn) return;
    $user_id = intval($user_id);
    $activity = mysqli_real_escape_string($conn, $activity);

    if ($user_id <= 0 || empty($activity)) return;

    $query = "INSERT INTO activity_logs (user_id, activity, log_time) 
              VALUES ($user_id, '$activity', NOW())";
    
    mysqli_query($conn, $query);
}
