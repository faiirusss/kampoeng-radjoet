<?php

require 'functions.php';

$token = $_GET['token'];

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <!-- CSS -->
    <link rel="stylesheet" href="login/login.css">

    <!-- BOX ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container">
        <form method="POST" action="recovery_psw.php">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token) ?>">
            <h2>Reset Password</h2>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password" pattern=".{8,}" id="password" placeholder="Your password" required>
                    <label for="password" class="label">Password</label>
                    <img class="icon-input" src="images/eye-close.png" id="eyeicon">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password2" pattern=".{8,}" id="password2" placeholder="Confirm password" required>
                    <label for="password" class="label">Confirm Password</label>
                    <img class="icon-input" src="images/eye-close.png" id="eyeicon2">
                </div>
            </div>

            <button type="submit" class="btn-submit" name="send">Submit</button>
        </form>
    </div>
</body>
<script>
    let eyeicon = document.getElementById('eyeicon')
    let eyeicon2 = document.getElementById('eyeicon2')
    let password = document.getElementById('password')
    let password2 = document.getElementById('password2')

    eyeicon.onclick = function() {
        if (password.type == "password") {
            password.type = "text"
            password2.type = "text"
            eyeicon.src = "images/eye-open.png"
            eyeicon2.src = "images/eye-open.png"
        } else {
            password.type = "password"
            password2.type = "password"
            eyeicon.src = "images/eye-close.png"
            eyeicon2.src = "images/eye-close.png"
        }
    }
</script>

</html>