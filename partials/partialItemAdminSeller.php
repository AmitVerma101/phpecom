


<?php echo "<img class=\"item-img\" src='image/product/$img' alt=\"\">
  <div class=\"table\">
    <div class=\"tr\">
      <div class=\"td\">Title</div>
      <div class=\"td\">$title</div>
    </div>
    <div class=\"tr\">
      <div class=\"td\">Price</div>
      <div class=\"td\">
       $price
    </div>
</div>
    
   
    <div class=\"tr\">
      <div class=\"td\">UserReviews</div>
      <div class=\"td\">$userreview</div>
    </div>
    <div class=\"tr\">
      <div class=\"td\">Stock</div>
      <div class=\"td\">$stock</div>
    </div>
  </div>";
  if(count($item['oldprices'])>0){
    echo "<div class = \"tr\"><div class = \"td\">Old Pricing: </div>";
    echo "<div class = \"td\"> <select>";
    foreach($item['oldprices'] as $val){
      echo "<option><span style=\"margin-right:20px;\">$val[0]</span>  <span>$val[1]</span></option>";
    }
   echo  "</select></div></div>";
  }
  ?>