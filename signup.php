<?php 
     session_start();
     if(isset($_SESSION['username'])){
        header('Location: products.php');
    }
    include 'utils/generalUtility.php';
    include 'utils/messages.php';
    include 'config/database.php';
    include 'controller/UserController.php';
    include 'model/userModel.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        // header("Content-Type: application/json");
        if ($data !== null) {
            $obj = array('name'=>$data->name,'userName'=>$data->userName,'email'=>$data->email,'password'=>$data->password);
            $userController = new UserController($db,new userModel($db));
            $result  = $userController->registerUser($obj);
            if($result['status'] == true){
                echo json_encode($result);
                exit;
            }
            else{
                echo json_encode($result);
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
    <link rel="stylesheet" href="css/signup.css">
<body>

    <?php include 'partials/header.php'?>

    <div class="main-container signup-main">
            <div class=" flex-column inner-container">
                <h1 class="signup-title">CREATE YOUR ACCOUNT</h1>
                <div>
                    <p class="login-text">Email Address</p>
                    <input class="input-form" type="email" name="email" id="email" pattern=".+@+.com" required autocomplete="off">
                </div>
                <div>
                    <p class="login-text">Enter Name</p>
                    <input class="input-form" type="text" name="name" id="name" required autocomplete="off">
                </div>
                <div>
                    <p class="login-text">Enter User Name</p>
                    <input class="input-form" type="text" name="userName" id="userName" required autocomplete="off">
                </div>
                <div>
                    <p class="login-text">Enter Password</p>
                    <input class="input-form" type="password" name="password" id="password1" required autocomplete="off">
                </div>
                <div>
                    <p class="login-text">Confirm your Password</p>
                    <input class="input-form" type="password" name="password2" id="password2" required autocomplete="off">
                </div>
                <div id="tos-container">
                    <input id="tos-checkbox" type="checkbox"><p class="dark-text" id="term-of-service">I am 13 years of age or older and agree to the <a class="h-link-white-blue">terms of the Steam Subscriber Agreement</a> and the <a class="h-link-white-blue">Valve Privacy Policy</a>.</p>
                </div>
                <p id="err-msg">This is dummy text</p>
                <button class="submit-btn submit" id="submit-btn-signup">Submit</button>
            </div>
    </div>
</body>
<script src="javascript/signup.js" type="module"></script>
</html>
