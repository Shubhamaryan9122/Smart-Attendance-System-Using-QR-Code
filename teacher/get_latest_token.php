<?php
include "../config/db.php";

$lecture_id = intval($_GET['lecture_id']);

$res = mysqli_query($conn,"
    SELECT id, token FROM qr_tokens
    WHERE lecture_id='$lecture_id'
    ORDER BY id DESC
    LIMIT 1
");

if(mysqli_num_rows($res)==0){

    $token = bin2hex(random_bytes(8));

    mysqli_query($conn,"
        INSERT INTO qr_tokens(lecture_id, token)
        VALUES('$lecture_id','$token')
    ");

    $id = mysqli_insert_id($conn);

} else {
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];
    $token = $row['token'];
}

echo $id.'|'.$token;
?>
