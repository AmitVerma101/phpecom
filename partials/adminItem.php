<?php 
    $productid = $item['productid'];
    $title = $item['title'];
    $price = $item['price'];
    $userreview = $item['userreview'];
    $stock = $item['quantity'];
    $img = $item['img'];
    $oldprices = $item['oldprices'];
  echo "
  <div class=\"admin-item-container\">
  ";
  include 'partialItemAdminSeller.php';
echo "
<div class=\"admin-btn-cluster\">
    <button class=\"delete-btn admin-btn\" onclick=\"deleteElementFromAdmin( '$productid' )\">Delete</button>
  </div>
</div>
";


?>



  
  
