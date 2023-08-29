<?php

class CartController {
    private $db;
    private $CartModel;

    public function __construct($db,$CartModel){
        $this->db = $db;
        $this->CartModel = $CartModel;
    }
   public function getQuantity($productId,$username){
       $result = $this->CartModel->getQuantity($productId,$username);
       return $result;
   
   }
   public function addItemToCount($productId,$username){
    $result = $this->CartModel->addItemToCount($productId,$username);
    return $result;
   }
   public function fetchCartProducts($username){
        $result = $this->CartModel->fetchCartProducts($username);
        $resultArray = [];
        if($result == false){
            return ['resultArray'=>$resultArray,'status'=>false];
        }
        while($row = pg_fetch_assoc($result)){
            $resultArray[] = $row;
        }
        return ['resultArray'=>$resultArray,'status'=>true];
   }
   public function removeItemFromCart($productId,$username){
        $result = $this->CartModel->removeItemFromCart($productId,$username);
        return $result;
   }
   public function emptyCart($username){
        $result = $this->CartModel->emptyCart($username);
        $name = createPdf($username);
        $path = "attatchment/$name";
        $res = sendMailWithAttatchment($result['email'],'Thank you for placing order','Order successful',$path,$name);
        return $res;
   }
}
?>