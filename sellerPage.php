<?php 
     session_start();
     $username = $_SESSION['username'];
     include 'config/database.php';
     include 'controller/SellerController.php';
     include 'model/SellerModel.php';
     $moreProductsArray = [];
     $SellerController = new SellerController($db,new SellerModel($db));
    //  $pagination ;
     if($_SERVER['REQUEST_METHOD'] === 'GET'){
        //  $_SESSION['pagination'] = 0;
        //  $pagination = $_SESSION['pagination'];
         $resultArray = $SellerController->fetchSellerProducts($_SESSION['username']);
 
     }
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if ($data !== null) {
            $productid = $data->productid;
            return $SellerController->deleteProduct($productid);
        }
     }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/sellerPage.css">
</head>
<body>
    <?php include('partials/header.php') ?>
    <div> 
        <div class="product-container">
        <?php 
            foreach ($resultArray as $item) {
                include 'partials/sellerItem.php';
             }
            

           ?>
        </div>
    </div>
  <?php echo " <div id=\"addNewProduct\" onclick=\"newProductPage('$username')\">";?>
        <div id="vertical" class="buttonline"></div>
        <div id="horizontal" class="buttonline"></div>
    </div>
</body>
<script src="javascript/sellerPage.js"></script>
</html>