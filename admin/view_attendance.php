<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Attendance</title>
</head>
<body>

<h2 style="text-align:center;">Attendance Records</h2>

<table border="1" width="90%" align="center" cellpadding="10">
<tr>
    <th>Lecture ID</th>
    <th>Student Name</th>
    <th>Teacher ID</th>
    <th>Scan Time</th>
</tr>

<?php
$query = mysqli_query($conn, "
    SELECT attendance.lecture_id, users.name, lectures.teacher_id, attendance.scan_time
    FROM attendance
    JOIN users ON attendance.student_id = users.id
    JOIN lectures ON attendance.lecture_id = lectures.id
");

while ($row = mysqli_fetch_assoc($query)) {
    echo "<tr>
            <td>{$row['lecture_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['teacher_id']}</td>
            <td>{$row['scan_time']}</td>
          </tr>";
}
?>

</table>

<br>
<div style="text-align:center;">
<a href="dashboard.php">⬅ Back</a>
</div>

</body>
</html>
