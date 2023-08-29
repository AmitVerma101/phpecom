<?php 
session_start();
    include 'config/database.php';
    
    include 'controller/CartController.php';
    include 'model/CartModel.php';
    $moreProductsArray = [];
    $CartController = new CartController($db,new CartModel($db));
    
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $_SESSION['pagination'] = 0;
        $pagination = $_SESSION['pagination'];
        $result = $CartController->fetchCartProducts($_SESSION['username']);
        $resultArray = $result['resultArray'];
        if($result['status'] == false){
            echo 'some error occurs';
            
        }
       

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam/Cart</title>
    <link rel="stylesheet" href="css/general.css" >
    <link rel="stylesheet" href="css/cart.css">
    <script src="https://js.stripe.com/v3/" async></script>
</head>
<body>
    <?php include('partials/header.php'); ?>
    <div class="main-container">
        <div class="title-div">
            <h1 class="title">Cart</h1>
        </div>
        <br>
        <div class="item-container">
            <!-- <% for(key in items){%>
                <%- include('partials/cartItem',({"item":items[key]}))%>
                <%}%> -->
                <?php
                 forEach($resultArray as $item){
                    include 'partials/cartItem.php';
                }
                ?>
                
                <div class='inner-item-container buy-container'>
                    <!-- <div id="price">
                        <p>Estimated Total:</p> 
                        <p id="price-p">₹ <%=price%></p>
                    </div> -->
                    <div class='buy-btn-cluster'>
                           
                        <button class="buy-btn-comm" id="buy-btn">Purchase for myself</button>
                        <form action="handlePayments.php" method="post">
                       

</form>
                        <!-- <button class="buy-btn" id="buy-for-other">Purchase as a gift.</button> -->
                    </div>
                   
                </div>
                <div class='inner-item-container continue-shopping'>
                    <p>All Price include VAT where applicable</p>
                    <button class='blue-btn' onclick="window.location.href='products.php'">Continue Shopping</button>
                </div>
                <h3 class="delivery-info-title">DELIVERY</h3>
                <div class='inner-item-container delivery-info'>
                    <div class="flex-row" style="gap:10px">
                        <div class="cart-img-container">
                            <img class="cart-img" src="image/cart/ico_steam_cart.png" alt="">
                        </div>
                        <div>
                            <h4>All digital goods are delivered via the Steam desktop application.</h4>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</body>
<script src="javascript/cart.js"></script>

</html>