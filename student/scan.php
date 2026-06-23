<!DOCTYPE html>
<html>
<head>
<title>Scan QR</title>
<script src="https://unpkg.com/html5-qrcode"></script>

<style>
body{
    background:#0b1c2d;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    color:white;
    font-family:Arial;
}
.box{
    background:white;
    color:black;
    padding:25px;
    border-radius:15px;
    text-align:center;
}
</style>

</head>
<body>

<div class="box">
    <h2>Scan QR Code</h2>

    <div id="reader" style="width:300px;"></div>

    <p>Point your camera towards teacher's QR Code</p>
</div>

<script>
function onScanSuccess(decodedText, decodedResult) {

    // redirect scanned URL
    window.location.href = decodedText;
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", 
    { fps: 10, qrbox: 250 });

html5QrcodeScanner.render(onScanSuccess);
</script>

</body>
</html>
