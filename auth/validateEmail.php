<?php 
   include '../config/database.php';
   include '../controller/UserController.php';
   include '../model/userModel.php';
   include '../config/env.php';

   $userController = new UserController($db,new UserModel($db));
   $result = $userController->validateEmail($_REQUEST['code']);
   if($result == true){
      $url = APP_URL;
    header("Location: $url/login.php");
   }
   else {
    echo "Email verification failed";
   }

?>