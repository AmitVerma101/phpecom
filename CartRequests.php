<?php
    session_start();
    include 'config/database.php';
    include 'controller/CartController.php';
    include 'model/CartModel.php';
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $CartController = new CartController($db,new CartModel($db));
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if($data->type == 'getQuantity'){
            $quantity = $CartController->getQuantity($data->productId,$_SESSION['username']);
                // echo('In Quantity'.$quantity);
                echo pg_fetch_assoc($quantity)['quantity'];
                exit;
            
        }else if($data->type == 'incrementCount'){
            $result = $CartController->addItemToCount($data->productId,$_SESSION['username']);
            echo json_encode($result);
            exit;
            // if($result){
            //     echo json_encode(['code'=>'201']);
            // }
            // else {
            //     echo json_encode(['code'=>'204']);
            // }
        }
        else if ($data->type == 'removeFromCart'){
            $result = $CartController->removeItemFromCart($data->productId,$_SESSION['username']);
            if($result){
                echo json_encode(['status'=>'201']);
            }
            else {
                echo json_encode(['status'=>'404']);
            }
            exit;
        }
     }
     
?>