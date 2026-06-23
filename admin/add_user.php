<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    mysqli_query($conn, "
        INSERT INTO users (name, email, password, role)
        VALUES ('$name', '$email', '$password', '$role')
    ");

    echo "<p>User added successfully ✅</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body style="text-align:center; margin-top:60px;">

<h2>Add Teacher / Student</h2>

<form method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <select name="role" required>
        <option value="">Select Role</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Add User</button>
</form>

<br>
<a href="dashboard.php">⬅ Back</a>

</body>
</html>
