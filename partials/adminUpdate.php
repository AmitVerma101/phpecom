<?php 
 
 $title = $item[0]['title'];
 $price = $item[0]['price'];
 $stock = $item[0]['quantity'];
 $userreview = $item[0]['userreview'];
 $description = $item[0]['description'];
echo "
    <div class=\"container\">
        <h1>$pageTitle</h1>
        <form action=\"$currentURL\" method=\"POST\" enctype=\"multipart/form-data\">
            <input class=\"input-form\" type=\"text\" name=\"title\" id=\"title\" placeholder=\"Enter Title\" title=\"Title\" value=\"$title\">
            <input class=\"input-form\" type=\"number\" name=\"price\" id=\"price\" placeholder=\"Enter Price\" title=\"Price\" value=\"$price\">
            <input class=\"input-form\" type=\"number\" name=\"stock\" id=\"stock\" placeholder=\"Enter Product Quantity\" title=\"Stocks\" value=$stock>
            <input class=\"input-form\" type=\"text\" name=\"about\" id=\"about\" placeholder=\"Enter description About Game\" title=\"About Game\" value=\"$description\">
            <label>Enter Cover Photo</label><input type=\"file\" name=\"product-img\" id=\"product-img\" accept=\"image/jpeg , image/png , image/jpg\" >
            <input class=\"submit submit-btn\" type=\"submit\" value=\"Save Product\" id=\"submit-btn\">
        </form>
    </div>
";
?>
