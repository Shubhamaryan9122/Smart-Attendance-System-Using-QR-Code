<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div style="width:400px; margin:80px auto; background:#fff; padding:20px; border-radius:10px; text-align:center;">
    <h2>Admin Dashboard</h2>

    <a href="add_user.php">➕ Add Teacher / Student</a><br><br>
    <a href="view_users.php">👥 View Users</a><br><br>
    <a href="view_attendance.php">📊 View Attendance</a><br><br>
    <a href="../auth/logout.php">🚪 Logout</a>
</div>

</body>
</html>
