<?php
session_start();
include "../config/db.php";

/* ---- ONLY TEACHER CAN ACCESS ---- */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../auth/login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if ($name == "" || $email == "" || $password == "") {
        $message = "All fields are required ❌";
    } else {

        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "This email already exists ⚠️";
        } else {

            // HASH PASSWORD
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // INSERT
            $query = mysqli_query($conn,"
                INSERT INTO users(name,email,password,role)
                VALUES('$name','$email','$hashed','student')
            ");

            if ($query) {
                $message = "Student added successfully ✅";
            } else {
                $message = "Something went wrong ❌";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>

<style>
body{
    font-family:Arial;
    background:#0b132b;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    color:white;
}

.card{
    background:#ffffff10;
    padding:25px 30px;
    border-radius:15px;
    width:400px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
    backdrop-filter:blur(10px);
}

h2{
    text-align:center;
}

input{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:none;
    margin-top:8px;
    margin-bottom:12px;
}

button{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:none;
    background:#1a73e8;
    color:white;
    font-size:16px;
    cursor:pointer;
}

.msg{
    text-align:center;
    margin-bottom:10px;
}
</style>

</head>

<body>

<div class="card">
<h2>➕ Add New Student</h2>

<?php if($message!="") echo "<p class='msg'>$message</p>"; ?>

<form method="POST">

<label>Name</label>
<input type="text" name="name" placeholder="Student Name" required>

<label>Email</label>
<input type="email" name="email" placeholder="student@email.com" required>

<label>Password</label>
<input type="text" name="password" placeholder="Enter password" required>

<button type="submit">Add Student</button>

</form>

</div>

</body>
</html>
