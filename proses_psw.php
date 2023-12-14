<?php

require 'functions.php';

$email = mysqli_escape_string($conn, $_POST['email']);
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

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
    $mail->addAddress($email, 'admin');     //Add a recipient

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Recovery Password';
    $mail->Body    = 'Hi, ' . $email . ' ini adalah link untuk recovery password anda, <br/> Silahkan klik!
    <a href="http://localhost/phpmail/verif_psw.php?token=' . $token_hash . '">disini</a>';

    if ($mail->send()) {
        $conn->query("UPDATE user SET reset_token = '$token_hash', reset_token_expires_at = '$expiry' WHERE email = '$email'");
        echo "<script>alert('Silahkan cek email anda untuk mengakses link recovery akun anda!');window.location='login/login.php'</script>";
    }
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
