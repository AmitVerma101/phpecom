<?php 
$productid = $item['productid'];
$quantity = $item['quantity'];
$img = $item['img'];
$title = $item['title'];
$price = $item['price'];

echo "<div id=\"$productid\" class='inner-item-container'>
    <div class='flex-row' style=\"gap:10px;align-items:center\">
        <div class=\"item-img-container\">
            <img class=\"item-img\" src=\"image/product/$img \">
        </div>
    </div>
    <div class=\"title-window\">
        <h2 class=\"item-title dark-text\">$title</h2>
        <div>
            <svg class=\"svg-window\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" x=\"0px\" y=\"0px\" class=\"SVGIcon_Button SVGIcon_WindowsLogo\" viewBox=\"0 0 128 128\" enable-background=\"new 0 0 128 128\"><rect fill=\"#FFFFFF\" width=\"60.834\" height=\"60.835\"></rect><rect x=\"67.165\" fill=\"#FFFFFF\" width=\"60.835\" height=\"60.835\"></rect><rect y=\"67.164\" fill=\"#FFFFFF\" width=\"60.834\" height=\"60.836\"></rect><rect x=\"67.165\" y=\"67.164\" fill=\"#FFFFFF\" width=\"60.835\" height=\"60.836\"></rect></svg>
        </div>
    </div>
    <div class=\"footer-cluster\">
        <div class=\"priceQuantity\">
            <span class=\"item-quantity\">$quantity</span>
            <p>₹ $price</p>
            <button onclick=\"deleteFromCart('$productid')\" class=\"remove-btn cart-btn\">Remove</button>
        </div>
        <button onclick=\"increaseQuantity('$productid')\" class=\"item-plus item-btn\">Add More</button>
        <button onclick=\"decreaseQuantity('$productid')\" class=\"item-minus item-btn\">Remove One</button>
    </div>
</div>"

?>