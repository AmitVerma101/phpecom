<?php 
    session_start();
    include 'config/database.php';
    include 'controller/SellerController.php';
    include 'model/SellerModel.php';
    $SellerController = new SellerController($db,new SellerModel($db));
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
           $result = $SellerController->getOrders($_SESSION['username']);
           
        //    echo $result[0]['title'];
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if ($data !== null) {
            if($data->type == 'resolve'){
                $orderid = $data->orderid;
                $productid = $data->productid;
                $keyArray = $data->keyArray;
                echo json_encode($SellerController->acceptOrder($orderid,$productid,$keyArray));
                exit;
                
            }else if($data->type == 'reject'){
                $orderid = $data->orderid;
                $productid = $data->productid;
                echo json_encode($SellerController->rejectOrder($orderid,$productid));
                exit;
            }
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
                foreach($result as $order){
                    include 'partials/sellerOrderItem.php';
                }
            ?> 
            <!-- <% for(key in order){ %>
                        <%- include('partials/sellerOrderItem',({"img":order[key].img,"title":order[key].title,"id":order[key].SubOrderId,"quantity":order[key].quantity,"price":order[key].price})); %>
            <%}%> -->
        </div>
    </div>
</body>
<script src="javascript/sellerPageOrder.js"></script>
</html>