<?php 
session_start();
include 'utils/generalUtility.php';
include 'utils/messages.php';
include 'config/database.php';
include 'controller/AdminController.php';
include 'model/AdminModel.php';
$AdminController = new AdminController($db,new AdminModel($db));
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $result = $AdminController->getAllSellers();
   
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data);
    header("Content-Type: application/json");
    if($data !== null){
        if($data->type == 'delete'){
            $username = $data->username;
            $result = $AdminController->deleteSeller($username);
            echo json_encode($result);
            exit;
        }
        else if($data->type == 'deleteProduct'){
            $productid = $data->productid;
            $result = $AdminController->deleteProduct($productid);
            echo json_encode($result);
            exit;
        }
        else{$email = $data->email;
        $result = $AdminController->addNewSeller($email);
        echo json_encode($result);
        exit;}
    }
   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam/Admin</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <?php include('partials/header.php')?>
    <div class="main-container">
      
        <div class="seller-container">
            <?php 
                foreach($result as $key){
                    foreach($key as $seller){
                        include 'partials/sellerListElement.php';
                    }
                   
                }
            
            ?>
           
        </div>
    </div>
    <div id="addNewSeller">
        <div id="vertical" class="buttonline"></div>
        <div id="horizontal" class="buttonline"></div>
    </div>
    <!-- <div id="newSellerDiv">
        <h2 class="seller-heading">Enter Seller Email</h2>
        <input onclick="window.event.stopPropagation()" class="input-form" onkeydown="checkKey()" id="email" type="email" placeholder="Enter Seller Email" title="Seller Email">
        <p id="err-msg">This Is Dummy Error</p>
        <button class="submit-btn submit" id="seller-add-btn">Send Invite</button>
    </div>  -->
</body>
<script src="javascript/adminDashboard.js"  ></script>
</html>