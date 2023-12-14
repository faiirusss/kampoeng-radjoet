<?php

require 'functions.php';

$code = $_GET['code'];

if (isset($code)) {
    $query = $conn->query("SELECT * FROM user WHERE verifikasi_code = '$code'");
    $result = $query->fetch_assoc();

    $conn->query("UPDATE user SET status=1 WHERE id = '" . $result['id'] . "'");
    echo "<script>alert('Verifikasi Berhasil, anda dapat Login!');window.location='login/login.php'</script>";
}
