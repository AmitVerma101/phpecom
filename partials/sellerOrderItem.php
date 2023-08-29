<?php 
    $orderid = $order['orderid'];
    $img = $order['img'];
    $title = $order['title'];
    $quantity = $order['quantity'];
    $total_price = $order['total_price'];
    $productid = $order['productid'];
    echo "
    <div class=\"admin-item-container\"  id = '$orderid'>
    <img class=\"item-img\" src='image/product/$img' alt=\"\">
    <div class=\"table\">
      <div class=\"tr\">
        <div class=\"td\">Title</div>
        <div class=\"td\">$title</div>
      </div>
      <div class=\"tr\">
        <div class=\"td\">Quantity</div>
        <div class=\"td\">$quantity</div>
      </div>
      <div class=\"tr\">
        <div class=\"td\">Total Price:</div>
        <div class=\"td\">₹$total_price</div>
      </div>
    </div>
    <div class=\"admin-btn-cluster\">
      <button class=\"update-btn admin-btn\" onclick=\"acceptOrder('$orderid','$productid','$quantity')\">SEND</button>
      <button class=\"delete-btn admin-btn\" onclick=\"rejectOrder('$orderid','$productid')\">REJECT</button>
    </div>
</div>  
    ";

?>
  