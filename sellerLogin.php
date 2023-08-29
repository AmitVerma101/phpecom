<?php 
    session_start();
    if(isset($_SESSION['username'])){
        header('Location: products.php');
    }
    include 'config/database.php';
    include 'controller/UserController.php';
    include 'model/userModel.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if ($data !== null) {
            $username = $data->userName;
            $password = $data->password;
            $userController = new UserController($db,new userModel($db));
            $result  = $userController->validateUser($username,$password);
            if($result == true){
                #create a session
                $_SESSION['username'] = $username;
                $_SESSION['pagination'] = 0;
                $_SESSION['user_type'] = 'seller';
                echo json_encode(['msg' => 'Login successfully']);
                exit;
            }
            else{
                echo json_encode(['error' => 'Login failed']);
                exit;
            }
         }
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/login.css">
    

<body>

    <?php include 'partials/header.php'; ?>

    <div class="main-container login-main">
        <h1 id="title" style="color: white;font-style: malvo-font-thin;font-weight: 200;">SIGN IN(Seller Page)</h1>
        <div class="form-container">
            <div id="inner-container">
                <p class="login-text blue-text">SIGN IN WITH ACCOUNT NAME</p>
                <input class="input-form" id="userName" name="userName" type="text" autocomplete="off" required>
                <p class="login-text">PASSWORD</p>
                <input class="input-form" name="password" id="password" type="password" autocomplete="off" required>
                <button id="submit-login" class="submit-btn submit">Sign in</button>
                <p id="err-msg">Please check your password and account name and try again.</p>
                <a href="forgetPasswordSeller.php" id="help-link">Help, I can't sign in</a>
            </div>
            <img class="form-img" src="image/login/master_chief.jpg" alt="">
        </div>
    </div>
</body>
<script src="javascript/sellerLogin.js" type="module"></script>
</html>