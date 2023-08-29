<?php
  session_start();
  include 'config/database.php';
  include 'controller/OrderController.php';
  include 'model/OrderModel.php';
  $moreProductsArray = [];
  $OrderController = new OrderController($db,new OrderModel($db));
  # storing the order into the database
  $result = $OrderController->placeOrder($_SESSION['username']);
  $_SESSION['orderid'] = $result[0]['orderid'];
  $arr = [];
  foreach($result as $value){
    $arr[] = ['price'=>$value['stripe_price_id'],'quantity'=>$value['quantity']];
  }
 
require_once 'vendor/autoload.php';
// require_once '../secrets.php';
\Stripe\Stripe::setApiKey('sk_test_51MrFV1SFr8gJHZSEpyH8wYu6dBwbcR67JOMKWf7z7nsnMfb9Kjifnbn7m37NuozooTuXPe6Xb8efyPAVYu7EFG3500m9hId0zi');
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/myEcom';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => $arr,
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/thanks.php',
  'cancel_url' => $YOUR_DOMAIN . '/cart.php',
]);



echo json_encode(['response'=>$checkout_session->url,'status'=>'303']);
