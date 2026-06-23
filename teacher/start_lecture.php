<?php
session_start();
include "../config/db.php";

$teacher_id = $_SESSION['user_id'];
$subject_id = $_POST['subject_id'];
$duration = $_POST['duration'];

$start_time = date("Y-m-d H:i:s");
$end_time = date("Y-m-d H:i:s", strtotime("+$duration minutes"));

$query = "INSERT INTO lectures (teacher_id, subject_id, start_time, end_time)
          VALUES ('$teacher_id', '$subject_id', '$start_time', '$end_time')";

mysqli_query($conn, $query);

$lecture_id = mysqli_insert_id($conn);

// generate first QR token
$token = bin2hex(random_bytes(8));

mysqli_query($conn, "INSERT INTO qr_tokens (lecture_id, token) VALUES ('$lecture_id', '$token')");

header("Location: show_qr.php?lecture_id=$lecture_id");
?>
