<?php 
$productid = $item['productid'];
$img = $item['img'];
$title = $item['title'];
$price = $item['price'];
$userreview = $item['userreview'];
$stock = $item['quantity'];
?>
    <div class="admin-item-container">
    <?php include('partialItemAdminSeller.php')?>
    <div class="admin-btn-cluster">
      <?php echo "<button class=\"update-btn admin-btn\" onclick=\"updateProduct('$productid')\">Update</button>
        <button class=\"delete-btn admin-btn\" onclick=\"deleteProduct('$productid')\">Delete</button>"?>
    </div>
    </div>






