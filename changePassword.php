<?php 
    session_start();
    include 'config/database.php';
    include 'controller/UserController.php';
    include 'model/UserModel.php';
    $UserController = new UserController($db,new UserModel($db));


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if ($data !== null) {
            $password = $data->password;
            $result = $UserController->updatePassword($password,$_SESSION['username']);
            echo json_encode($result);
            exit;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam/ChangePassword</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/forgetPassword.css">
</head>
<body>

    <?php include('partials/header.php') ?>

    <div class="main-container">
        <div class="container">
            <h2 class="text">Change Password</h2>
            <p>Enter password</p>
            <input class="input-form" type="password" id="password1" name="password1" placeholder="New Password" required>
            <p>Confirm password</p>
            <input class="input-form" type="password" id="password2" name="password2" placeholder="Confirm Password" required>
            <p id="err-msg">This Is Dummy Text</p>
            <button class="submit-btn" id="submit-btn">Submit</button>
        </div>
    </div>
</body>
<script src="javascript/changePassword.js" type="module"></script>
</html>