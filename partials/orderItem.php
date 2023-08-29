
<?php
    $img = $item['img'];
    $title = $item['title'];
    $quantity = $item['quantity'];
    $order_status = $item['order_status'];
    $payment_status = $item['payment_status'];
     $game_key = $item['game_key'];
 echo "<div class=\"admin-item-container\">
    <img class=\"item-img\" src=\"image/product/$img\" alt=\"\">
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
      <div class=\"td\">Order Status</div>
      <div class=\"td\">$order_status</div>
    </div>
     <div class=\"tr\">
    <div class=\"td\">Payment Status</div>
    <div class=\"td\">$payment_status</div>
  </div>";
  if(count($game_key)>0){
 echo "<div class=\"seller-msg seller-msg-rejected\">
  <p>
    <select class=\"product-key\">";
      foreach($game_key as $val){ 

       echo "<option>$val</option>";
      }
   echo " </select>
  </p>
</div>";
    }

    echo "</div>
   
        <div class=\"seller-msg seller-msg-rejected\">
         
        </div>
    
  </div>";
  ?>