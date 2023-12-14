<?php

require 'functions.php';

$token = $_POST['token'];

$query = "SELECT * FROM user WHERE reset_token = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $token);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST['password']) < 8) {
    die("Password minimal memiliki 8 karakter!");
}

if ($_POST['password'] !== $_POST['password2']) {
    die("Password tidak sama!");
}

$password = $_POST['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password = ?,
            reset_token = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?
        ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user['id']);
$stmt->execute();

echo "<script>alert('Password Berhasil dirubah, silahkan login!');window.location='login/login.php'</script>";
