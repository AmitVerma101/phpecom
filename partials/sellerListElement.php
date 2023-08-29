<?php
$sellerid = $seller['sellerid'];

if(isset($seller['sellerid'])){
echo "<div id=\"$sellerid\">
    <div class=\"flex-row seller-title\">
        <h1 class=\"seller-heading\">$sellerid </h1>
        <button class=\"seller-title-btn\" onclick=\"deleteSellerBtn( '$sellerid')\">Delete Seller</button>
    </div>
    <div class=\"product-container\">
    ";
    
        forEach($seller['products'] as $item){
            include 'adminItem.php';
        }
    
           
  echo "  </div> 
</div>";
}?>