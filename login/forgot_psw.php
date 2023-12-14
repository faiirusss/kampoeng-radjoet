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

        <form method="POST" action="../proses_psw.php">
            <h2>Recovery Password</h2>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="email" id="email" placeholder="Enter email" autocomplete="off" autofocus required>
                    <label for="email" class="label">Email</label>
                </div>
            </div>

            <button type="submit" class="btn-submit" name="kirim">Submit</button>

        </form>

    </div>

</body>

</html>