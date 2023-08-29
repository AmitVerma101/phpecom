<?php 
    session_start();
    if(!isset($_SESSION['orderid'])){
        header('Location: cart.php');
    }

    $username = $_SESSION['username'];
    // echo $username;
    #setting payment status to paid
    include 'utils/pdfmaker.php';
    
    include 'config/database.php';
    include 'controller/OrderController.php';
    include 'model/OrderModel.php';
    include 'config/database.php';
    include 'utils/generalUtility.php';
    include 'controller/CartController.php';
    include 'model/CartModel.php';
    $moreProductsArray = [];
    $OrderController = new OrderController($db,new OrderModel($db));
    $CartController = new CartController($db,new CartModel($db));

    $orderid = $_SESSION['orderid'];
    $res = $OrderController->confirmPaymentStatus($orderid);
    $result = $CartController->emptyCart($_SESSION['username']);
    unset($_SESSION['orderid']);
    //  echo $result;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks!!!</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/thanks.css">
</head>
<body>
    <?php include('partials/header.php')?>
    <div class="main-container">
        <div class="inner-container">
            <h1>Thanks, <?php echo $username ?></h1>
            <p>
                Dear valued customer,
            </p>
            <p>
                I would like to extend my sincerest gratitude for choosing to purchase a game from our website. Your support is what helps us continue to offer high-quality games and excellent customer service. We hope you are enjoying your purchase and that it meets all of your expectations.
            </p>
            <p>
                At our company, we take pride in delivering the best products and services to our customers, and your satisfaction is our top priority. If you have any questions or concerns, please do not hesitate to contact us, and we will be more than happy to assist you in any way we can.
            </p>
            <p>Once again, thank you for your business, and we hope to have the opportunity to serve you again in the future.</p>
            <p>
                Best regards,
                <br>
                Steam
            </p>
            <img class="img" src="image/login/logo_steam.svg" alt="">
        </div>
    </div>
</body>
</html>