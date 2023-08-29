<?php

class OrderController {
    private $db;
    private $OrderModel;

    public function __construct($db,$OrderModel){
        $this->db = $db;
        $this->OrderModel = $OrderModel;
    }
   public function placeOrder($username){
       $result = $this->OrderModel->placeOrder($username);
       return $result;
   
   }
   public function fetchUserOrders($username){
    $result = $this->OrderModel->fetchUserOrders($username);
    return $result;
   }
   public function confirmPaymentStatus($orderid){
    $result = $this->OrderModel->confirmPaymentStatus($orderid);
   }
   
}
?>