<?php
 
class SellerController {
    private $db;
    private $SellerModel;

    public function __construct($db,$SellerModel){
        $this->db = $db;
        $this->SellerModel = $SellerModel;
    }
   public function getOrders($username){
        $result = $this->SellerModel->getOrders($username);
        $finalResult = [];
        while($row = pg_fetch_assoc($result)){
            $finalResult[] = $row; 
        }
        return $finalResult;
   }
   public function fetchSellerProducts($username){
    $result = $this->SellerModel->fetchSellerProducts($username);
    return $result;
}

public function getProductDetails($id){
    $result = $this->SellerModel->getProductDetails($id);
    $resultArray = [];
    if(pg_num_rows($result)>0){
        $row = pg_fetch_assoc($result);
        $resultArray[] = $row;
    }
    return $resultArray;
}

public function updateSellerProduct($username,$usertype,$data){
    $result = $this->SellerModel->updateSellerProduct($username,$usertype,$data);
    return $result;
}

public function updateProduct($username,$usertype,$stripeData){
    $result = $this->SellerModel->updateProduct($username,$usertype,$stripeData);
    return $result;
}

public function addProduct($username,$usertype,$data){
    $result = $this->SellerModel->addProduct($username,$usertype,$data);
    return $result;
}

public function deleteProduct($productid){
    $result = $this->SellerModel->deleteProduct($productid);
    if($result !== false){
        return ['status'=>true,'code'=>200];
    }
    else {
        return ['status'=>false,'code'=>500];
    }
}
public function acceptOrder($orderid,$productid,$keyArray){
    $result = $this->SellerModel->acceptOrder($orderid,$productid,$keyArray);
    if($result == true){
        return ['status'=>true,'code'=>200];
    }
    else {
        return ['status'=>false,'code'=>401];
    }
}
public function rejectOrder($orderid,$productid){
    $result = $this->SellerModel->rejectOrder($orderid,$productid);
    if($result == true){
        return ['status'=>true,'code'=>200];
    }
    else {
        return ['status'=>false,'code'=>401];
    }
}


}
?>