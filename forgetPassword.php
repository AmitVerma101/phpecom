<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/forgetPassword.css">
</head>
<body>
    <?php include 'partials/header.php' ?>
    <div class="main-container">
        <div class="container">
            <h2 class="text">Forget Password</h2>
            <p>Enter your email address</p>
            <input class="input-form" type="text" name="email" id="email" placeholder="Enter you email" required>
            <p id="err-msg">This is Dummy Text</p>
            <button class="submit-btn" type="submit" id="submit">Send</button>
        </div>
    </div>
</body>
<script src="javascript/forgetPassword.js" type="module"></script>
</html>