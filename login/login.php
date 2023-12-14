<?php
session_start();
require '../functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key =  $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT email FROM user WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['email'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email = ?");

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $verif = mysqli_fetch_assoc($result);

        // Verify the password using password_verify
        if (password_verify($password, $verif['password'])) {
            if ($verif['status'] == 1) {
                // Set sessions
                $_SESSION["login"] = $verif;
                if (isset($_POST["remember"])) {
                    // buat cookie
                    setcookie('id', $row['id'], time() + 60);
                    setcookie('key', hash('sha256', $row['email']), time() + 60);
                }
                echo "<script>alert('Login Berhasil!');window.location='../index.php'</script>";
            } else {
                echo "<script>alert('Harap Verifikasi akun anda!');window.location='../login/login.php'</script>";
            }
        } else {
            echo "<script>alert('Email atau Password Salah!');window.location='../login/login.php'</script>";
        }
    } else {
        echo "<script>alert('Email atau Password Salah!');window.location='../login/login.php'</script>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="login.css">

    <!-- BOX ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container">

        <form method="POST" action="">

            <h2>Login</h2>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="email" id="email" placeholder="Enter email" autocomplete="off" autofocus required>
                    <label for="email" class="label">Email</label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password" pattern=".{8,}" id="password" placeholder="Your password" required>
                    <label for="password" class="label">Password</label>
                    <img class="icon-input" src="../images/eye-close.png" id="eyeicon">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" class="remember">Remember me</label>
                <label class="forgot-pass"><a href="forgot_psw.php">Forgot password?</a></label>
            </div>

            <button type="submit" class="btn-submit" name="login">Log In</button>

            <span class="register-text">Don’t have an account? <a href="../register/register.php">Register</a></span><br>
            </a></span>

        </form>

    </div>

    <script>
        let eyeicon = document.getElementById('eyeicon')
        let password = document.getElementById('password')

        eyeicon.onclick = function() {
            if (password.type == "password") {
                password.type = "text"
                eyeicon.src = "../images/eye-open.png"
            } else {
                password.type = "password"
                eyeicon.src = "../images/eye-close.png"
            }
        }
    </script>

</body>

</html>