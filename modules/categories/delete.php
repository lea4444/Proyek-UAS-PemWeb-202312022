<?php
include '../../includes/auth.php';
include '../../config/database.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM categories WHERE id = $id");

header("Location: index.php");
exit;
