<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Teacher Dashboard</title>

<style>
:root{
    --bg-dark: linear-gradient(135deg,#0b132b,#0f213d,#152e4a);
    --card-dark: rgba(255,255,255,.07);
    --text-dark:#ffffff;

    --bg-light: linear-gradient(135deg,#e3f2fd,#ffffff);
    --card-light: rgba(255,255,255,.9);
    --text-light:#222222;
}

/* BODY */
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    transition:.3s;
}

/* MAIN CARD */
.container{
    border-radius:25px;
    padding:35px 45px;
    width:520px;
    text-align:center;
    backdrop-filter:blur(14px);
    transition:.3s;
}

/* HEADER */
.logo{
    width:80px;
}

/* INPUTS */
select{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    margin-top:10px;
    font-size:15px;
}

/* COMMON BUTTON STYLE */
.mainBtn{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    font-size:15px;
    margin-top:10px;
    text-align:center;
    cursor:pointer;
    display:block;
}

/* PRIMARY BUTTON */
.primaryBtn{
    background:#1a73e8;
    color:white;
}

/* SUCCESS BUTTON */
.successBtn{
    background:#14a44d;
    color:white;
}

/* LOGOUT LINK */
.logout{
    display:block;
    margin-top:10px;
    color:#ff7777;
    text-decoration:none;
}

/* FOOTER TEXT */
.footer{
    margin-top:15px;
    opacity:.8;
    font-size:13px;
}

/* ----- SMALL ROUND THEME TOGGLE ----- */
.themeToggle{
    position:fixed;
    top:18px;
    right:18px;
    width:40px;
    height:40px;
    border-radius:50%;
    border:2px solid rgba(255,255,255,.5);
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    font-size:18px;
    transition:.3s;
    backdrop-filter:blur(10px);
}

/* DARK MODE */
.dark{
    background:var(--bg-dark);
    color:var(--text-dark);
}
.dark .container{
    background:var(--card-dark);
    border:1px solid rgba(255,255,255,.2);
    box-shadow:0 15px 45px rgba(0,0,0,.6);
}
.dark .themeToggle{
    background:rgba(255,255,255,.1);
}

/* LIGHT MODE */
.light{
    background:var(--bg-light);
    color:var(--text-light);
}
.light .container{
    background:var(--card-light);
    border:1px solid rgba(0,0,0,.1);
    box-shadow:0 10px 30px rgba(0,0,0,.2);
}
.light .themeToggle{
    background:rgba(255,255,255,.8);
}
</style>

</head>

<body>

<!-- ROUND ICON THEME TOGGLE -->
<div class="themeToggle" onclick="toggleTheme()">🌙</div>

<div class="container">

    <img src="../assets/images/logo.png" class="logo">

    <h2>Teacher Dashboard</h2>
    <p>Welcome, <b><?php echo $_SESSION['name']; ?></b></p>

    <form method="post" action="start_lecture.php">

        <select name="subject_id" required>
            <option value="">Select Subject</option>
            <option value="1">DBMS</option>
            <option value="2">Java</option>
        </select>

        <select name="duration" required>
            <option value="5">5 Minutes</option>
            <option value="10">10 Minutes</option>
        </select>

        <button type="submit" class="mainBtn primaryBtn">
            Start Lecture & Generate QR
        </button>

    </form>

    <a href="add_student.php" class="mainBtn successBtn">
        ➕ Add New Student
    </a>

    <a href="../auth/logout.php" class="logout">Logout</a>

    <div class="footer">
        Secure Attendance Panel • RIT Roorkee
    </div>

</div>

<script>
/* Restore theme */
if(localStorage.getItem("theme")==="light"){
    document.body.classList.add("light");
    document.querySelector(".themeToggle").innerHTML="🌙";
}else{
    document.body.classList.add("dark");
    document.querySelector(".themeToggle").innerHTML="☀";
}

/* Toggle Theme */
function toggleTheme(){
    if(document.body.classList.contains("dark")){
        document.body.classList.remove("dark");
        document.body.classList.add("light");
        localStorage.setItem("theme","light");
        document.querySelector(".themeToggle").innerHTML="🌙";
    }else{
        document.body.classList.remove("light");
        document.body.classList.add("dark");
        localStorage.setItem("theme","dark");
        document.querySelector(".themeToggle").innerHTML="☀";
    }
}
</script>

</body>
</html>
