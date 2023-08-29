<?php 
    session_start();
    include 'config/database.php';
    include 'controller/OrderController.php';
    include 'model/OrderModel.php';
    $moreProductsArray = [];
    $OrderController = new OrderController($db,new OrderModel($db));
    
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        // $_SESSION['pagination'] = 0;
        // $pagination = $_SESSION['pagination'];
        $resultArray = $OrderController->fetchUserOrders($_SESSION['username']);
      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam/Order</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/userOrder.css">
</head>
<body>
    <?php include('partials/header.php') ?>
    <div>
        <div class="product-container">
                 <?php
                 forEach($resultArray as $item) {
                    include 'partials/orderItem.php';
                }
                ?> 
        </div>
    </div>
</body>
<script src="/javascript/sellerPage.js"></script>
</html>