<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!='student'){
    die("Unauthorized");
}

$student_id = $_SESSION['user_id'];
$lecture_id = intval($_GET['lecture_id']);
$tid = intval($_GET['tid']);
$token = $_GET['token'];

/* VERIFY EXACT TOKEN ROW */
$res = mysqli_query($conn,"
    SELECT * FROM qr_tokens
    WHERE id='$tid' AND lecture_id='$lecture_id'
    LIMIT 1
");

if(mysqli_num_rows($res)==0){
    die("QR expired ❌");
}

$row = mysqli_fetch_assoc($res);

if($row['token'] !== $token){
    die("QR expired ❌");
}

/* CHECK DUPLICATE */
$chk = mysqli_query($conn,"
    SELECT * FROM attendance
    WHERE lecture_id='$lecture_id'
    AND student_id='$student_id'
");

if(mysqli_num_rows($chk)>0){
    die("Already marked ⚠️");
}

/* MARK ATTENDANCE */
mysqli_query($conn,"
    INSERT INTO attendance(lecture_id, student_id)
    VALUES('$lecture_id','$student_id')
");

/* DELETE USED TOKEN */
mysqli_query($conn,"
    DELETE FROM qr_tokens WHERE id='$tid'
");

/* NEW TOKEN FOR NEXT STUDENT */
$new = bin2hex(random_bytes(8));

mysqli_query($conn,"
    INSERT INTO qr_tokens(lecture_id, token)
    VALUES('$lecture_id','$new')
");

echo "<h2 style='color:green;text-align:center'>
Attendance Marked Successfully ✅
</h2>";
?>
