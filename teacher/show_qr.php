<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['lecture_id'])) {
    die("Lecture ID missing");
}

$lecture_id = intval($_GET['lecture_id']);

$host = getHostByName(getHostName());
$app_folder = "qr-attendance";
?>
<!DOCTYPE html>
<html>
<head>
<title>Live QR Attendance</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', Arial;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    background:linear-gradient(135deg,#0b132b,#0f213d,#152e4a);
}

/* Glass Card */
.card{
    background:rgba(255,255,255,0.07);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:25px;
    padding:35px 45px;
    text-align:center;
    width:460px;
    box-shadow:0 15px 45px rgba(0,0,0,.6);
    backdrop-filter:blur(14px);
}

/* Title */
.card h2{
    margin:0;
    font-size:26px;
}

/* QR */
.qr-box{
    margin-top:12px;
}
.qr{
    background:white;
    border-radius:16px;
    padding:12px;
    transition:opacity .3s ease-in-out;
}

/* Timer */
.timerRing{
    width:90px;
    height:90px;
    border-radius:50%;
    border:5px solid rgba(255,255,255,.25);
    margin:20px auto 10px;
    display:flex;
    justify-content:center;
    align-items:center;
    animation: glow 2s infinite ease-in-out;
}
@keyframes glow{
    0%{ box-shadow:0 0 10px cyan;}
    50%{ box-shadow:0 0 25px cyan;}
    100%{ box-shadow:0 0 10px cyan;}
}

#timer{
    font-size:24px;
    font-weight:bold;
}

/* Notes */
.note{
    font-size:14px;
    opacity:.9;
}
.footer{
    font-size:13px;
    opacity:.7;
}
</style>

<script>
let counter = 10;

/* ====== REFRESH QR WITH TOKEN + ID ====== */
function refreshQR(){

    fetch("get_latest_token.php?lecture_id=<?php echo $lecture_id; ?>")
    .then(res => res.text())
    .then(data => {

        let parts = data.split("|");
        let tid = parts[0];      // token id
        let token = parts[1];    // token

        let qrData =
        "http://<?php echo $host; ?>/<?php echo $app_folder; ?>/student/mark_attendance.php?lecture_id=<?php echo $lecture_id; ?>&tid="+tid+"&token="+token;

        let qr = document.getElementById("qr");

        qr.style.opacity = 0;

        setTimeout(()=>{
            qr.src =
            "https://api.qrserver.com/v1/create-qr-code/?size=310x310&data=" +
            encodeURIComponent(qrData);
            qr.style.opacity = 1;
        },200);

        counter = 10;
    });
}

/* ===== COUNTDOWN DISPLAY ===== */
setInterval(()=>{
    document.getElementById("timer").innerHTML = counter;

    if(counter === 0){
        refreshQR();
    }

    counter--;

},1000);
</script>

</head>

<body>

<div class="card">

    <h2>📷 Scan Attendance QR</h2>

    <div class="qr-box">
        <img id="qr" class="qr" width="310">
    </div>

    <div class="timerRing">
        <span id="timer">10</span>
    </div>

    <div class="note">
        QR auto refresh every 10 seconds
    </div>

    <div class="footer">
        Secure Token System • RIT Roorkee
    </div>

</div>

<script>
refreshQR();
</script>

</body>
</html>
