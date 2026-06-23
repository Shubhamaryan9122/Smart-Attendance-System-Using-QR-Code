<?php
$role = $_GET['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RIT Attendance Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<!-- ===== HEADER ===== -->
<div class="header">
    <img src="../assets/images/logo.png" alt="RIT Logo">
    <div>
        <div class="title">Roorkee Institute of Technology</div>
        <div class="subtitle">Official Attendance Page</div>
    </div>
</div>

<!-- ===== PAGE ===== -->
<div class="page">
    <div class="login-card">
        <h2>Attendance System</h2>

        <form method="post" action="login_process.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="hidden" name="role" value="<?php echo $role; ?>">

            <button type="submit">Sign In</button>
        </form>
    </div>
</div>

</body>
</html>
