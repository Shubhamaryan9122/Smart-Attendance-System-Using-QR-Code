<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../auth/login.php");
    exit;
}

$lecture_id = $_GET['lecture_id'];

mysqli_query($conn, "
    UPDATE lectures
    SET is_active = 0
    WHERE id = '$lecture_id'
");

header("Location: dashboard.php");
?>
