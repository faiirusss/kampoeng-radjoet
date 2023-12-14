<?php

require 'functions.php';

$username = strtolower(stripslashes($_POST['username'])) . strtolower(stripslashes($_POST['username2']));
$email = mysqli_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$password2 = mysqli_real_escape_string($conn, $_POST['password2']);
$code = md5($email . date('Y-m-d H:i:s'));
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$users = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
if (mysqli_num_rows($users) === 1) {
    echo "<script>alert('Email telah terdaftar, silahkan gunakan email yang berbeda!');window.location='register/register.php'</script>";
    return false;
}

if ($password !== $password2) {
    echo "<script>alert('Password tidak sesuai!');window.location='register/register.php'</script>";
    return false;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fairussalimi123@gmail.com';
    $mail->Password   = 'lxsfgqnxzsqqnfwj';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('fairussalimi123@gmail.com', 'Kampoeng Radjoet');
    $mail->addAddress($email, $username);     //Add a recipient

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Verifikasi Akun';
    $mail->Body    = 'Hi, ' . $username . ' Terima Kasih sudah mendaftar di website ini, <br/> Silahkan verifikasi akun anda!
    <a href="http://localhost/phpmail/verif.php?code=' . $code . '">Verifikasi</a>';

    if ($mail->send()) {

        $conn->query("INSERT INTO user(username, email, password, verifikasi_code)VALUES('$username', '$email', '$password_hash', '$code')");

        echo "<script>alert('Registrasi Berhasil, silahkan cek email anda untuk Verifikasi Akun!');window.location='login/login.php'</script>";
    }
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
