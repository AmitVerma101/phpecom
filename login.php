<?php 
    session_start();
    if(isset($_SESSION['username'])){
        header('Location: products.php');
    }
    require_once 'config/env.php';
    include 'config/database.php';
    include 'controller/UserController.php';
    include 'model/userModel.php';
    include 'utils/generalUtility.php';
    include 'utils/messages.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if ($data !== null) {
            $username = $data->userName;
            $password = $data->password;
            $userController = new UserController($db,new userModel($db));
            $result  = $userController->validateUser($username,$password);
           
            if($result['flag'] == '1'){
                #create a session
                $_SESSION['username'] = $username;
                $_SESSION['pagination'] = 0;
                if($result['isAdmin'] == '1'){
                    $_SESSION['user_type'] = 'admin';
                    // header('Location: adminDashboard.php');
                    echo json_encode(['error'=>false,'role'=>0,'redirect'=>APP_URL.'/adminDashboard.php']);
                    exit;
                }
                else {
                    $_SESSION['user_type'] = 'user';
                    // header('Location: products.php');

                    echo json_encode(['error'=>false,'role'=>1,'redirect'=>APP_URL.'/products.php']);
                    exit;
                }
            }
            else{
                echo json_encode(['error' => true]);
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
        <title>Login</title>
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/login.css">
    </head>

    <body>

        <?php include 'partials/header.php' ?>

        <div class="main-container login-main">
            <h1 id="title" style="color: white;font-style: malvo-font-thin;font-weight: 200;">SIGN IN</h1>
            <form class="form-container">
                <div id="inner-container">
                    <p class="login-text blue-text">SIGN IN WITH ACCOUNT NAME</p>
                    <input class="input-form" id="userName" name="userName" type="text" autocomplete="off" required>
                    <p class="login-text">PASSWORD</p>
                    <input class="input-form" name="password" id="password" type="password" autocomplete="off" required>
                    <input type="submit" id="submit-login" value="Sign in" class="submit-btn submit">
                    <p id="err-msg">Please check your password and account name and try again.</p>
                    <a href="forgetPassword.php" id="help-link">Help, I can't sign in</a>
                </div>
                <img class="form-img" src="image/login/master_chief.jpg" alt="">
            </form>
        </div>
        <div class="footer">
            <div class="text-div">
                <p class="dark-text">JOIN Steam and discover thousands of games to play.</p>
                <a class="h-link-white-blue" href="/info">Learn More</a>
            </div>
            <img id="footer-img" src="image/login/join_pc.png" alt="">
            <div class="btn-cluster">
                <button id="join-btn">Join Steam</button>
                <p class="dark-text">It's free and easy to use.</p>
            </div>
        </div>
    </body>
   <script src="javascript/login.js"></script>
</html>
