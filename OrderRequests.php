<?php
    session_start();
    include 'config/database.php';
    include 'controller/OrderController.php';
    include 'model/OrderModel.php';
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $OrderController = new OrderController($db,new OrderModel($db));
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        header("Content-Type: application/json");
        if($data->type == 'placeOrder'){
            $result = $OrderController->placeOrder($_SESSION['username']);
                if($result == true){
                    echo json_encode(['status'=>'200']);
                }
                echo json_encode(['status'=>'403']);
                exit;
            
        }
        else {
            echo json_encode(['status'=>'200']);
        }
     }
     
?>