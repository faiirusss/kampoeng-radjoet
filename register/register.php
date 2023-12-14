<?php

require '../functions.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>

    <!-- CSS -->
    <link rel="stylesheet" href="register.css">

    <!-- BOX ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

</head>

<body>

    <div class="container">

        <form method="POST" action="../proses.php">

            <h2>Register</h2>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="username" id="username" placeholder="First name" autocomplete="off" autofocus required>
                    <label for="username" class="label">First name</label>
                </div>
                <div class="input-group">
                    <input type="text" name="username2" id="username2" placeholder="Last name" autocomplete="off" required>
                    <label for="username2" class="label">Last name</label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="email" name="email" id="email" placeholder="Email" autocomplete="off" required>
                    <label for="email" class="label">Email</label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password" pattern=".{8,}" id="password" placeholder="Password" required>
                    <label for="password" class="label">Password</label>
                    <img class="icon-input" src="../images/eye-close.png" id="eyeicon">
                </div>
                <div class="input-group">
                    <input type="password" name="password2" pattern=".{8,}" id="password2" placeholder="Confirm" required>
                    <label for="password" class="label">Confirm</label>
                    <img class="icon-input" src="../images/eye-close.png" id="eyeicon2">

                </div>
            </div>
            <span class="help-text">Use 8 or more characters with a mix of letters, numbers & <br>symbols</span>

            <button type="submit" name="register" class="btn-submit">Register</button>

            <span class="register-text">Already have an account? <a href="../login/login.php">Log in</a></span>

        </form>

    </div>

    <script>
        let eyeicon = document.getElementById('eyeicon')
        let eyeicon2 = document.getElementById('eyeicon2')
        let password = document.getElementById('password')
        let password2 = document.getElementById('password2')

        eyeicon.onclick = function() {
            if (password.type == "password") {
                password.type = "text"
                password2.type = "text"
                eyeicon.src = "../images/eye-open.png"
                eyeicon2.src = "../images/eye-open.png"
            } else {
                password.type = "password"
                password2.type = "password"
                eyeicon.src = "../images/eye-close.png"
                eyeicon2.src = "../images/eye-close.png"
            }
        }
    </script>
</body>

</html>