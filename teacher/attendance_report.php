<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit;
}

$lecture_id = $_GET['lecture_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="table-card">
    <h2 style="text-align:center;">Attendance Report</h2>

    <table>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Scan Time</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "
            SELECT users.name, users.email, attendance.scan_time
            FROM attendance
            JOIN users ON attendance.student_id = users.id
            WHERE attendance.lecture_id = '$lecture_id'
        ");

        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>$i</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['scan_time']}</td>
                  </tr>";
            $i++;
        }

        if ($i == 1) {
            echo "<tr><td colspan='4'>No attendance yet</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="dashboard.php">⬅ Back</a>
</div>

</body>
</html>
